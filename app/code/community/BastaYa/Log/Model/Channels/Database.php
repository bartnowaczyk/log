<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_Database extends BastaYa_Log_Model_Channels_Abstract implements BastaYa_Log_Model_Channels_IChannels
{

    public function __construct()
    {
        $this->_init('bastayalog/channels_database', 'entity_id');
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/database_enabled', Mage::app()->getStore());
        if ($isEnabled) {
            $this->setEnabled(1);
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
            $this->unsetData('entity_id');
            $this->setIdentifier($identifier);
            $this->setLogTYpe($logType);
            $this->setMessage($message);
            $this->setCreatedAt(now());
            $this->save();
            return true;
        }
        return false;
    }
}