<?php


class Inchoo_Tickets_IndexController extends Mage_Core_Controller_Front_Action
{
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
}