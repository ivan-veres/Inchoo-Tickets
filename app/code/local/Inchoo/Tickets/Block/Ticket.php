<?php


class Inchoo_Tickets_Block_Ticket extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();

        $this->setAndPrepareTicketCollection();
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'sales.order.history.pager')
            ->setCollection($this->getTickets());
        $this->setChild('pager', $pager);

        return $this;
    }

    protected function setAndPrepareTicketCollection()
    {
        $tickets = Mage::getModel('inchoo_tickets/tickets')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
            ->addFieldToFilter('website_id', Mage::app()->getWebsite()->getId())
            ->setOrder('created_at', 'desc')
        ;

        $this->setTickets($tickets);
    }

    protected function getMessages()
    {
        $ticket = $this->getTicket();
        $messages = Mage::getModel('inchoo_tickets/messages')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('ticket_id', $ticket->getTicketId())
            ->setOrder('created_at', 'asc')
        ;

        return $messages;
    }

    public function getNewTicketUrl()
    {
        return $this->getUrl('*/ticket/new', array('_secure' => true));
    }

    public function getNewMessageurl()
    {
        return $this->getUrl('*/message/new', array('_secure' => true));
    }

    public function getReplyUrl()
    {
        return $this->getUrl('*/message/new', array('_secure' => true));
    }

    public function getCloseTicketUrl($ticketId)
    {
        return $this->getUrl('*/*/closePost', array('_secure' => true, 'ticket_id' => $ticketId));
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getViewUrl($ticket)
    {
        return $this->getUrl('tickets/ticket/view', array('ticket_id' => $ticket->ticketId));
    }

    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }

    public function getFormSaveTicketUrl()
    {
        return Mage::getUrl('tickets/ticket/newPost', array('_secure'=>true));
    }

    public function getFormSaveMessageUrl()
    {
        return Mage::getUrl('tickets/message/newPost', array('_secure'=>true));
    }

    public function getBackUrl()
    {
        return $this->getUrl('tickets', array('_secure'=>true));
    }

    public function getBackToTicketUrl()
    {
        return $this->getUrl('tickets/ticket/view', array('_secure'=>true, 'ticket_id' => Mage::getSingleton('customer/session')->getTicket()->getTicketId()));
    }

}