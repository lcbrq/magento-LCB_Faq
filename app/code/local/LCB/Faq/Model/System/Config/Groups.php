<?php

class LCB_Faq_Model_System_Config_Groups extends Mage_Core_Model_Config_Data {

    /**
     * Get visibility groups, use customer groups as default with possibility of overwrite
     *
     * @return array
     */
    public function toOptionArray()
    {
        
        $result = new Varien_Object();
        $groups = Mage::getResourceModel('customer/group_collection')->load();
        $options = array();
        
        foreach ($groups as $group) {
            $options[] = array(
                'label' => $group->getCustomerGroupCode(),
                'value' => $group->getCustomerGroupId()
            );
        }
        
        $result->setOptions($options);

        Mage::dispatchEvent('lcb_faq_visibility_groups', array(
            'groups' => $result
        ));
        
        return $result->getOptions();
    }

}
