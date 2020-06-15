<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config;

use ilSrPluginInfosFetcherPlugin;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\AbstractFactory;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\AbstractRepository;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\Config;
use srag\Plugins\SrPluginInfosFetcher\Config\Form\FormBuilder;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository extends AbstractRepository
{

    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Repository constructor
     */
    protected function __construct()
    {
        parent::__construct();
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
     * @inheritDoc
     *
     * @return Factory
     */
    public function factory() : AbstractFactory
    {
        return Factory::getInstance();
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        return [
            FormBuilder::KEY_DATA_COLLECTION_TABLE_ID => Config::TYPE_INTEGER
        ];
    }


    /**
     * @inheritDoc
     */
    protected function getTableName() : string
    {
        return ilSrPluginInfosFetcherPlugin::PLUGIN_ID . "_config";
    }
}
