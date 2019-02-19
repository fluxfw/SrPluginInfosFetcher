Cron job plugin for http://plugins.ilias.de to keep plugin's version, min_ilias_version and max_ilias_version up to date

## Installation

### Install SrPluginInfosFetcher-Plugin
Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/Cron/CronHook
cd Customizing/global/plugins/Services/Cron/CronHook
git clone https://github.com/studer-raimann/SrPluginInfosFetcher.git SrPluginInfosFetcher
```
Update and activate the plugin in the ILIAS Plugin Administration

### Some screenshots
TODO

### Dependencies
* ILIAS 5.3
* PHP >=7.0
* [composer](https://getcomposer.org)
* [srag/activerecordconfig](https://packagist.org/packages/srag/activerecordconfig)
* [srag/custominputguis](https://packagist.org/packages/srag/custominputguis)
* [srag/dic](https://packagist.org/packages/srag/dic)
* [srag/librariesnamespacechanger](https://packagist.org/packages/srag/librariesnamespacechanger)
* [srag/removeplugindataconfirm](https://packagist.org/packages/srag/removeplugindataconfirm)

Please use it for further development!

### Adjustment suggestions
* Adjustment suggestions by pull requests
* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/PCIPD
* Bug reports under https://jira.studer-raimann.ch/projects/PCIPD
* For external users you can report it at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_PCIPD
