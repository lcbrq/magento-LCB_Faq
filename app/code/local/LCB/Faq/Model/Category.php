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
        $collection = Mage::getModel('faq/faq')->getCollection()
                        ->addFieldToFilter('category',  ['finset' => $this->getId()])
                        ->addStoreFilter(Mage::app()->getStore()->getStoreId()
        );
        
        /**
         * Release event for custom visibility hook
         */
        $dispatch = new Varien_Object;
        $event = Mage::dispatchEvent('lcb_faq_set_visibility', array(
            'collection' => $collection,
            'dispatch' => $dispatch
        ));

        if (!$dispatch->getProcessed()) {
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                $collection->addFieldToFilter(
                        array('visibility_groups', 'visibility_groups'), array(
                            array('null' => true),
                            array('finset' => $customerGroupId)
                        )
                );
            } else {
                $collection->addFieldToFilter(
                        array('visibility_groups', 'visibility_groups'), array(
                            array('null' => true),
                            array('finset' => Mage_Customer_Model_Group::NOT_LOGGED_IN_ID)
                        )
                );
            }
        }

        return $collection;
        
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
    
    /**
     * Check if category is visible
     * 
     * @return boolean
     */
    public function isVisible()
    {
        
        $visibilityGroups = $this->getVisibilityGroups();
        
        $visibility = new Varien_Object;
        $visibility->setIsVisible(true);
        
        if ($visibilityGroups && Mage::getDesign()->getArea() == 'frontend') {
            $visibilityGroups = explode(',', $visibilityGroups);
            
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                if (!in_array($customerGroupId, $visibilityGroups)) {
                    $visibility->setIsVisible(false);
                }
            } else {
                if (!in_array(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID, $visibilityGroups)) {
                    $visibility->setIsVisible(false);
                }
            }

            /**
             * Release event for custom visibility hook
             */
            Mage::dispatchEvent('lcb_faq_category_visibility', array(
                'category' => $this,
                'visibility' => $visibility
            ));
        }

        return $visibility->getIsVisible();
    }
 
}
