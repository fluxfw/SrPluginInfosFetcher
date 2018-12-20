<?php

namespace srag\Plugins\SrPluginInfosFetcher\Git;

use ilCurlConnection;
use ilSrPluginInfosFetcherPlugin;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;
use Throwable;

/**
 * Class GitFetcher
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Git
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class GitFetcher {

	use DICTrait;
	use SrPluginInfosFetcherTrait;
	const PLUGIN_CLASS_NAME = ilSrPluginInfosFetcherPlugin::class;
	/**
	 * @var self[]
	 */
	protected static $instances = [];


	/**
	 * @param string $url
	 *
	 * @return self
	 */
	public static function getInstance(string $url): self {
		if (!isset(self::$instances[$url])) {
			self::$instances[$url] = new self($url);
		}

		return self::$instances[$url];
	}


	/**
	 * @var string
	 */
	private $url;


	/**
	 * GitFetcher constructor
	 *
	 * @param string $url
	 */
	private function __construct(string $url) {
		$this->url = $url;

		$this->fixUrl();
	}


	/**
	 * @param string $path
	 *
	 * @return string|null
	 */
	public function fetchFile(string $path)/*: ?string*/ {
		try {
			$url = $this->url . "/master/" . $path;

			$curlConnection = new ilCurlConnection();

			$curlConnection->init();

			$curlConnection->setOpt(CURLOPT_RETURNTRANSFER, true);
			$curlConnection->setOpt(CURLOPT_URL, $url);

			$result = $curlConnection->exec();

			if (is_string($result) && !empty($result)) {
				return $result;
			} else {
				return NULL;
			}
		} catch (Throwable $ex) {
			return NULL;
		}
	}


	/**
	 *
	 */
	private function fixUrl()/*: void*/ {
		// Get github raw file content
		$this->url = str_replace("github.com", "raw.githubusercontent.com", $this->url);

		// Fix possible windows paths
		$this->url = str_replace("\\", "/", $this->url);

		// Remove ends with /
		$this->url = preg_replace("/\/$/", "", $this->url);

		// Some urls includes releases at end. Remove it
		$this->url = preg_replace("/\/releases$/", "", $this->url);
	}
}
