<?php


class Inchoo_Tickets_Adminhtml_TicketsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Tickets'))->_title($this->__('Tickets Inchoo'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('inchoo_tickets/adminhtml_ticket'));
        $this->renderLayout();
    }

    public function viewAction()
    {
        $ticket = $this->_initTicket();
        $this->loadLayout();
        $this->_title(sprintf("#%s", $ticket->getTicketId()));
        $this->renderLayout();
    }

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

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('inchoo_tickets/adminhtml_ticket_grid')->toHtml()
        );
    }

    public function closeAction()
    {
        $_session = Mage::getSingleton('adminhtml/session');
        $_ticketId = $this->getRequest()->getParam('ticket_id');

        if (!$_ticketId) {
            try {
                $currentTime = Varien_Date::now();
                Mage::getModel('inchoo_tickets/tickets')->load($_ticketId)
                    ->setStatus(Inchoo_Tickets_Model_Tickets::STATUS_DISABLED)
                    ->setClosedAt($currentTime)
                    ->save();
                $_session->addSuccess(
                    Mage::helper('inchoo_tickets')->__('Ticket #%s was successfully closed.', $_ticketId)
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $_session->addError($e->getMessage());
                $this->_redirect('*/*/view', array('ticket_id' => $_ticketId));
            } catch (Exception $e) {
                Mage::logException($e);
                $_session->addError(
                    Mage::helper('inchoo_tickets/tickets')->__('There was an error closing the ticket.')
                );
                $this->_redirect('*/*/view', array('ticket_id' => $_ticketId));
                return;
            }
        }
        $_session->addError(
            Mage::helper('inchoo_tickets/tickets')->__('Could not find the ticket.')
        );
    }

    public function messagePostAction()
    {
        if ($_ticket = $this->_initTicket()) {
            try {
                $data = $this->getRequest()->getPost();
                $message = Mage::getModel('inchoo_tickets/messages')->setData($data);
                $currentTime = Varien_Date::now();

                $message->setTicketId($_ticket->getTicketId())
                    ->setAdminId(Mage::getSingleton('admin/session')->getUser()->getUserId())
                    ->setCreatedAt($currentTime)
                    ->save();

                $this->loadLayout('empty');
                $this->renderLayout();
            } catch (Mage_Core_Exception $e) {
                Mage::logException($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage());
            }
        }
    }
}