<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Channels extends Mage_Core_Model_Abstract
{

    public function __construct()
    {
        $this->_init('bastayalog/channels', 'entity_id');
    }

    public function register($identifier, $source)
    {
        $model = Mage::getModel($source);
        if (!empty($model ) && !is_a($model, 'BastaYa_Log_Model_Channels_Abstract')) {
            Mage::log($source . ' cannot be added as a channel');
        }
        $this->load($identifier, 'identifier');
        if (empty($this->getId())) {
            $this->setIdentifier($identifier);
            $this->setSpurce($source);
            $this->save();
        }
    }

    private function save()
    {
        parent::save();
    }
}