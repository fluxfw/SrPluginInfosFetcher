<?php

namespace srag\Plugins\SrPluginInfosFetcher\Config;

use ilSrPluginInfosFetcherPlugin;
use srag\ActiveRecordConfig\SrPluginInfosFetcher\ActiveRecordConfigFormGUI;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ActiveRecordConfigFormGUI {

	use SrPluginInfosFetcherTrait;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
	const CONFIG_CLASS_NAME = Config::class;


	/**
	 * @inheritdoc
	 */
	protected function initFields()/*: void*/ {
		$this->fields = [];
	}
}
