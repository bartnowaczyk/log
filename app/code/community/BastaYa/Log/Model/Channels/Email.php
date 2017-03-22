<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_Email extends BastaYa_Log_Model_Channels_Abstract implements BastaYa_Log_Model_Channels_IChannels
{

    public function __construct()
    {
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/email_enabled', Mage::app()->getStore());
        if ($isEnabled) {
            $address = Mage::getStoreConfig('dev/bastaya_log/email_address', Mage::app()->getStore());
            if (!empty($address)) {
                $this->setEnabled(1);
                $this->setAddress($address);
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
        if (array_key_exists('address', $params) && !empty($params['address'])) {
            $this->setEnabled(1);
            $this->setAddress($params['address']);
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
        if ($this->getIsEnabled()){
            $mail = new Zend_Mail();
            $sender = Mage::app()->getStore()->getName . " logger";
            $senderMail = Mage::getStoreConfig('trans_email/ident_general/email');
            $subject = $this->createSubject($logType);
            $body = $this->buildMessage($identifier, $logType, $message);
            $mail->setFrom($senderMail, $sender);
            $mail->addTo($this->getAddress());
            $mail->setSubject($subject);
            $mail->setBodyHtml($body);
            $res = $mail->send();
            if ($res) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function createSubject($logType)
    {
        $logLabel = Mage::helper('bastyalog')->getLogTypeLabel($logType);
        $subject = $logLabel . ' message from BastaYa Logger';
        return $subject;
    }
}