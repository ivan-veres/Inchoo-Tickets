<?php


class Inchoo_Tickets_Block_Adminhtml_Ticket_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ticketGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('inchoo_tickets/tickets_collection')
        ;

        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('ticket_id',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('ID'),
                'width'     => '50px',
                'align'     => 'right',
                'filter_index'=> 'rt.ticket_index',
                'index'     => 'ticket_id'
            ));
        $this->addColumn('created_at',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('Created On'),
                'align'     => 'left',
                'type'      => 'datetime',
                'width'     => '160px',
                'index'     => 'created_at'
            ));
        $this->addColumn('status',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('Status'),
                'type'      => 'options',
                'options'   => Mage::helper('inchoo_tickets')->getStatuses(),
                'width'     => '60px',
                'index'     => 'status'
            ));
        $this->addColumn('subject',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('Subject'),
                'type'      => 'text',
                'width'     => '300px',
                'index'     => 'subject',
                'escape'    => true,
            ));
        $this->addColumn('message',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('Subject'),
                'type'      => 'text',
                'index'     => 'message',
                'escape'    => true,
            ));
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('inchoo_tickets')->__('Action'),
                'type'      => 'action',
                'width'     => '50px',
                'getter'    => 'getTicketId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('inchoo_tickets')->__('View'),
                        'url'       => array(
                            'base'  => '*/tickets/view',
                            'params'=> array(
                                'ticket_id' => $this->getTicketId(),
                            )
                        ),
                        'field'     => 'ticket_id'
                    ),

                ),
                'filter'    => false,
                'sortable'  => false,
            ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/tickets/view', array(
            'ticket_id' => $row->getTicketId(),
        ));
    }
}