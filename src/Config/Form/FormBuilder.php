<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config\Form;

use ilSrPluginInfosFetcherPlugin;
use srag\CustomInputGUIs\SrPluginInfosFetcher\FormBuilder\AbstractFormBuilder;
use srag\Plugins\SrPluginInfosFetcher\Config\ConfigCtrl;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class FormBuilder
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FormBuilder extends AbstractFormBuilder
{

    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    const KEY_DATA_COLLECTION_TABLE_ID = "data_collection_table_id";


    /**
     * @inheritDoc
     *
     * @param ConfigCtrl $parent
     */
    public function __construct(ConfigCtrl $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getButtons() : array
    {
        $buttons = [
            ConfigCtrl::CMD_UPDATE_CONFIGURE => self::plugin()->translate("save", ConfigCtrl::LANG_MODULE)
        ];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        $data = [
            self::KEY_DATA_COLLECTION_TABLE_ID => self::srPluginInfosFetcher()->config()->getValue(self::KEY_DATA_COLLECTION_TABLE_ID)
        ];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $fields = [
            self::KEY_DATA_COLLECTION_TABLE_ID => self::dic()
                ->ui()
                ->factory()
                ->input()
                ->field()
                ->input(self::plugin()->translate(self::KEY_DATA_COLLECTION_TABLE_ID, ConfigCtrl::LANG_MODULE))
                ->withRequired(true)
        ];

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return self::plugin()->translate("configuration", ConfigCtrl::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data)/* : void*/
    {
        self::srPluginInfosFetcher()->config()->setValue(self::KEY_DATA_COLLECTION_TABLE_ID, intval($data[self::KEY_DATA_COLLECTION_TABLE_ID]));
    }
}
