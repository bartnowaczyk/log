<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('bastayalog/channels_database'))

    // Add columns
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ], 'Entity Id')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 80, [
        'nullable'  => false
    ], 'Event Identifier')

    ->addColumn('log_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 30, [
        'nullable'  => false
    ], 'Log type')
    
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, 500, [
        'nullable'  => false
    ], 'Log message')
    
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true,
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ],'Created At')

    // Add Index
    ->addIndex(
        $installer->getIdxName('bastayalog/channels_database', ['identifier']),
        ['identifier']
    );
$installer->getConnection()->createTable($table);

$channelsTable = $installer->getConnection()
    ->newTable($installer->getTable('bastayalog/channels'))

    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ], 'Entity Id')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 80, [
        'nullable'  => false
    ], 'Channel Identifier')

    ->addColumn('source_class', Varien_Db_Ddl_Table::TYPE_VARCHAR, 30, [
        'nullable'  => false
    ], 'class handler');

$installer->getConnection()->createTable($channelsTable);
$installer->endSetup();