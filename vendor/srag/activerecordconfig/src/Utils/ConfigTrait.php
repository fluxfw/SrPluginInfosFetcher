<?php

namespace srag\ActiveRecordConfig\SrPluginInfosFetcher\Utils;

use srag\ActiveRecordConfig\SrPluginInfosFetcher\Config\Repository as ConfigRepository;

/**
 * Trait ConfigTrait
 *
 * @package srag\ActiveRecordConfig\SrPluginInfosFetcher\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait ConfigTrait
{

    /**
     * @return ConfigRepository
     */
    protected static function config() : ConfigRepository
    {
        return ConfigRepository::getInstance();
    }
}
