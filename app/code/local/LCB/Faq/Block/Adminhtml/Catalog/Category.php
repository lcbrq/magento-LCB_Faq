<?php

class LCB_Faq_Block_Adminhtml_Catalog_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_categoryId;

    public function __construct()
    {
        $this->_blockGroup = 'faq';
        $this->_controller = 'adminhtml_catalog_category';
        $this->_headerText = Mage::helper('adminhtml')->__('FAQ');

        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $categoryId = $this->getCategoryId();

        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('faq/adminhtml_catalog_category_grid')
                ->setCategoryId($categoryId)
        );

        $this->_addButton('add', array(
            'label'   => Mage::helper('adminhtml')->__('Add'),
            'class'   => 'add',
            'onclick' => "setLocation('" . $this->getUrl('adminhtml/catalogCategoryFaq/new', array('category_id' => $categoryId)) . "')"
        ));

        return parent::_prepareLayout();
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setCategoryId($id)
    {
        $this->_categoryId = (int)$id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        if (!empty($this->_categoryId)) {
            return (int)$this->_categoryId;
        }

        $category = Mage::registry('current_category');
        if ($category && $category->getId()) {
            $id = (int) $category->getId();
        }

        if (!$id = (int)Mage::app()->getRequest()->getParam('category_id')) {
            $id = (int)Mage::app()->getRequest()->getParam('id');
        }

        return $id;
    }
}
