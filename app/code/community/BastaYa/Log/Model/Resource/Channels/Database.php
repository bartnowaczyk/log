<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_Resource_Channels_Database extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('bastayalog/channels_database', 'entity_id');
    }
}