<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket_View extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->_objectId = 'ticket_id';
        $this->_controller = 'adminhtml_ticket';
        $this->_mode = 'view';
        $this->_blockGroup = 'inchoo_tickets';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->setId('tickets_ticket_view');

        $this->_addButton('close', array(
            'label'     => Mage::helper('adminhtml')->__('Close'),
            'class'     => 'delete',
            'onclick'   => 'deleteConfirm(\''
                . Mage::helper('core')->jsQuoteEscape(
                    Mage::helper('adminhtml')->__('Are you sure you want to do this?')
                )
                .'\', \''
                . $this->getDeleteUrl()
                . '\')',
        ));

    }

    protected function _prepareLayout()
    {
        $this->_addButton('back', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/')}')",
            'class'     => 'back',
        ));

        $this->_addButton('close', array(
            'label'     => Mage::helper('adminhtml')->__('Close'),
            'class'     => 'delete',
            'onclick'   => 'deleteConfirm(\''
                . Mage::helper('core')->jsQuoteEscape(
                    Mage::helper('adminhtml')->__('Are you sure you want to do this?')
                )
                .'\', \''
                . $this->getDeleteUrl()
                . '\')',
        ));

        return parent::_prepareLayout();
    }

    protected function _beforeToHtml()
    {
        $ticket = $this->getTicket();
        $this->_headerText = Mage::helper('inchoo_tickets')->__('Ticket # %s', $ticket->getTicketId());
        $this->setViewHtml('<div id="' . $this->getDestElementId() . '"></div>');
        return parent::_beforeToHtml();
    }

    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }

}