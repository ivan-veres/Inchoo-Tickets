<?php

class Inchoo_Tickets_Block_Adminhtml_Ticket_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('inchoo/ticket/view/form.phtml');
    }
}