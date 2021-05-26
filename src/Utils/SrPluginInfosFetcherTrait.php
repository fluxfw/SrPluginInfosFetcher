<?php

namespace srag\Plugins\SrPluginInfosFetcher\Utils;

use srag\Plugins\SrPluginInfosFetcher\Repository;

/**
 * Trait SrPluginInfosFetcherTrait
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Utils
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
