<?php

require_once __DIR__ . "/../vendor/autoload.php";

use ILIAS\DI\Container;
use srag\CustomInputGUIs\SrPluginInfosFetcher\Loader\CustomInputGUIsLoaderDetector;
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
     * @inheritDoc
     */
    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }


    /**
     * @inheritDoc
     */
    public function getCronJobInstances() : array
    {
        return self::srPluginInfosFetcher()->jobs()->factory()->newInstances();
    }


    /**
     * @inheritDoc
     */
    public function getCronJobInstance(/*string*/ $a_job_id)/*: ?ilCronJob*/
    {
        return self::srPluginInfosFetcher()->jobs()->factory()->newInstanceById($a_job_id);
    }


    /**
     * @inheritDoc
     */
    protected function shouldUseOneUpdateStepOnly() : bool
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public function updateLanguages(/*?array*/ $a_lang_keys = null)/*:void*/
    {
        parent::updateLanguages($a_lang_keys);

        $this->installRemovePluginDataConfirmLanguages();
    }


    /**
     * @inheritDoc
     */
    protected function deleteData()/*: void*/
    {
        self::srPluginInfosFetcher()->dropTables();
    }


    /**
     * @inheritDoc
     */
    public function exchangeUIRendererAfterInitialization(Container $dic) : Closure
    {
        return CustomInputGUIsLoaderDetector::exchangeUIRendererAfterInitialization();
    }
}
