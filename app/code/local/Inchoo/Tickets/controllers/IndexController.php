<?php


class Inchoo_Tickets_IndexController extends Mage_Core_Controller_Front_Action
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

    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );

        $this->getLayout()->getBlock('head')->setTitle($this->__('My Tickets'));

        $this->renderLayout();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}