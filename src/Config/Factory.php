<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config;

use ilSrPluginInfosFetcherPlugin;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\AbstractFactory;
use srag\Plugins\SrPluginInfosFetcher\Config\Form\FormBuilder;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory extends AbstractFactory
{

    use SrPluginInfosFetcherTrait;

    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Factory constructor
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
     * @param ConfigCtrl $parent
     *
     * @return FormBuilder
     */
    public function newFormBuilderInstance(ConfigCtrl $parent) : FormBuilder
    {
        $form = new FormBuilder($parent);

        return $form;
    }
}
