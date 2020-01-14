<?php

namespace srag\Plugins\SrPluginInfosFetcher\Utils;

use srag\Plugins\SrPluginInfosFetcher\Repository;

/**
 * Trait SrPluginInfosFetcherTrait
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait SrPluginInfosFetcherTrait
{

    /**
     * @return Repository
     */
    protected static function srPluginInfosFetcher() : Repository
    {
        return Repository::getInstance();
    }
}
