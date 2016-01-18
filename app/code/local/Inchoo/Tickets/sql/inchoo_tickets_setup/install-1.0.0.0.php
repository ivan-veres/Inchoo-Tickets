<?php

/* @var $this Mage_Core_Model_Resource_Setup*/

$this->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('inchoo_tickets/tickets'))
    ->addColumn(
        'ticket_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Id')
    ->addColumn(
        'customer_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Customer ID')
    ->addColumn(
        'subject',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array(
            'nullable' => false,
        ), 'Subject')
    ->addColumn(
        'message',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false,
        ), 'Message')
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_TINYINT,
        1,
        array(
            'nullable' => false,
        ), 'Status')
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(
            'nullable' => false,
        ), 'Creation Time')
    ->addColumn(
        'closed_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(
            'nullable' => true,
        ), 'Closing Time')
    ->addForeignKey($this->getFkName('inchoo_tickets/tickets', 'customer_id', 'customer/entity', 'entity_id'),
        'customer_id', $this->getTable('customer/entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_NO_ACTION, Varien_Db_Ddl_Table::ACTION_CASCADE);

$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('inchoo_tickets/messages'))
    ->addColumn(
        'messages_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Reply ID')
    ->addColumn(
        'ticket_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Ticket ID')
    ->addColumn(
        'admin_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Admin ID')
    ->addColumn(
        'message',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false,
        ), 'Message')
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(
            'nullable' => false,
        ), 'Creation Time')
    ->addForeignKey($this->getFkName('inchoo_tickets/messages', 'ticket_id', 'inchoo_tickets/tickets', 'ticket_id'),
        'ticket_id', $this->getTable('inchoo_tickets/tickets'), 'ticket_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);

$this->getConnection()->createTable($table);

$this->endSetup();