<?php

class LCB_Faq_Model_System_Config_Category extends Mage_Core_Model_Config_Data
{
    /**
     * Get default category dropdown values
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            Mage::helper('faq')->__('None'),
        ];
        $categories = Mage::getModel('faq/category')->getCollection();

        foreach ($categories as $category) {
            $options[$category->getId()] = $category->getId() . ' - ' . $category->getName();
        }

        return $options;
    }
}
