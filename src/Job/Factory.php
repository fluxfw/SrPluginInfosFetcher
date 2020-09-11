<?php

namespace srag\Plugins\SrPluginInfosFetcher\Job;

use ilCronJob;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Job
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Factory constructor
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
     * @param string $job_id
     *
     * @return ilCronJob|null
     */
    public function newInstanceById(string $job_id)/*: ?ilCronJob*/
    {
        switch ($job_id) {
            case PluginInfosFetcherJob::CRON_JOB_ID:
                return $this->newPluginInfosFetcherJobInstance();

            default:
                return null;
        }
    }


    /**
     * @return ilCronJob[]
     */
    public function newInstances() : array
    {
        return [
            $this->newPluginInfosFetcherJobInstance()
        ];
    }


    /**
     * @return PluginInfosFetcherJob
     */
    public function newPluginInfosFetcherJobInstance() : PluginInfosFetcherJob
    {
        $job = new PluginInfosFetcherJob();

        return $job;
    }
}
