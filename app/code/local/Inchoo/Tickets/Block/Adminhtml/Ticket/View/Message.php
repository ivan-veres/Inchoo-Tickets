<?php

class Inchoo_Tickets_Block_Adminhtml_Ticket_View_Message extends Mage_Adminhtml_Block_Template
{
    protected function _prepareLayout()
    {
        $onclick = "submitAndReloadArea($('inchoo_ticket_view_tabs_view_tab_content'), '" . $this->getSubmitUrl() . "')";
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('sales')->__('Submit Message'),
                'class' => 'save',
                'onclick' => $onclick
            ));
        $this->setChild('submit_button', $button);
        return parent::_prepareLayout();
    }

    public function getSubmitUrl()
    {
        return $this->getUrl('*/*/messagePost', array('ticket_id' => $this->getTicket()->getTicketId()));
    }

    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }
}