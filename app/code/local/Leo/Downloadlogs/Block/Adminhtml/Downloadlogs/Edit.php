<?php

class Leo_Downloadlogs_Block_Adminhtml_Downloadlogs_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'downloadlogs';
        $this->_controller = 'adminhtml_downloadlogs';
        
        $this->_updateButton('save', 'label', Mage::helper('downloadlogs')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('downloadlogs')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('downloadlogs_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'downloadlogs_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'downloadlogs_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('downloadlogs_data') && Mage::registry('downloadlogs_data')->getId() ) {
            return Mage::helper('downloadlogs')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('downloadlogs_data')->getTitle()));
        } else {
            return Mage::helper('downloadlogs')->__('Add Item');
        }
    }
}