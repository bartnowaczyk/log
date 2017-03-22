<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels_File extends BastaYa_Log_Model_Channels_Abstract implements BastaYa_Log_Model_Channels_IChannels
{

    public function __construct()
    {
        $isEnabled = Mage::getStoreConfig('dev/bastaya_log/file_enabled', Mage::app()->getStore());
        if ($isEnabled) {
            $fileName = Mage::getStoreConfig('dev/bastaya_log/filename', Mage::app()->getStore());
            if (!empty($fileName)) {
                $fileName = Mage::getBaseDir('var') . DS . $fileName;
                if ($this->createFile($fileName)) {
                    $this->setEnabled(1);
                    $this->setFileName($fileName);
                }
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
        $result = false;
        if (array_key_exists('filename', $params) && !empty($params['filename'])) {
            $fileName = Mage::getBaseDir('var') . DS . $params['filename'];
            if ($this->createFile($fileName)) {
                $this->setEnabled(1);
                $this->setFileName($fileName);
                $result  = true;
            }
        }
        return $result;
    }

    /**
     * @param string $identifier
     * @param string $logType
     * @param string $message
     **
     * @return bool
     */
    public function send($identifier, $logType, $message)
    {
        if($this->getIsEnabled()){
            $message = $this->buildMessage($identifier, $logType, $message);
            $message .= "\n";
            if (file_put_contents($this->getFileName(), $message, FILE_APPEND)) {
                return true;
            }
            return false;
        }
        return false;
    }

    private function createFile($fileName)
    {
        if(!file_exists($fileName)) {
            return fopen($fileName, "w");
        }
        return true;
    }
}