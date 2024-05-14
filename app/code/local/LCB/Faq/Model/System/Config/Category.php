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
        return array_merge(
            [Mage::helper('faq')->__('None')],
            Mage::getModel('faq/category')->getOptionArray()
        );
    }
}
