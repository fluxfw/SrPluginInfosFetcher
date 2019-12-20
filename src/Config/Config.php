<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config;

use ilSrPluginInfosFetcherPlugin;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\ActiveRecordConfig;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Config
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Config extends ActiveRecordConfig
{

    use SrPluginInfosFetcherTrait;
    const TABLE_NAME = "srplinfe_config";
    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    const KEY_DATA_COLLECTION_TABLE_ID = "data_collection_table_id";
    /**
     * @var array
     */
    protected static $fields
        = [
            self::KEY_DATA_COLLECTION_TABLE_ID => self::TYPE_INTEGER
        ];
}
