<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

class BastaYa_Log_Block_Adminhtml_Logs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bastayalog_grid');
        $this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bastayalog/channels_database')->getCollection();
        $collection->getSelect()->order('entity_id DESC');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('bastayalog');
        $this->addColumn('entity_id', array(
            'header' => $helper->__('Log #'),
            'width'  => '40px',
            'index'  => 'entity_id'
        ));

        $this->addColumn('created_at', array(
            'header'  => $helper->__('Date'),
            'type'    => 'datetime',
            'width'   => '200px',
            'index'   => 'created_at'
        ));

        $this->addColumn('log_type', array(
            'header'  => $helper->__('Log Type'),
            'width'   => '100px',
            'index'   => 'log_type',
            'filter'=> 'bastayalog/adminhtml_logs_grid_column_filter_log',
            'renderer'=> 'bastayalog/adminhtml_logs_grid_column_renderer_log'
        ));

        $this->addColumn('identifier', array(
            'header' => $helper->__('Log ID'),
            'width'  => '100px',
            'index'  => 'identifier'
        ));

        $this->addColumn('message', array(
            'header' => $helper->__('Message'),
            'index'  => 'message'
        ));

        return parent::_prepareColumns();
    }


    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}