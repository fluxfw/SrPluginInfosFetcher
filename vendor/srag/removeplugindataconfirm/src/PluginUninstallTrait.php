<?php

namespace srag\RemovePluginDataConfirm\SrPluginInfosFetcher;

/**
 * Trait PluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\SrPluginInfosFetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait PluginUninstallTrait
{

    use BasePluginUninstallTrait;

    /**
     * @internal
     */
    protected final function afterUninstall()/*: void*/
    {

    }


    /**
     * @return bool
     *
     * @internal
     */
    protected final function beforeUninstall() : bool
    {
        return $this->pluginUninstall();
    }
}
