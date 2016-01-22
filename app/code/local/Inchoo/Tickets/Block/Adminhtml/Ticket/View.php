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
        $_ticket = $this->getTicket();

        $this->_addButton('back', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/')}')",
            'class'     => 'back',
        ));

        if ($_ticket->canClose()) {
            $this->_addButton('close', array(
                'label'     => Mage::helper('adminhtml')->__('Close'),
                'class'     => 'delete',
                'onclick'   => 'deleteConfirm(\''
                    . Mage::helper('core')->jsQuoteEscape(
                        Mage::helper('adminhtml')->__('Are you sure you want to do this?')
                    )
                    .'\', \''
                    . $this->getCloseUrl()
                    . '\')',
            ));
        }
    }

    protected function _beforeToHtml()
    {
        $ticket = $this->getTicket();
        $this->_headerText = Mage::helper('inchoo_tickets')->__('Ticket #%s - %s', $ticket->getTicketId(), $ticket->getSubject());
        $this->setViewHtml('<div id="' . $this->getDestElementId() . '"></div>');
        return parent::_beforeToHtml();
    }

    public function getTicket()
    {
        return Mage::registry('current_ticket');
    }

    protected function getCloseUrl()
    {
        return $this->getUrl('*/*/close', array('ticket_id' => $this->getTicket()->getTicketId()));
    }

}