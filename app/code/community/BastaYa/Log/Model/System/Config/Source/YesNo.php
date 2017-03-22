<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Model_System_Config_Source_YesNo
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('No')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes'))
        );
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            0 => Mage::helper('adminhtml')->__('No'),
            1 => Mage::helper('adminhtml')->__('Yes')
        );
    }
}