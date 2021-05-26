<?php

namespace srag\Plugins\SrPluginInfosFetcher\Access;

use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Ilias
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Access
 */
final class Ilias
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Ilias constructor
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
     * @return DataCollections
     */
    public function dataCollections() : DataCollections
    {
        return DataCollections::getInstance();
    }
}
