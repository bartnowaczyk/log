# Magento BastaYa Log
Magento module to log events and store the log messages in database, files or send it as an e-mail or [slack](https://slack.com) or [hipchat](https://hipchat.com)

## Installation ##

Magento BastaYa Log uses [Composer](http://getcomposer.org) and [Magento Composer Installer](https://github.com/magento-hackathon/magento-composer-installer) to handle installation of the module and its dependencies. To install Magento BastaYa Log you will need a copy of _composer.phar_ in your path. If you do not have it, run from your terminal:

    $ curl -sS https://getcomposer.org/installer | php
    $ chmod a+x composer.phar

If you are already using Magento Composer Installer and have an existing _composer.json_, add _https://github.com/barteknowaczyk/log_ to the repositories list and _bastaYa/log_ as a required dependency for your project. That's it!

If you do not have an existing Magento Composer Installer _composer.json_ file defined, you can use the following template.

    {
      "repositories": [
          {
            "type":"composer",
            "url":"http://packages.firegento.com"
          },
          {
            "type": "vcs",
            "url": "https://github.com/bastaYa/log"
          }
      ],
      "require": {
          "magento-hackathon/magento-composer-installer": "*",
          "bastaYa/log": "*"
      },
      "extra":{
          "magento-root-dir":"./",
          "magento-force":"true"
      }
    }


To install Magento BastaYa Log and its dependencies just run composer.phar.

    $ ./composer.phar install


## Configuration ##

Open the Magento Admin interface and go to _configuration->Developer->Basta Ya_ and Enable the BastaYa logging, choose channels you want to use and add all necessary credentials. 
You can also define mapping between types of log and channels. By default all logs are sent to the file bastaYa.log.

If you are using Slack, you need to set up Incoming WebHooks for your Slack channel. Webhook URL that you get there use in module configuration. 

For Hipchat you will need a room name and token. [Here](https://bobswift.atlassian.net/wiki/display/HCLI/How+to+Generate+a+HipChat+Access+Token) you can find how generate the token. 

## Usage ##

The simplest way to use this module is to do (after module is enabled!):
```
$logger = Mage::getModel('bastayalog/logger');
$logger->log('Message you want to log.');
```
This will send the message to all enabled and configured channels that are chosen from the list of all available channels for __Info__ logs.

You can use up to 8 different log types:

    -EMERGENCY (level 0)
    -ALERT (level 1)
    -CRITICAL (level 2)
    -ERROR (level 3)
    -WARNING (level 4)
    -NOTICE (level 5)
    -INFO (level 6)
    -DEBUG (level 7)

If you want to change log type you can use one of following:
```
$logger->log('Your message that should be sens', 'error'); // or 
$logger->error('Your message that should be sens');
```

For each of the log typer you can choose default channels (file, data base and so on) in configuration.
You can also set the mapping just for a one logger instance:
```
$logger = Mage::getModel('bastayalog/logger');
$logger->overrideChannels($newChannelsList);
```

`$newChannelList`  is an associative array like this:
```'
0 => ['slack', 'email'],               // emergency
4 => ['database', 'slack', 'email'],   // warning
```

If you want to group all logs (that gives a possibility to filter logs in the grid):
```
$logger = Mage::getModel('bastayalog/logger', ['Interface_A_01-191120000291']);
```
then pass the `$logger` through the whole process and log whenever you need.

If you want just add one channel to one or more specific log type for current Logger instance use:
```
$logger = Mage::getModel('bastayalog/logger', ['Import_images_1001002002']);
$channelInstance = Mage::getModel(bastayalog/channels_file);
$logTypesArray = [2,7]; // critical, debug
$logger->addChannel($channelInstance, $logTypesArray);
```

You can also easily add your own channels (eg. sms gate). To achieve that please follow this steps:
- create your channel class inherited from `BastaYa_Log_Model_Channels_Abstract` and implements `BastaYa_Log_Model_Channels_IChannels`
- register it as a channel for example in the data setup file:
```
Mage::getModel('bastayalog/channels')->register($identifier, $source);
```
Example:
```
Mage::getModel('bastayalog/channels')
        ->register('sms', 'package_module/channels_sms');
```
- modify log type / channels mapping either in configuration, using `overrideChannels` or `addChannel` methods.

## Let me know ##

If you are going to use this module please ping me (at bart.nowaczyk@gmail.com) with store url. I won't publish this info but gives me an overview on the module usage.
I would love to get a feedback so please write me if you have any suggestion, question or request.



