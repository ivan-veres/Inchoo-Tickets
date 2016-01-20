<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'ticket_id';
        $this->_controller = 'adminhtml_ticket';
        $this->_mode = 'view';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->setId('tickets_ticket_view');
        $ticket = $this->getTicket();

    }

    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }

}