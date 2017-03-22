<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Helper_Data extends Mage_Core_Helper_Abstract
{
    const EMERGENCY_LOG_LEVEL   = 0;
    const ALERT_LOG_LEVEL       = 1;
    const CRITICAL_LOG_LEVEL    = 2;
    const ERROR_LOG_LEVEL       = 3;
    const WARNING_LOG_LEVEL     = 4;
    const NOTICE_LOG_LEVEL      = 5;
    const INFO_LOG_LEVEL        = 6;
    const DEBUG_LOG_LEVEL       = 7;


    public function getLogTypeLabel($logType)
    {
        $labels = $this->logLabels();
        if (array_key_exists($logType, $labels)) {
            return $labels[$logType];
        }
        return false;
    }

    public function getAllLabels()
    {
        $result = [];
        $result[] = [null => null];
        $l =  $this->logLabels();
        foreach ($l as $key => $item) {
            $result[] = ['value' => $key, 'label' =>$item];
        }
        return $result;
    }

    private function logLabels()
    {
        $labels = [
            self::EMERGENCY_LOG_LEVEL =>  'Emergency',
            self::ALERT_LOG_LEVEL     =>  'Alert',
            self::CRITICAL_LOG_LEVEL  =>  'Critical',
            self::ERROR_LOG_LEVEL     =>  'Error',
            self::WARNING_LOG_LEVEL   =>  'Warning',
            self::NOTICE_LOG_LEVEL    =>  'Notice',
            self::INFO_LOG_LEVEL      =>  'Info',
            self::DEBUG_LOG_LEVEL     =>  'Debug'
        ];
        return $labels;
    }

}
