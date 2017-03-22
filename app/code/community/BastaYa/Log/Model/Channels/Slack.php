<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_Slack extends BastaYa_Log_Model_Channels_Abstract implements BastaYa_Log_Model_Channels_IChannels
{

    public function __construct()
    {
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/slack_enabled', Mage::app()->getStore());
        if ($isEnabled) {
            $channel = Mage::getStoreConfig('dev/bastaya_log/slack_channel', Mage::app()->getStore());
            if (!empty($channel)) {
                $this->setEnabled(1);
                $this->setUrl($channel);
            }
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public function configure(Array $params)
    {
        if (array_key_exists('channel', $params) && !empty($params['channel'])) {
            $this->setIsEnabled(1);
            $this->setUrl($params['channel']);
            return true;
        } else {
            return false;
        }
    }
    /**
     * @param string $identifier
     * @param string $logType
     * @param string $message
     *
     * @return bool
     */
    public function send($identifier, $logType, $message)
    {
        if ($this->getIsEnabled()) {
            $message = $this->buildMessage($identifier, $logType, $message);
            $message = array('payload' => json_encode(array('text' => $message, 'username' => "BastaYa Logger")));
            $c = curl_init($this->getUrl());
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $message);
            if (curl_exec($c)){
                curl_close($c);
                return true;
            }
            curl_close($c);
            return false;
        }
        return false;
    }
}