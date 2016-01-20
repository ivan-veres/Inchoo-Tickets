<?php


class Inchoo_Tickets_Adminhtml_TicketsController extends Mage_Adminhtml_Controller_Action
{
    public function _initTicket()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('inchoo_tickets/tickets')->load($id);

        if (!$ticket->getId()) {
            $this->_getSession()->addError($this->__('This ticket no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('current_ticket', $ticket);
        return $ticket;
    }
    public function indexAction()
    {
        $this->_title($this->__('Tickets'))->_title($this->__('Tickets Inchoo'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('inchoo_tickets/adminhtml_ticket'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('inchoo_tickets/adminhtml_grid')->toHtml()
        );
    }

    public function viewAction()
    {
        $ticket = $this->_initTicket();

        $this->loadLayout();

        $this->_title(sprintf("#%s", $ticket->getTicketId()));

        $this->renderLayout();
    }
}