<?php


class Inchoo_Tickets_Model_Resource_Messages extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_tickets/messages', 'messages_id');
    }
}