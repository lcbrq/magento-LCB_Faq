<?php

/**
 * Magento FAQ
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Model_Category extends Mage_Core_Model_Abstract {

    public $id;
    public $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getCollection()
    {
        return Mage::getModel('faq/faq')->getCollection()
                        ->addFieldToFilter('category', $this->id)
                        ->addStoreFilter(Mage::app()->getStore()->getStoreId()
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        $code = strtolower($this->name);
        //Make alphanumeric (removes all other characters)
        $code = preg_replace("/[^a-z0-9_\s-]/", "", $code);
        //Clean up multiple dashes or whitespaces
        $code = preg_replace("/[\s-]+/", " ", $code);
        //Convert whitespaces and underscore to dash
        $code = preg_replace("/[\s_]/", "-", $code);
        return $code;
    }

}
