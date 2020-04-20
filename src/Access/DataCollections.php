<?php

namespace srag\Plugins\SrPluginInfosFetcher\Access;

use ilDateTime;
use ilDclBaseRecordFieldModel;
use ilDclTable;
use ilExcel;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Info\PluginInfo;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class DataCollections
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class DataCollections
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * DataCollections constructor
     */
    private function __construct()
    {

    }


    /**
     * @param int $table_id
     *
     * @return PluginInfo[]
     */
    public function getPlugins(int $table_id) : array
    {
        $plugins = [];

        $data_collection_table = new ilDclTable($table_id);

        $records = $data_collection_table->getRecords();

        foreach ($records as $record) {
            $plugin = new PluginInfo();

            $fields = $record->getRecordFields();

            foreach ($fields as $field) {
                $property = $this->mapFieldTitleToProperty($field);

                if ($property !== null) {
                    $value = $this->getValueFromField($property, $field);

                    $plugin->setProperty($property, $value);
                }
            }

            if ($plugin->hasRequiredValues()) {
                $plugins[] = $plugin;
            }
        }

        return $plugins;
    }


    /**
     * @param int            $table_id
     * @param PluginInfo[][] $updated_plugins
     *
     * @param int
     */
    public function updatePlugins(int $table_id, array $updated_plugins) : int
    {
        $updated_plugins_count = 0;

        $data_collection_table = new ilDclTable($table_id);

        $records = $data_collection_table->getRecords();

        /**
         * @var PluginInfo $old_plugin
         * @var PluginInfo $new_plugin
         */
        foreach ($updated_plugins as list($old_plugin, $new_plugin)) {
            // Find plugin record
            $plugin_record = null;
            $plugin_record_found = false;
            foreach ($records as $plugin_record) {
                $fields = $plugin_record->getRecordFields();

                foreach ($fields as $field) {
                    $property = $this->mapFieldTitleToProperty($field);

                    if ($property === "plugin_id") {
                        $value = $this->getValueFromField($property, $field);

                        if ($value === $old_plugin->getPluginId()) {
                            $plugin_record_found = true;
                        }

                        break;
                    }
                }

                if ($plugin_record_found) {
                    break;
                }
            }

            if ($plugin_record_found && $plugin_record !== null) {
                $changed = false;

                $fields = $plugin_record->getRecordFields();

                foreach ($new_plugin->getPropertyNames() as $property) {

                    foreach ($fields as $field) {

                        $field_title = $this->mapPropertyToFieldTitle($property);

                        // Find property field
                        if ($field_title !== null && $field->getField()->getTitle() === $field_title) {

                            if ($this->setValueToField($property, $old_plugin, $new_plugin, $field)) {
                                $changed = true;

                                $field->doUpdate();
                            }

                            break;
                        }
                    }
                }

                if ($changed) {
                    $updated_plugins_count++;

                    $plugin_record->setLastUpdate(new ilDateTime(time(), IL_CAL_UNIX));

                    $plugin_record->setLastEditBy(self::dic()->user()->getId());

                    $plugin_record->doUpdate();
                }
            }
        }

        return $updated_plugins_count;
    }


    /**
     * @param string                    $property
     * @param ilDclBaseRecordFieldModel $field
     *
     * @return string
     */
    private function getValueFromField(string $property, ilDclBaseRecordFieldModel $field) : string
    {
        // Tricks with getPlainText to get correct reference values such ilias_min_version or ilias_max_version
        return strval($field->getPlainText());
    }


    /**
     * @param ilDclBaseRecordFieldModel $field
     *
     * @return string|null
     */
    private function mapFieldTitleToProperty(ilDclBaseRecordFieldModel $field)/*: ?string*/
    {
        switch ($field->getField()->getTitle()) {
            case "Plugin ID":
                return "plugin_id";

            /*case "Title":
                return "plugin_name";*/

            case "Version":
                return "plugin_version";

            case "Minimum ILIAS Release":
                return "ilias_min_version";

            case "Maximum ILIAS Release":
                return "ilias_max_version";

            /*case "Responsible Developer":
                return "responsible";*/

            /*case "Contact Developer":
                return "responsible_mail";*/

            /*case "Licence / Terms of Use":
                return "licence";*/

            /*case "Languages":
                return "languages";*/

            case "Download":
                return "git_url";

            default:
                return null;
        }
    }


    /**
     * @param string $property
     *
     * @return string|null
     */
    private function mapPropertyToFieldTitle(string $property)/*: ?string*/
    {
        switch ($property) {
            /*case "plugin_id":
                return "Plugin ID";*/

            /*case "plugin_name":
                return "Title";*/

            case "plugin_version":
                return "Version";

            case "ilias_min_version":
                return "Minimum ILIAS Release";

            case "ilias_max_version":
                return "Maximum ILIAS Release";

            /*case "responsible":
                return "Responsible Developer";*/

            /*case "responsible_mail":
                return "Contact Developer";*/

            /*case "licence":
                return "Licence / Terms of Use";*/

            /*case "languages":
                return "Languages";*/

            default:
                return null;
        }
    }


    /**
     * @param string                    $property
     * @param PluginInfo                $old_plugin
     * @param PluginInfo                $new_plugin
     * @param ilDclBaseRecordFieldModel $field
     *
     * @return bool Changed?
     */
    private function setValueToField(string $property, PluginInfo $old_plugin, PluginInfo $new_plugin, ilDclBaseRecordFieldModel $field) : bool
    {
        $value = $new_plugin->getProperty($property);

        if ($value !== $old_plugin->getProperty($property)) {
            $excel = new ilExcel();

            $excel->addSheet("");

            $excel->setCell(0, 0, $value);

            // Tricks with excel to set correct reference values such ilias_min_version or ilias_max_version
            $value = $field->getValueFromExcel($excel, 0, 0);

            $field->setValue($value);

            return true;
        }

        return false;
    }
}
