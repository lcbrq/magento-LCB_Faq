<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Resource_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init("faq/category");
    }

    public function addStoreFilter($storeId)
    {
        $this->addFieldToFilter('store_id', array(
            array('finset' => array('0')),
            array('finset' => array($storeId)), ));

        return $this;
    }

    /**
     * Get category childrens
     * @param  int   $id
     * @return $this
     */
    public function getChildrenCategories($id)
    {
        $this->addFieldToFilter('parent_id', array(
            array('finset' => array($id)), ));

        return $this;
    }
}
