<?php

namespace srag\ActiveRecordConfig\SrPluginInfosFetcher\Config;

use srag\DIC\SrPluginInfosFetcher\DICTrait;

/**
 * Class AbstractFactory
 *
 * @package srag\ActiveRecordConfig\SrPluginInfosFetcher\Config
 */
abstract class AbstractFactory
{

    use DICTrait;

    /**
     * AbstractFactory constructor
     */
    protected function __construct()
    {

    }


    /**
     * @return Config
     */
    public function newInstance() : Config
    {
        $config = new Config();

        return $config;
    }
}
