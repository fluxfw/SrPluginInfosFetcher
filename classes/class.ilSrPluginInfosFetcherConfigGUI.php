<?php

use srag\ActiveRecordConfig\SrPluginInfosFetcher\ActiveRecordConfigGUI;
use srag\Plugins\SrPluginInfosFetcher\Config\ConfigFormGUI;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class ilSrPluginInfosFetcherConfigGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrPluginInfosFetcherConfigGUI extends ActiveRecordConfigGUI {

	use SrPluginInfosFetcherTrait;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
	/**
	 * @var array
	 */
	protected static $tabs = [ self::TAB_CONFIGURATION => ConfigFormGUI::class ];
}
