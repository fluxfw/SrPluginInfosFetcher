<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;
use srag\RemovePluginDataConfirm\SrPluginInfosFetcher\AbstractRemovePluginDataConfirm;

/**
 * Class SrPluginInfosFetcherRemoveDataConfirm
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy SrPluginInfosFetcherRemoveDataConfirm: ilUIPluginRouterGUI
 */
class SrPluginInfosFetcherRemoveDataConfirm extends AbstractRemovePluginDataConfirm {

	use SrPluginInfosFetcherTrait;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
}
