<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct()
    {
        $this->_init("faq/category", "id");
    }
    
    /**
     * Pass visibility groups as array
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $object->setVisibilityGroups(explode(',', $object->getVisibilityGroups()));
        return parent::_afterLoad($object);
    }

}
