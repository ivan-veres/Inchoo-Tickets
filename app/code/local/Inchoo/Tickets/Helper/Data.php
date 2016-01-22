<?php


class Inchoo_Tickets_Helper_Data extends Mage_Core_Helper_Data
{
    public function getStatuses()
    {
        return array(
            Inchoo_Tickets_Model_Tickets::STATUS_DISABLED => $this->__('Closed'),
            Inchoo_Tickets_Model_Tickets::STATUS_ENABLED => $this->__('Opened'),
        );
    }
}