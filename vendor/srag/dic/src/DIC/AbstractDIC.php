<?php

namespace srag\DIC\SrPluginInfosFetcher\DIC;

use ILIAS\DI\Container;
use srag\DIC\SrPluginInfosFetcher\Database\DatabaseDetector;
use srag\DIC\SrPluginInfosFetcher\Database\DatabaseInterface;

/**
 * Class AbstractDIC
 *
 * @package srag\DIC\SrPluginInfosFetcher\DIC
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractDIC implements DICInterface
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container &$dic)
    {
        $this->dic = &$dic;
    }


    /**
     * @inheritDoc
     */
    public function database() : DatabaseInterface
    {
        return DatabaseDetector::getInstance($this->databaseCore());
    }
}
