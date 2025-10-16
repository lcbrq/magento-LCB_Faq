<?php

class LCB_Faq_Model_Observer
{
    /**
     * Dodaje zakładkę "FAQ" na stronie edycji kategorii
     */

    public function addFaqGridTab(Varien_Event_Observer $observer)
    {
        $tabs = $observer->getEvent()->getTabs();
        $category = Mage::registry('current_category');
        if (!$category || !$category->getId()) {
            return;
        } // tylko istniejące kategorie

        $tabs->addTab('lcb_faq_items', array(
            'label'   => Mage::helper('adminhtml')->__('FAQ'),
            'content' => Mage::app()->getLayout()
                ->createBlock('faq/adminhtml_item')   // alias bloków = faq
                ->setCategoryId((int)$category->getId())
                ->toHtml(),
            'after'   => 'features' // albo 'general' – jak chcesz
        ));
    }


}
