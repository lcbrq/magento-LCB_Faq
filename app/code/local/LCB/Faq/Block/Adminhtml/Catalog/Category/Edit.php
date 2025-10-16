<?php

class LCB_Faq_Block_Adminhtml_Catalog_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'faq';
        $this->_controller = 'adminhtml_catalog_category';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete'));
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        $categoryId = (int)Mage::app()->getRequest()->getParam('category_id');
        if (!$categoryId) {
            $faq = Mage::registry('lcb_catalog_category_faq');
            if ($faq && $faq->getCategoryId()) {
                $categoryId = (int) $faq->getCategoryId();
            }
        }

        $storeId = (int)Mage::app()->getRequest()->getParam('store');

        if (!$categoryId) {
            return $this->getUrl('adminhtml/catalog_category/', array('store' => $storeId));
        }

        return $this->getUrl('adminhtml/catalog_category/edit', array(
            'id'         => $categoryId,
            'store'      => $storeId,
            'active_tab' => 'category_info_tabs_lcb_faq_items',
        ));
    }

    protected function _prepareLayout()
    {
        $this->setChild(
            'form',
            $this->getLayout()->createBlock('faq/adminhtml_item_edit_form')
        );
        return parent::_prepareLayout();
    }

    public function getHeaderText()
    {
        $faq = Mage::registry('lcb_faq_item');
        return $faq && $faq->getId()
            ? $this->__('Edit FAQ #%s', $m->getId())
            : $this->__('New');
    }
}
