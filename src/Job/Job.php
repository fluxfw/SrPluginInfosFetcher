<?php

namespace srag\Plugins\SrPluginInfosFetcher\Job;

use ilCronJob;
use ilCronJobResult;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Config\Config;
use srag\Plugins\SrPluginInfosFetcher\Info\PluginInfo;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Job
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Job
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Job extends ilCronJob {

	use DICTrait;
	use SrPluginInfosFetcherTrait;
	const CRON_JOB_ID = ilSrPluginInfosFetcherPlugin::PLUGIN_ID;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
	const LANG_MODULE_CRON = "cron";


	/**
	 * Job constructor
	 */
	public function __construct() {

	}


	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId(): string {
		return self::CRON_JOB_ID;
	}


	/**
	 * @return string
	 */
	public function getTitle(): string {
		return ilSrPluginInfosFetcherPlugin::PLUGIN_NAME;
	}


	/**
	 * @return string
	 */
	public function getDescription(): string {
		return "";
	}


	/**
	 * Is to be activated on "installation"
	 *
	 * @return boolean
	 */
	public function hasAutoActivation(): bool {
		return true;
	}


	/**
	 * Can the schedule be configured?
	 *
	 * @return boolean
	 */
	public function hasFlexibleSchedule(): bool {
		return true;
	}


	/**
	 * Get schedule type
	 *
	 * @return int
	 */
	public function getDefaultScheduleType(): int {
		return self::SCHEDULE_TYPE_IN_HOURS;
	}


	/**
	 * Get schedule value
	 *
	 * @return int|array
	 */
	public function getDefaultScheduleValue(): int {
		return 1;
	}


	/**
	 * Run job
	 *
	 * @return ilCronJobResult
	 */
	public function run(): ilCronJobResult {
		$result = new ilCronJobResult();

		$data_collection_table_id = Config::getField(Config::KEY_DATA_COLLECTION_TABLE_ID);

		$plugins = self::ilias()->dataCollections()->getPlugins($data_collection_table_id);

		$updated_plugins = $this->fetchPluginInfos($plugins);

		$updated_plugins_count = self::ilias()->dataCollections()->updatePlugins($data_collection_table_id, $updated_plugins);

		$result->setStatus(ilCronJobResult::STATUS_OK);

		$result->setMessage(self::plugin()->translate("updated_status", self::LANG_MODULE_CRON, [ $updated_plugins_count ]));

		return $result;
	}


	/**
	 * @param PluginInfo[] $plugins
	 *
	 * @return PluginInfo[][]
	 */
	private function fetchPluginInfos(array $plugins): array {
		$updated_plugins = [];

		foreach ($plugins as $plugin) {
			$updated_plugin = false;

			$new_plugin = clone $plugin;

			$plugin_php = self::gitFetcher($new_plugin->getGitUrl())->fetchFile("plugin.php");

			if ($plugin_php !== NULL) {
				if ($this->checkVersion($plugin_php, "version", "plugin_version", $new_plugin)) {
					$updated_plugin = true;
				}

				if ($this->checkVersion($plugin_php, "ilias_min_version", "ilias_min_version", $new_plugin)) {
					$updated_plugin = true;
				}

				if ($this->checkVersion($plugin_php, "ilias_max_version", "ilias_max_version", $new_plugin)) {
					$updated_plugin = true;
				}

				/*if ($this->checkText($plugin_php, "responsible", "responsible", $new_plugin)) {
					$updated_plugin = true;
				}*/
				/*if ($this->checkText($plugin_php, "responsible_mail", "responsible_mail", $new_plugin)) {
					$updated_plugin = true;
				}*/
			}

			if ($updated_plugin) {
				$updated_plugins[$plugin->getPluginId()] = [ $plugin, $new_plugin ];
			}
		}

		return $updated_plugins;
	}


	/**
	 * @param string     $plugin_php
	 * @param string     $variable
	 * @param string     $property
	 * @param PluginInfo $plugin
	 *
	 * @return bool
	 */
	private function checkVersion(string $plugin_php, string $variable, string $property, PluginInfo $plugin): bool {
		$version = [];

		preg_match('/\\$' . $variable . '\\s*=\\s*["\']{1}([0-9\\.]+)["\']{1}\\s*;/', $plugin_php, $version);

		if (is_array($version) && count($version) > 1) {
			$version = $version[1];

			if (is_string($version) && !empty($version)) {
				if ($plugin->setProperty($property, $version)) {
					return true;
				}
			}
		}

		return false;
	}


	/**
	 * @param string     $plugin_php
	 * @param string     $variable
	 * @param string     $property
	 * @param PluginInfo $plugin
	 *
	 * @return bool
	 */
	private function checkText(string $plugin_php, string $variable, string $property, PluginInfo $plugin): bool {
		$text = [];

		preg_match('/\\$' . $variable . '\\s*=\\s*["\']{1}(.+)["\']{1}\\s*;/', $plugin_php, $text);

		if (is_array($text) && count($text) > 1) {
			$text = $text[1];

			if (is_string($text) && !empty($text)) {
				if ($plugin->setProperty($property, $text)) {
					return true;
				}
			}
		}

		return false;
	}
}
