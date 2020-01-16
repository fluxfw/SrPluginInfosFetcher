<?php

namespace srag\Plugins\SrPluginInfosFetcher;

use ilSrPluginInfosFetcherPlugin;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\Config;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\Repository as ConfigRepository;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Utils\ConfigTrait;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\GitCurl\SrPluginInfosFetcher\GitCurl;
use srag\Plugins\SrPluginInfosFetcher\Access\Ilias;
use srag\Plugins\SrPluginInfosFetcher\Config\ConfigFormGUI;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrPluginInfosFetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;
    use ConfigTrait {
        config as protected _config;
    }
    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self
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
     * Repository constructor
     */
    private function __construct()
    {
        $this->config()->withTableName(ilSrPluginInfosFetcherPlugin::PLUGIN_ID . "_config")->withFields([
            ConfigFormGUI::KEY_DATA_COLLECTION_TABLE_ID => Config::TYPE_INTEGER
        ]);
    }


    /**
     * @inheritDoc
     */
    public function config() : ConfigRepository
    {
        return self::_config();
    }


    /**
     *
     */
    public function dropTables()/*:void*/
    {
        $this->config()->dropTables();
    }


    /**
     * @param string $url
     *
     * @return GitCurl
     */
    public function gitFetcher(string $url) : GitCurl
    {
        return GitCurl::getInstance($url);
    }


    /**
     * @return Ilias
     */
    public function ilias() : Ilias
    {
        return Ilias::getInstance();
    }


    /**
     *
     */
    public function installTables()/*:void*/
    {
        $this->config()->installTables();
    }
}
