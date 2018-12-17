<?php

namespace srag\Plugins\SrPluginInfosFetcher\Job;

use ilCronJob;
use ilCronJobResult;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class Job
 *
 * @package rag\Plugins\SrPluginInfosFetcher\Job
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Job extends ilCronJob {

	use DICTrait;
	use SrPluginInfosFetcherTrait;
	const CRON_JOB_ID = ilSrPluginInfosFetcherPlugin::PLUGIN_ID;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;


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

		$result->setStatus(ilCronJobResult::STATUS_NO_ACTION);

		return $result;
	}
}
