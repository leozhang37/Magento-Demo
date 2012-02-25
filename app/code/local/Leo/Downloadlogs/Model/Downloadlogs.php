<?php

class Leo_Downloadlogs_Model_Downloadlogs extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('downloadlogs/downloadlogs');
    }
}