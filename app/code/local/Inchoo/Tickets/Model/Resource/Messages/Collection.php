<?php


class Inchoo_Tickets_Model_Resource_Messages_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('inchoo_tickets/messages');
    }
}