<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

$dataBaseChannel = Mage::getModel('bastayalog/channels');
$dataBaseChannel->setIdentifier('database');
$dataBaseChannel->setSource('bastayalog/channels_database');

$fileChannel = Mage::getModel('bastayalog/channels');
$fileChannel->setIdentifier('file');
$fileChannel->setSource('bastayalog/channels_file');

$emailChannel = Mage::getModel('bastayalog/channels');
$emailChannel->setIdentifier('email');
$emailChannel->setSource('bastayalog/channels_email');

$slackChannel = Mage::getModel('bastayalog/channels');
$slackChannel->setIdentifier('slack');
$slackChannel->setSource('bastayalog/channels_slack');

$hipchatChannel = Mage::getModel('bastayalog/channels');
$hipchatChannel->setIdentifier('hipchat');
$hipchatChannel->setSource('bastayalog/channels_hipchat');