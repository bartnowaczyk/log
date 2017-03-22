<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_Hipchat extends BastaYa_Log_Model_Channels_Abstract implements BastaYa_Log_Model_Channels_IChannels
{

    public function __construct()
    {
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/hipchat_enabled', Mage::app()->getStore());
        if ($isEnabled) {
            $token = Mage::getStoreConfig('dev/bastaya_log/hipchat_token', Mage::app()->getStore());
            $url = Mage::getStoreConfig('dev/bastaya_log/hipchat_room', Mage::app()->getStore());
            if (!empty($url) && !empty($token)) {
                $this->setIsEnabled(1);
                $this->setUrl($url);
                $this->setToken($token);
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
        if (array_key_exists('room', $params) && !empty($params['room']) && array_key_exists('token', $params) && !empty($params['token'])) {
            $this->setEnabled(1);
            $url = $params['room'];
            $token = $params['token'];
            $this->setUrl($url);
            $this->setToken($token);
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
            $message = array("from" => "BastaYa Logger", "message" => $message, 'notify' => 1);
            $c = curl_init($this->getUrl());
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($c, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $this->getToken(),
                    )
            );
            $result = curl_exec($c);
            $result = json_decode($result);
            if (empty($error = $result->error)) {
                curl_close($c);
                return true;
            } else {
                Mage::log('Error connecting with Hipchat: ' . $error->message);
                curl_close($c);
                return false;
            }
        }
        return false;
    }
}