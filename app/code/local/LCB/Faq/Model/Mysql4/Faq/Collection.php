<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Mysql4_Faq_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init("faq/faq");
    }

    public function addStoreFilter($storeId)
    {
        $this->addFieldToFilter('store_id', array(
            array('finset' => array('0')),
            array('finset' => array($storeId)), ));

        return $this;
    }
}
