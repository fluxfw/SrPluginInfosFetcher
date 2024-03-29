<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DevTools\SrPluginInfosFetcher\DevToolsCtrl;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Config\ConfigCtrl;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class ilSrPluginInfosFetcherConfigGUI
 *
 * @ilCtrl_isCalledBy srag\DevTools\SrPluginInfosFetcher\DevToolsCtrl: ilSrPluginInfosFetcherConfigGUI
 */
class ilSrPluginInfosFetcherConfigGUI extends ilPluginConfigGUI
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    const CMD_CONFIGURE = "configure";
    const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;


    /**
     * ilSrPluginInfosFetcherConfigGUI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function performCommand(/*string*/ $cmd) : void
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            case strtolower(ConfigCtrl::class):
                self::dic()->ctrl()->forwardCommand(new ConfigCtrl());
                break;

            case strtolower(DevToolsCtrl::class):
                self::dic()->ctrl()->forwardCommand(new DevToolsCtrl($this, self::plugin()));
                break;

            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_CONFIGURE:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     *
     */
    protected function configure() : void
    {
        self::dic()->ctrl()->redirectByClass(ConfigCtrl::class, ConfigCtrl::CMD_CONFIGURE);
    }


    /**
     *
     */
    protected function setTabs() : void
    {
        ConfigCtrl::addTabs();

        DevToolsCtrl::addTabs(self::plugin());

        self::dic()->locator()->addItem(ilSrPluginInfosFetcherPlugin::PLUGIN_NAME, self::dic()->ctrl()->getLinkTarget($this, self::CMD_CONFIGURE));
    }
}
