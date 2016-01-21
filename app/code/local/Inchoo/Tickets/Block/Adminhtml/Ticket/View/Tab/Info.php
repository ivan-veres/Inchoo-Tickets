<?php

class Inchoo_Tickets_Block_Adminhtml_Ticket_View_Tab_Info extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('inchoo_tickets')->__('Info');
    }

    public function getTabTitle()
    {
        return Mage::helper('inchoo_tickets')->__('Ticket Info');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}