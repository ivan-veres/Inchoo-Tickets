<?php


class Inchoo_Tickets_Model_Messages extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_tickets/messages');
    }

    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getMessage(), 'NotEmpty')) {
            $errors[] = Mage::helper('inchoo_tickets')->__('Message can\'t be empty');
        }

        if (empty($errors))  {
            return true;
        }

        return $errors;
    }
}