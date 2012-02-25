<?php

class Leo_Downloadlogs_Model_Mysql4_Downloadlogs extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the downloadlogs_id refers to the key field in your database table.
        $this->_init('downloadlogs/downloadlogs', 'downloadlogs_id');
    }
}