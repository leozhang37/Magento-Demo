<?php

class Leo_Downloadlogs_Block_Adminhtml_Downloadlogs_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('downloadlogs_form', array('legend'=>Mage::helper('downloadlogs')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('downloadlogs')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('downloadlogs')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('downloadlogs')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('downloadlogs')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('downloadlogs')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('downloadlogs')->__('Content'),
          'title'     => Mage::helper('downloadlogs')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getDownloadlogsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDownloadlogsData());
          Mage::getSingleton('adminhtml/session')->setDownloadlogsData(null);
      } elseif ( Mage::registry('downloadlogs_data') ) {
          $form->setValues(Mage::registry('downloadlogs_data')->getData());
      }
      return parent::_prepareForm();
  }
}