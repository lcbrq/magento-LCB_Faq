<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Index extends Mage_Core_Block_Template {

    public function getCategories()
    {
        $categories = array();
        foreach (Mage::getModel('faq/category')->getCollection() as $category) {
            $categories[$category->getId()] = $category;
        }
        return $categories;
    }

}
