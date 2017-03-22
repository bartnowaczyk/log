<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Logger extends Mage_Core_Model_Abstract
{
    public function __construct($param = null)
    {
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/enabled', Mage::app()->getStore());
        if (!$isEnabled){
            Mage::log('BastaYa Log is not enabled.');
        }
        $this->setIsEnabled(true);
        if (!empty($param)) {
                $this->setIdentifier($param);
        } else {
            $this->setIdentifier($this->createIdentifier(8));
        }
        $this->buildChannelList();
    }

    /**
     * @param string $message
     * @param string $logtype
     *
     * @return array|bool
     */
    public function log($message, $logtype = 'info')
    {
        if(!$this->getIsEnabled()){
            return false;
        }
        $channels = $this->getChannelByLogType($logtype);
        foreach ($channels as $channel) {
            $result[] = $channel->send($this->getIdentifier(), $logtype, $message);
        }
        return $result;
    }

    /**
     * @param string $message
     *
     * @return array|bool
     */
    public function message($message)
    {
        return $this->log($message);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function emergency($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::EMERGENCY_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function alert($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::ALERT_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function critical($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::CRITICAL_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function error($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::ERROR_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function warning($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::WARNING_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function notice($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::NOTICE_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function info($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::INFO_LOG_LEVEL);
    }

    /**
     * @param string $messsage
     *
     * @return array|bool
     */
    public function debug($messsage)
    {
        return $this->log($messsage, BastaYa_Log_Helper_Data::DEBUG_LOG_LEVEL);
    }

    /**
     * @param array $newChannelsList
     */
    public function overrideChannels(Array $newChannelsList)
    {
        $channels = [];
        foreach ($newChannelsList as $logType => $newChannels) {
            foreach ($newChannels as $channel) {
                $channels[$logType][] = $channel;
            }
        }
        $this->initChannels($channels);
    }


    /**
     * @param BastaYa_Log_Model_Channels_Abstract $channel
     * @param array                               $logTypes
     */
    public function addChannel(BastaYa_Log_Model_Channels_Abstract $channel, Array $logTypes)
    {
        foreach ($logTypes as $logType) {
            if(array_key_exists($logType, $this->getChannels())) {
                $this->add($channel, $logType);
            }
        }
    }

    private function createIdentifier($len = 5){
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';
        $keys = [];
        foreach (range(1, $len) as $i) {
            $key = explode(' ', microtime())[1] * rand(1,30);
            $result = $charset[$key % $base] . $result;
        }
        return $result;
    }

    private function buildChannelList()
    {
        $logTypes = [];
        $logTypes[BastaYa_Log_Helper_Data::EMERGENCY_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/emergency_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::ALERT_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/alert_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::CRITICAL_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/critical_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::ERROR_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/error_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::WARNING_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/warning_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::NOTICE_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/notice_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::INFO_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/info_channels', Mage::app()->getStore()));
        $logTypes[BastaYa_Log_Helper_Data::DEBUG_LOG_LEVEL] = explode(',', Mage::getStoreConfig('dev/bastaya_log/debug_channels', Mage::app()->getStore()));
        $this->initChannels($logTypes);
    }

    private function initChannels($logTypes)
    {
        $channelList = [];
        foreach ($logTypes as $logType => $channels) {
            foreach ($channels as $channel) {
                $channelInstance = Mage::getModel('bastayalog/channels')->load($channel, 'identifier');
                if (empty($channelInstance) || empty($channelInstance->getId())) {
                    Mage::log('There are no channel ' . $channel);
                    continue;
                }
                $classHandler = $channelInstance->getSource();
                $class = Mage::getModel($classHandler);
                if (!empty($class)) {
                    $channelList[$logType][] = $class;
                }
            }
        }
        $this->setChannels($channelList);
    }

    private function getChannelByLogType($logType) {
        $channels = $this->getChannels();
        if(array_key_exists($logType, $channels)) {
            return $channels[$logType];
        }
        return [];
    }

    private function add($channel, $logyType)
    {
        $channels = $this->getChannels();
        $channels[$logyType][] = $channel;
        $this->setChannels($channels);
    }
}