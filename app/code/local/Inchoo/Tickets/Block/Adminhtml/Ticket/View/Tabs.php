<?php


class Inchoo_Tickets_Adminhtml_Block_Ticket_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('tickets_ticket_view_tabs');
        $this->setDestElementId('tickets_ticket_view');
        $this->setTitle(Mage::helper('inchoo_tickets')->__('Ticket View'));
    }

    public function getOrder()
    {
        /**
         * TODO:
         */
        return null;
    }
}