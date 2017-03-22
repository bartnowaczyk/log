<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_System_Config_Source_Channels
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $channels = Mage::getModel('bastayalog/channels')->getCollection();
        foreach ($channels as $channel) {
            $result[] = ['value' => $channel->getIdentifier(), 'label' => ucfirst($channel->getIdentifier())];
        }
        return $result;
    }
}