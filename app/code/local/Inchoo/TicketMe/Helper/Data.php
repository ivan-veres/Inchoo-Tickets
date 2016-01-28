<?php


class Inchoo_TicketMe_Helper_Data extends Mage_Core_Helper_Data
{
    const XML_PATH_STATUS = 'inchoo_ticketme/ticket/status';
    const XML_TICKET_EMAIL_TEMPLATE = 'inchoo_ticketme/ticket/template';
    const XML_TICKET_EMAIL_RECEIVER = 'inchoo_ticketme/ticket/email';

    public function isModuleEnabled($moduleName = null)
    {
        if ((int)Mage::getStoreConfig(self::XML_PATH_STATUS, Mage::app()->getStore()) != 1)
            return false;

        return parent::isModuleEnabled($moduleName);
    }

    public function getTicketEmailTemplate($store = null)
    {
        return Mage::getStoreConfig(self::XML_TICKET_EMAIL_TEMPLATE, $store);
    }

    public function getTicketEmailReceiver($store = null)
    {
        return Mage::getStoreConfig(self::XML_TICKET_EMAIL_RECEIVER, $store);
    }
}