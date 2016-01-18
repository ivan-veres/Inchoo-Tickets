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
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
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
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'nullable' => false,
        ), 'Status')
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_CHAR,
        25,
        array(
            'nullable' => false,
        ), 'Created At')
    ->addColumn(
        'closed_at',
        Varien_Db_Ddl_Table::TYPE_CHAR,
        25,
        array(
            'nullable' => false,
        ), 'Closed At');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('inchoo_tickets/ticket_messages'))
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
        'timestamp',
        Varien_Db_Ddl_Table::TYPE_CHAR,
        25,
        array(
            'nullable' => false,
        ), 'Timestamp')
    ->addForeignKey($this->getFkName('inchoo_tickets/ticket_messages', 'ticket_id', 'inchoo_tickets/tickets', 'ticket_id'),
        'ticket_id', $this->getTable('inchoo_tickets/tickets'), 'ticket_id');

$this->getConnection()->createTable($table);

$this->endSetup();