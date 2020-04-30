<?php

namespace srag\Plugins\SrPluginInfosFetcher\Info;

use srag\CustomInputGUIs\SrPluginInfosFetcher\PropertyFormGUI\Items\Items;
use srag\DIC\SrPluginInfosFetcher\DICTrait;
use srag\Plugins\SrPluginInfosFetcher\Utils\SrPluginInfosFetcherTrait;

/**
 * Class PluginInfo
 *
 * @package srag\Plugins\SrPluginInfosFetcher\Info
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class PluginInfo
{

    use DICTrait;
    use SrPluginInfosFetcherTrait;

    /**
     * @var string
     */
    protected $plugin_id = "";
    /**
     * @var string
     */
    protected $plugin_name = "";
    /**
     * @var string
     */
    protected $plugin_version = "";
    /**
     * @var string
     */
    protected $ilias_min_version = "";
    /**
     * @var string
     */
    protected $ilias_max_version = "";
    /**
     * @var string
     */
    protected $responsible = "";
    /**
     * @var string
     */
    protected $responsible_mail = "";
    /**
     * @var string
     */
    protected $licence = "";
    /**
     * @var string[]
     */
    protected $languages = [];
    /**
     * @var string
     */
    protected $git_url = "";


    /**
     * PluginInfo constructor
     */
    public function __construct()
    {

    }


    /**
     * @param string $property
     *
     * @return string
     */
    public function getProperty(string $property) : string
    {
        return Items::getter($this, $property) ?? "";
    }


    /**
     * @param string $property
     * @param string $value
     *
     * @return bool Changed?
     */
    public function setProperty(string $property, string $value) : bool
    {
        $old_value = $this->getProperty($property);

        if (method_exists($this, $method = "set" . Items::strToCamelCase($property))) {
            Items::setter($this, $property, $value);

            return ($this->getProperty($property) !== $old_value);
        }

        return false;
    }


    /**
     * @return array
     */
    public function getPropertyNames() : array
    {
        return array_keys(get_object_vars($this));
    }


    /**
     * @return bool
     */
    public function hasRequiredValues() : bool
    {
        // Needs plugin id and supports only git download url
        return (!empty($this->getPluginId()) && strpos($this->getGitUrl(), "git") !== -1);
    }


    /**
     * @param string $version
     *
     * @return string
     */
    protected function fixMinMaxVersion(string $version) : string
    {
        if (substr_count($version, ".") === 2) {
            // Only 2 parts x.y for older ILIAS versions
            $version = preg_replace("/\.[0-9]+$/", "", $version);
        } else {
            if (substr_count($version, ".") === 1) {
                // ILIAS 6 version syntax uses only one part x
                $version2 = explode(".", $version)[0];
                if (intval($version2) >= 6) {
                    $version = $version2;
                }
            }
        }

        return $version;
    }


    /**
     * @return string
     */
    public function getPluginId() : string
    {
        return $this->plugin_id;
    }


    /**
     * @param string $plugin_id
     */
    public function setPluginId(string $plugin_id)/*: void*/
    {
        $this->plugin_id = $plugin_id;
    }


    /**
     * @return string
     */
    public function getPluginName() : string
    {
        return $this->plugin_name;
    }


    /**
     * @param string $plugin_name
     */
    public function setPluginName(string $plugin_name)/*: void*/
    {
        $this->plugin_name = $plugin_name;
    }


    /**
     * @return string
     */
    public function getPluginVersion() : string
    {
        return $this->plugin_version;
    }


    /**
     * @param string $plugin_version
     */
    public function setPluginVersion(string $plugin_version)/*: void*/
    {
        $this->plugin_version = $plugin_version;
    }


    /**
     * @return string
     */
    public function getIliasMinVersion() : string
    {
        return $this->fixMinMaxVersion($this->ilias_min_version);
    }


    /**
     * @param string $ilias_min_version
     */
    public function setIliasMinVersion(string $ilias_min_version)/*: void*/
    {
        $this->ilias_min_version = $this->fixMinMaxVersion($ilias_min_version);
    }


    /**
     * @return string
     */
    public function getIliasMaxVersion() : string
    {
        return $this->fixMinMaxVersion($this->ilias_max_version);
    }


    /**
     * @param string $ilias_max_version
     */
    public function setIliasMaxVersion(string $ilias_max_version)/*: void*/
    {
        $this->ilias_max_version = $this->fixMinMaxVersion($ilias_max_version);
    }


    /**
     * @return string
     */
    public function getResponsible() : string
    {
        return $this->responsible;
    }


    /**
     * @param string $responsible
     */
    public function setResponsible(string $responsible)/*: void*/
    {
        $this->responsible = $responsible;
    }


    /**
     * @return string
     */
    public function getResponsibleMail() : string
    {
        return $this->responsible_mail;
    }


    /**
     * @param string $responsible_mail
     */
    public function setResponsibleMail(string $responsible_mail)/*: void*/
    {
        $this->responsible_mail = $responsible_mail;
    }


    /**
     * @return string
     */
    public function getLicence() : string
    {
        return $this->licence;
    }


    /**
     * @param string $licence
     */
    public function setLicence(string $licence)/*: void*/
    {
        $this->licence = $licence;
    }


    /**
     * @return string[]
     */
    public function getLanguages() : array
    {
        return $this->languages;
    }


    /**
     * @param string[] $languages
     */
    public function setLanguages(array $languages)/*: void*/
    {
        $this->languages = $languages;
    }


    /**
     * @return string
     */
    public function getGitUrl() : string
    {
        return $this->git_url;
    }


    /**
     * @param string $git_url
     */
    public function setGitUrl(string $git_url)/*: void*/
    {
        $this->git_url = $git_url;
    }
}
