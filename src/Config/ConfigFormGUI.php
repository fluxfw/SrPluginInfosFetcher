<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config;

use ilNumberInputGUI;
use ilSrPluginInfosFetcherConfigGUI;
use ilSrPluginInfosFetcherPlugin;
use srag\CustomInputGUIs\SrPluginInfosFetcher\PropertyFormGUI\PropertyFormGUI;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends PropertyFormGUI
{

    use SrPluginInfosFetcherTrait;
    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    const KEY_DATA_COLLECTION_TABLE_ID = "data_collection_table_id";
    const LANG_MODULE = ilSrPluginInfosFetcherConfigGUI::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ilSrPluginInfosFetcherConfigGUI $parent
     */
    public function __construct(ilSrPluginInfosFetcherConfigGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            default:
                return self::srPluginInfosFetcher()->config()->getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ilSrPluginInfosFetcherConfigGUI::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_DATA_COLLECTION_TABLE_ID => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ]
        ];
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt("configuration"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                self::srPluginInfosFetcher()->config()->setValue($key, $value);
                break;
        }
    }
}
