<?php


class Inchoo_Tickets_TicketController extends Mage_Core_Controller_Front_Action
{
    protected function _initTicket($ticketId = null)
    {
        if (null === $ticketId) {
            $ticketId = (int) $this->getRequest()->getParam('ticket_id');
        }

        if (!$ticketId) {
            $this->_redirect('tickets');
            return false;
        }

        $ticket = Mage::getModel('inchoo_tickets/tickets')->load($ticketId);

        if ($this->_canViewTicket($ticket)) {
            Mage::register('current_ticket', $ticket);
        } else {
            $this->_redirect('tickets');
        }
    }

    protected function _canViewTicket($ticket)
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();

        if ($ticket->ticketId && $ticket->customerId && ($customerId === $ticket->customerId)) {
            return true;
        } else {
            return false;
        }
    }

    public function viewAction()
    {
        $this->_initTicket();

        $this->loadLayout();

        $this->renderLayout();
    }

    public function newAction()
    {

    }

    public function newPostAction()
    {

    }
}