<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\SrPluginInfosFetcher\Util\LibraryLanguageInstaller;
use srag\Plugins\SrPluginInfosFetcher\Config\Config;
use srag\Plugins\SrPluginInfosFetcher\Job\Job;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;
use srag\RemovePluginDataConfirm\SrPluginInfosFetcher\PluginUninstallTrait;

/**
 * Class ilSrPluginInfosFetcherPlugin
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrPluginInfosFetcherPlugin extends ilCronHookPlugin
{

    use PluginUninstallTrait;
    use SrPluginInfosFetcherTrait;
    const PLUGIN_ID = "srplinfe";
    const PLUGIN_NAME = "SrPluginInfosFetcher";
    const PLUGIN_CLASS_NAME = self::class;
    const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = SrPluginInfosFetcherRemoveDataConfirm::class;
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
     * ilSrPluginInfosFetcherPlugin constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return string
     */
    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }


    /**
     * @return ilCronJob[]
     */
    public function getCronJobInstances() : array
    {
        return [new Job()];
    }


    /**
     * @param string $a_job_id
     *
     * @return ilCronJob|null
     */
    public function getCronJobInstance(/*string*/
        $a_job_id
    )/*: ?ilCronJob*/
    {
        switch ($a_job_id) {
            case Job::CRON_JOB_ID:
                return new Job();

            default:
                return null;
        }
    }


    /**
     * @inheritdoc
     */
    public function updateLanguages($a_lang_keys = null)
    {
        parent::updateLanguages($a_lang_keys);

        LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__
            . "/../vendor/srag/removeplugindataconfirm/lang")->updateLanguages();
    }


    /**
     * @inheritdoc
     */
    protected function deleteData()/*: void*/
    {
        self::dic()->database()->dropTable(Config::TABLE_NAME, false);
    }
}
