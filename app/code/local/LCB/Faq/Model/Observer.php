<?php

class LCB_Faq_Model_Observer
{
    /**
     * Add FAQ grid to catalog_category entity
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addFaqGridTab(Varien_Event_Observer $observer)
    {
        $tabs = $observer->getEvent()->getTabs();
        $category = Mage::registry('current_category');
        if (!$category || !$category->getId()) {
            return;
        }

        $tabs->addTab('catalog_category_faq', array(
            'label'   => Mage::helper('adminhtml')->__('FAQ'),
            'content' => Mage::app()->getLayout()
                ->createBlock('faq/adminhtml_catalog_category')
                ->setCategoryId((int)$category->getId())
                ->toHtml(),
            'after'   => 'features'
        ));
    }

}
