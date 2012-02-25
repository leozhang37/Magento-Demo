<?php

class Leo_Downloadlogs_Block_Adminhtml_Downloadlogs_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('downloadlogs_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('downloadlogs')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('downloadlogs')->__('Item Information'),
          'title'     => Mage::helper('downloadlogs')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('downloadlogs/adminhtml_downloadlogs_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}