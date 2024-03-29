<?php

namespace srag\Plugins\SrPluginInfosFetcher\Job;

use ilCronJob;
use ilCronJobResult;
use ilCronManager;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Config\Form\FormBuilder;
use srag\Plugins\SrPluginInfosFetcher\Info\PluginInfo;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class PluginInfosFetcherJob
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Job
 */
class PluginInfosFetcherJob extends ilCronJob
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const CRON_JOB_ID = ilSrPluginInfosFetcherPlugin::PLUGIN_ID;
    const LANG_MODULE = "cron";
    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;


    /**
     * PluginInfosFetcherJob constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function getDefaultScheduleType() : int
    {
        return self::SCHEDULE_TYPE_IN_HOURS;
    }


    /**
     * @inheritDoc
     */
    public function getDefaultScheduleValue() : ?int
    {
        return 1;
    }


    /**
     * @inheritDoc
     */
    public function getDescription() : string
    {
        return "";
    }


    /**
     * @inheritDoc
     */
    public function getId() : string
    {
        return self::CRON_JOB_ID;
    }


    /**
     * @inheritDoc
     */
    public function getTitle() : string
    {
        return ilSrPluginInfosFetcherPlugin::PLUGIN_NAME;
    }


    /**
     * @inheritDoc
     */
    public function hasAutoActivation() : bool
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public function hasFlexibleSchedule() : bool
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public function run() : ilCronJobResult
    {
        $result = new ilCronJobResult();

        $data_collection_table_id = self::srPluginInfosFetcher()->config()->getValue(FormBuilder::KEY_DATA_COLLECTION_TABLE_ID);

        $plugins = self::srPluginInfosFetcher()->ilias()->dataCollections()->getPlugins($data_collection_table_id);

        ilCronManager::ping($this->getId());

        $updated_plugins = $this->fetchPluginInfos($plugins);

        ilCronManager::ping($this->getId());

        $updated_plugins_count = self::srPluginInfosFetcher()->ilias()->dataCollections()->updatePlugins($data_collection_table_id, $updated_plugins);

        $result->setStatus(ilCronJobResult::STATUS_OK);

        $result->setMessage(self::plugin()->translate("updated_status", self::LANG_MODULE, [$updated_plugins_count]));

        return $result;
    }


    /**
     * @param string     $plugin_php
     * @param string     $variable
     * @param string     $property
     * @param PluginInfo $plugin
     *
     * @return bool
     */
    private function checkText(string $plugin_php, string $variable, string $property, PluginInfo $plugin) : bool
    {
        $text = [];

        preg_match('/\\$' . $variable . '\\s*=\\s*["\']{1}([^"\']+)["\']{1}\\s*;/', $plugin_php, $text);

        if (is_array($text) && count($text) > 1) {
            $text = $text[1];

            if (is_string($text) && !empty($text)) {
                if ($plugin->setProperty($property, $text)) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @param string     $plugin_php
     * @param string     $variable
     * @param string     $property
     * @param PluginInfo $plugin
     *
     * @return bool
     */
    private function checkVersion(string $plugin_php, string $variable, string $property, PluginInfo $plugin) : bool
    {
        $version = [];

        preg_match('/\\$' . $variable . '\\s*=\\s*["\']{1}([0-9\\.]+)["\']{1}\\s*;/', $plugin_php, $version);

        if (is_array($version) && count($version) > 1) {
            $version = $version[1];

            if (is_string($version) && !empty($version)) {
                if ($plugin->setProperty($property, $version)) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @param PluginInfo[] $plugins
     *
     * @return PluginInfo[][]
     */
    private function fetchPluginInfos(array $plugins) : array
    {
        $updated_plugins = [];

        foreach ($plugins as $plugin) {
            $updated_plugin = false;

            $new_plugin = self::srPluginInfosFetcher()->info()->clonePlugin($plugin);

            $plugin_php = self::srPluginInfosFetcher()->gitFetcher($new_plugin->getGitUrl())->fetchFile("plugin.php");

            if ($plugin_php !== null) {
                if ($this->checkVersion($plugin_php, "version", "plugin_version", $new_plugin)) {
                    $updated_plugin = true;
                }

                if ($this->checkVersion($plugin_php, "ilias_min_version", "ilias_min_version", $new_plugin)) {
                    $updated_plugin = true;
                }

                if ($this->checkVersion($plugin_php, "ilias_max_version", "ilias_max_version", $new_plugin)) {
                    $updated_plugin = true;
                }

                /*if ($this->checkText($plugin_php, "responsible", "responsible", $new_plugin)) {
                    $updated_plugin = true;
                }*/
                /*if ($this->checkText($plugin_php, "responsible_mail", "responsible_mail", $new_plugin)) {
                    $updated_plugin = true;
                }*/
            }

            if ($updated_plugin) {
                $updated_plugins[$plugin->getPluginId()] = [$plugin, $new_plugin];
            }
        }

        return $updated_plugins;
    }
}
