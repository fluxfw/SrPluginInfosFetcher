<?php

namespace srag\Plugins\SrPluginInfosFetcher\Utils;

use srag\Plugins\SrPluginInfosFetcher\Access\Access;
use srag\Plugins\SrPluginInfosFetcher\Access\Ilias;
use srag\Plugins\SrPluginInfosFetcher\Git\GitFetcher;

/**
 * Trait SrPluginInfosFetcherTrait
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait SrPluginInfosFetcherTrait {

	/**
	 * @return Access
	 */
	protected static function access(): Access {
		return Access::getInstance();
	}


	/**
	 * @param string $url
	 *
	 * @return GitFetcher
	 */
	protected static function gitFetcher(string $url): GitFetcher {
		return GitFetcher::getInstance($url);
	}


	/**
	 * @return Ilias
	 */
	protected static function ilias(): Ilias {
		return Ilias::getInstance();
	}
}
