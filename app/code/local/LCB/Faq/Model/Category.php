<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Category extends Mage_Core_Model_Abstract {

    protected function _construct()
    {
        $this->_init("faq/category");
    }

    public function getFaqCollection()
    {
        return Mage::getModel('faq/faq')->getCollection()
                        ->addFieldToFilter('category', $this->id)
                        ->addStoreFilter(Mage::app()->getStore()->getStoreId()
        );
    }

    public function getOptionArray()
    {

        $array = array();

        foreach ($this->getCollection() as $category) {
            $array[$category->getId()] = $category->getName();
        }

        return $array;
    }

    public function getCode()
    {
        $code = strtolower($this->name);
        $code = preg_replace("/[^a-z0-9_\s-]/", "", $code);
        $code = preg_replace("/[\s-]+/", " ", $code);
        $code = preg_replace("/[\s_]/", "-", $code);
        return $code;
    }

}
