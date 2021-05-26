<?php

namespace srag\DIC\SrPluginInfosFetcher\Plugin;

/**
 * Interface Pluginable
 *
 * @package srag\DIC\SrPluginInfosFetcher\Plugin
 */
interface Pluginable
{

    /**
     * @return PluginInterface
     */
    public function getPlugin() : PluginInterface;


    /**
     * @param PluginInterface $plugin
     *
     * @return static
     */
    public function withPlugin(PluginInterface $plugin)/*: static*/ ;
}
