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
            $message = Mage::getModel('inchoo_tickets/messages')->setData($data);

            $validate = $message->validate();

            if (true === $validate) {
                try {
                    $_ticket = Mage::getSingleton('customer/session')->getTicket();
                    $currentTime = Varien_Date::now();
                    $message->setCustomerID($customer->getId())
                        ->setTicketId($_ticket->getTicketId())
                        ->setCreatedAt($currentTime)
                        ->save();

                    $session->addSuccess($this->__('You replied to ticket #') . $_ticket->getTicketId());
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

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}