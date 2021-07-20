<?php

namespace srag\Plugins\SrPluginInfosFetcher;

use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\GitCurl\SrPluginInfosFetcher\GitCurl;
use srag\Plugins\SrPluginInfosFetcher\Access\Ilias;
use srag\Plugins\SrPluginInfosFetcher\Config\Repository as ConfigRepository;
use srag\Plugins\SrPluginInfosFetcher\Info\Repository as InfoRepository;
use srag\Plugins\SrPluginInfosFetcher\Job\Repository as JobsRepository;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrPluginInfosFetcher
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
     * @return ConfigRepository
     */
    public function config() : ConfigRepository
    {
        return ConfigRepository::getInstance();
    }


    /**
     *
     */
    public function dropTables() : void
    {
        $this->config()->dropTables();
        $this->info()->dropTables();
        $this->jobs()->dropTables();
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
     * @return InfoRepository
     */
    public function info() : InfoRepository
    {
        return InfoRepository::getInstance();
    }


    /**
     *
     */
    public function installTables() : void
    {
        $this->config()->installTables();
        $this->info()->installTables();
        $this->jobs()->installTables();
    }


    /**
     * @return JobsRepository
     */
    public function jobs() : JobsRepository
    {
        return JobsRepository::getInstance();
    }
}
