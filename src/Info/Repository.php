<?php

namespace srag\Plugins\SrPluginInfosFetcher\Info;

use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Info
 */
final class Repository
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Repository constructor
     */
    private function __construct()
    {

    }


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
     * @param PluginInfo $plugin
     *
     * @return PluginInfo
     */
    public function clonePlugin(PluginInfo $plugin) : PluginInfo
    {
        $new_plugin = clone $plugin;

        return $new_plugin;
    }


    /**
     * @internal
     */
    public function dropTables() : void
    {

    }


    /**
     * @return Factory
     */
    public function factory() : Factory
    {
        return Factory::getInstance();
    }


    /**
     * @internal
     */
    public function installTables() : void
    {

    }
}
