<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Block_Adminhtml_Logs_Grid_Column_Filter_Log extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{

    protected function _getOptions()
    {
            $result = Mage::helper('bastayalog')->getAllLabels();
        return $result;
    }

    public function getCondition()
    {
        if(is_null($this->getValue())) {
            return null;
        }

        return array('eq'=>$this->getValue());
    }


}