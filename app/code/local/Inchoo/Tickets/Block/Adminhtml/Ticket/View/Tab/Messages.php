<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket_View_Tab_Messages extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected $_ticket;

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('inchoo/messages.phtml');
    }
    public function getTicket()
    {
        if (!$this->_ticket) {
            return $this->_ticket = Mage::registry('current_ticket');
        }

        return $this->_ticket;
    }

    public function getTicketMessages()
    {
        $messages = Mage::getModel('inchoo_tickets/messages')->getCollection()
            ->addFieldToFilter('ticket_id', $this->getTicket()->getTicketId())
            ->setOrder('created_at', 'asc');

        return $messages;
    }

    public function getTicketCreator()
    {
        $creator = Mage::getModel('customer/customer')
            ->load($this->getTicket()->getCustomerId());

        return $creator;
    }

    public function getAdminFirstname($adminId)
    {
        $adminFirstname = Mage::getModel('admin/user')
            ->load($adminId)
            ->getFirstname();

        return $adminFirstname;
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