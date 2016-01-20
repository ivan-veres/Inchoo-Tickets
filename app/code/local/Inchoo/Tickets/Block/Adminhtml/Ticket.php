<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_tickets';
        $this->_controller = 'adminhtml_ticket';
        $this->_headerText = Mage::helper('inchoo_tickets')->__('Tickets');

        parent::__construct();
        $this->removeButton('add');
    }
}