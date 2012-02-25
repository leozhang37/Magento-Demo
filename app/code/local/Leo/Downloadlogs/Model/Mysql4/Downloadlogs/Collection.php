<?php

class Leo_Downloadlogs_Model_Mysql4_Downloadlogs_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('downloadlogs/downloadlogs');
    }
}