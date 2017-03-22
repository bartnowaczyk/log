<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_Abstract extends Mage_Core_Model_Abstract
{

    protected function buildMessage($identifier, $logType, $message)
    {
        $logLabel = Mage::helper('bastayalog')->getLogTypeLabel($logType);
        $message = now() . ': ' . ucfirst($logLabel) . ' log from ' . $identifier . ': ' . $message;
        return $message;
    }
}
