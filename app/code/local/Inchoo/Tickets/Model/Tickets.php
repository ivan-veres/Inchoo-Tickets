<?php


class Inchoo_Tickets_Model_Tickets extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getSubject(), 'NotEmpty')) {
            $errors[] = Mage::helper('inchoo_tickets')->__('Subject can\'t be empty');
        }

        if (!Zend_Validate::is($this->getMessage(), 'NotEmpty')) {
            $errors[] = Mage::helper('inchoo_tickets')->__('Message can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }

        return $errors;
    }

    public function canClose()
    {
        if (!$this->getStatus()) {
            return false;
        }
        return true;
    }

    public function canReply()
    {
        if (!$this->getStatus()) {
            return false;
        }
        return true;
    }

    protected function _construct()
    {
        $this->_init('inchoo_tickets/tickets');
    }
}