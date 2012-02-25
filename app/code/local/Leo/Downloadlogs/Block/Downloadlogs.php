<?php
class Leo_Downloadlogs_Block_Downloadlogs extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDownloadlogs()     
     { 
        if (!$this->hasData('downloadlogs')) {
            $this->setData('downloadlogs', Mage::registry('downloadlogs'));
        }
        return $this->getData('downloadlogs');
        
    }
}