<?php

class LCB_Faq_Model_Resource_Catalog_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('faq/catalog_category');
    }
}
