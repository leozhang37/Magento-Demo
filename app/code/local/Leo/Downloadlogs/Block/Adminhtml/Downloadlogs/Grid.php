<?php

class Leo_Downloadlogs_Block_Adminhtml_Downloadlogs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
			//$this->removeButton('add');
      $this->setId('downloadlogsGrid');
      $this->setDefaultSort('downloadlogs_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
			
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('downloadlogs/downloadlogs')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('downloadlogs_id', array(
          'header'    => Mage::helper('downloadlogs')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'downloadlogs_id',
      ));

      $this->addColumn('user_id', array(
          'header'    => Mage::helper('downloadlogs')->__('User ID'),
          'align'     =>'left',
          'index'     => 'user_id',
					'width'     => '80px',
      ));

	 
      $this->addColumn('product_name', array(
          'header'    => Mage::helper('downloadlogs')->__('Product Name'),
          'align'     => 'left',
          'index'     => 'product_name',
        
      ));
		  
		 
	      $this->addColumn('created_time', array(
	          'header'    => Mage::helper('downloadlogs')->__('Created At'),
	          'align'     => 'left',
						'width'		  => '180px',
	          'index'     => 'created_time',

	      ));
	  
        
		$this->addExportType('*/*/exportCsv', Mage::helper('downloadlogs')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('downloadlogs')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('downloadlogs_id');
        $this->getMassactionBlock()->setFormFieldName('downloadlogs');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('downloadlogs')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('downloadlogs')->__('Are you sure?')
        ));

       
        return $this;
    }

  public function getRowUrl($row)
  {
      //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}