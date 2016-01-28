<?php


class Inchoo_TicketMe_Model_Observer
{
    public function send($event)
    {
        $_helper = Mage::helper('inchoo_ticketme');
        if (!$_helper->isModuleEnabled()) {
            return;
        }

        $_ticket = $event->getTicket();
        if ($_ticket->isObjectNew()) {
            $email = Mage::getModel('core/email_template');

            try {
                $email->sendTransactional($_helper->getTicketEmailTemplate(), 'general', $_helper->getTicketEmailReceiver(),
                    null, array('ticket' => $_ticket), Mage::app()->getStore()->getId());
            } catch (Mage_Core_Exception $e) {
                Mage::logException($e);
            }
        }
    }
}