<?php

/**
 * Magento FAQ
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Index extends Mage_Core_Block_Template {

    public function getCategories()
    {
        $categories = array();
        $options = LCB_Faq_Block_Adminhtml_Faq_Grid::getCategoriesOptions();
        foreach ($options as $id => $name) {
            if (!empty($name)) {
                $category = new LCB_Faq_Model_Category($id, $name);
                $categories[] = $category;
            }
        }
        return $categories;
    }

}
