<?php


class Inchoo_Tickets_TicketController extends Mage_Core_Controller_Front_Action
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

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function viewAction()
    {
        $this->loadLayout();

        if (!$this->_initTicket()) {
            $this->_redirect('tickets');
            return;
        }

        $this->renderLayout();
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
            Mage::getSingleton('customer/session')->setTicket($ticket);
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

    public function newAction()
    {
        $this->loadLayout();

        $this->_initLayoutMessages('customer/session');

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
            $data = $this->getRequest()->getPost();
            $ticket = Mage::getModel('inchoo_tickets/tickets')->setData($data);

            $validate = $ticket->validate();

            if (true === $validate) {
                try {
                    $currentTime = Varien_Date::now();
                    $ticket->setCustomerID($customer->getId())
                        ->setStatus(Inchoo_Tickets_Model_Tickets::STATUS_ENABLED)
                        ->setCreatedAt($currentTime)
                        ->setWebsiteId(Mage::app()->getWebsite()->getId())
                        ->save();

                    $session->addSuccess($this->__('Your ticket has been submitted.'));
                    $this->_redirect('tickets');
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

    public function closePostAction()
    {
        $session = Mage::getSingleton('core/session');
        $ticketId = $this->getRequest()->getParam('ticket_id');
        $_ticket = Mage::getModel('inchoo_tickets/tickets')->load($ticketId);


        if (!$ticketId || $_ticket->getCustomerId() !== Mage::getSingleton('customer/session')->getId()) {
            $session->addError($this->__('Unable to close ticket!'));
            $this->_redirect('tickets');
            return;
        }

        if ($_ticket->canClose()) {
            try {
                $currentTime = Varien_Date::now();
                $_ticket->setStatus(Inchoo_Tickets_Model_Tickets::STATUS_DISABLED)
                    ->setClosedAt($currentTime)
                    ->save();
                $session->addSuccess($this->__('Ticket #%s has been closed.', $_ticket->getTicketId()));
            } catch (Exception $e) {
                $session->addError($this->__('Something went wrong.'));
                $this->_redirect('tickets');
                return;
            }
        }

        $this->_redirect('*/');
        return;
    }
}