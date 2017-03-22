<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Block_Adminhtml_Logs extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'bastayalog';
        $this->_controller = 'adminhtml_logs';
        $this->_headerText = Mage::helper('bastayalog')->__('Logs');
        parent::__construct();
        $this->_removeButton('add');
    }
}
