<?php


class Inchoo_Tickets_MessageController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();

        if (!$this->getRequest()->isDispatched()) {
            return;
        }

        if (!$this->_getSession()->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }

    protected function _initTicket($ticketId = null)
    {
        if (null === $ticketId) {
            $ticketId = (int)$this->getRequest()->getParam('ticket_id');
        }

        if (!$ticketId) {
            $this->_redirect('tickets');
            return false;
        }

        $ticket = Mage::getModel('inchoo_tickets/tickets')->load($ticketId);

        if ($this->_canViewTicket($ticket)) {
            Mage::register('current_ticket', $ticket);
        } else {
            return false;
        }
        return true;
    }

    protected function _canViewTicket($ticket)
    {
        $websiteId = Mage::app()->getWebsite()->getId();
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($ticket->getTicketId() && $ticket->getCustomerId() && ($customerId === $ticket->getCustomerId())
            && ($ticket->getWebsiteId() === $websiteId)
        ) {
            return true;
        } else {
            return false;
        }
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function newAction()
    {
        $this->loadLayout();

        $this->_initLayoutMessages('customer/session');

        if (!$this->_initTicket()) {
            $this->_redirect('*/*/');
            return;
        }

        $this->renderLayout();
    }

    public function newPostAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }


        if ($this->getRequest()->isPost()) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $session = Mage::getSingleton('core/session');
            $_ticketId = $this->getRequest()->getParam('ticket_id');
            $data = $this->getRequest()->getPost();
            $message = Mage::getModel('inchoo_tickets/messages')->setData($data);

            $validate = $message->validate();

            if (true === $validate) {
                try {
                    $_ticket = Mage::getModel('inchoo_tickets/tickets')->load($_ticketId);
                    $message->setCustomerID($customer->getId())
                        ->setTicketId($_ticket->getTicketId())
                        ->save();

                    $session->addSuccess($this->__('You replied to ticket #') . $_ticket->getTicketId());
                    $this->_redirect('*/ticket/view', array('ticket_id' => $_ticket->getTicketId()));
                    return;
                } catch (Exception $e) {
                    $session->setFormData($data);
                    $session->addError($this->__('Unable to submit message.'));
                }
            } else {
                $session->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $session->addError($errorMessage);
                    }
                } else {
                    $session->addError($this->__('Unable to submit message.'));
                }
            }
        }
        $this->_redirectReferer();
    }
}