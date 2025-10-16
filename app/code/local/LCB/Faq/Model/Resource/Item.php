<?php

class LCB_Faq_Model_Resource_Item extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('faq/item', 'item_id');
    }
}
