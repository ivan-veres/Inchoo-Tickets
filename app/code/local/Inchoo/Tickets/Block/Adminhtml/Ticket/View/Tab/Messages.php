<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket_View_Tab_Messages extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('inchoo/messages.phtml');
    }
    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }

    public function getTicketMessages()
    {
        $messages = Mage::getModel('inchoo_tickets/messages')->getCollection()
            ->addFieldToFilter('ticket_id', $this->getTicket()->getTicketId())
            ->setOrder('created_at', 'desc');

        return $messages;
    }

    public function getTicketCreator()
    {
        $ticket = $this->getTicket();
        $creator = Mage::getModel('customer/customer')
            ->load($ticket->getCustomerId());

        return $creator;
    }

    public function getTabLabel()
    {
        return Mage::helper('inchoo_tickets')->__('Messages');
    }

    public function getTabTitle()
    {
        return Mage::helper('inchoo_tickets')->__('Ticket Messages');
    }

    public function getTabUrl()
    {
        return $this->getUrl('*/*/messages', array('_current' => true));
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