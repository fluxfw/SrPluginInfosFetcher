<?php

namespace srag\Plugins\SrPluginInfosFetcher;

use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\GitCurl\SrPluginInfosFetcher\GitCurl;
use srag\Plugins\SrPluginInfosFetcher\Access\Ilias;
use srag\Plugins\SrPluginInfosFetcher\Config\Repository as ConfigRepository;
use srag\Plugins\SrPluginInfosFetcher\Job\Repository as JobsRepository;
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
     * Repository constructor
     */
    private function __construct()
    {

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
    public function dropTables()/*:void*/
    {
        $this->config()->dropTables();
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
     *
     */
    public function installTables()/*:void*/
    {
        $this->config()->installTables();
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
