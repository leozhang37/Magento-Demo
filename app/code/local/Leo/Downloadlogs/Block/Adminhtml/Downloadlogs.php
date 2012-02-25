<?php
class Leo_Downloadlogs_Block_Adminhtml_Downloadlogs extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_downloadlogs';
    $this->_blockGroup = 'downloadlogs';
    $this->_headerText = Mage::helper('downloadlogs')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('downloadlogs')->__('Add Item');
    parent::__construct();
  }
}