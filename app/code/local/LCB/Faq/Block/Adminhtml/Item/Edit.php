<?php
class LCB_Faq_Block_Adminhtml_Item_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'faq';
        $this->_controller = 'adminhtml_item';
        parent::__construct();

        $this->_updateButton('save','label',   Mage::helper('adminhtml')->__('Zapisz'));
        $this->_updateButton('delete','label', Mage::helper('adminhtml')->__('Usuń'));
    }

    
    public function getBackUrl()
    {
        $catId = (int)Mage::app()->getRequest()->getParam('category_id');
        if (!$catId) {
            $m = Mage::registry('lcb_faq_item');
            if ($m && $m->getCategoryId()) {
                $catId = (int)$m->getCategoryId();
            }
        }
        $storeId = (int)Mage::app()->getRequest()->getParam('store');

        if (!$catId) {
            return $this->getUrl('adminhtml/catalog_category/', array('store' => $storeId));
        }

        return $this->getUrl('adminhtml/catalog_category/edit', array(
            'id'         => $catId,
            'store'      => $storeId,
            'active_tab' => 'category_info_tabs_lcb_faq_items',
        ));
    }

    
    protected function _prepareLayout()
    {
        
        $this->setChild('form',
            $this->getLayout()->createBlock('faq/adminhtml_item_edit_form')
        );
        return parent::_prepareLayout();
    }

    public function getHeaderText(){
        $m = Mage::registry('lcb_faq_item');
        return $m && $m->getId()
            ? $this->__('Edytuj FAQ #%s', $m->getId())
            : $this->__('Nowy wpis FAQ');
    }
}
