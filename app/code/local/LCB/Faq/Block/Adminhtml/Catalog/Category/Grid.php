<?php

class LCB_Faq_Block_Adminhtml_Catalog_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_categoryId = 0;

    public function setCategoryId($id)
    {
        $this->_categoryId = (int) $id;
        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setId('lcb_catalog_category_faq_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $categoryId = $this->_getCategoryId();
        $collection = Mage::getModel('faq/catalog_category')->getCollection()
            ->addFieldToFilter('category_id', $categoryId);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $categoryId = $this->_getCategoryId();

        $this->addColumn('entity_id', array(
            'header' => 'ID',
            'index' => 'entity_id',
            'width' => '50px'
        ));

        $this->addColumn('question', array(
            'header' => Mage::helper('faq')->__('Question'),
            'index' => 'question'
        ));

        $this->addColumn('position', array(
            'header' => Mage::helper('faq')->__('Position'),
            'index' => 'position',
            'width' => '80px'
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('faq')->__('Włącz'),
            'index' => 'is_active','type' => 'options',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
        ));

        $this->addColumn('action', array(
            'header' =>  Mage::helper('faq')->__('Akcje'),
            'width' => '120px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' =>  Mage::helper('faq')->__('Edytuj'),
                    'url'    => array(
                        'base' => 'adminhtml/catalogCategoryFaq/edit',
                        'params' => array('category_id' => $categoryId)
                     ),
                    'field'  => 'id'
                ),
                array(
                    'caption' =>  Mage::helper('faq')->__('Usuń'),
                    'url'    => array('base' => 'adminhtml/catalogCategoryFaq/delete','params' => array('category_id' => $categoryId)),
                    'field'  => 'id',
                    'confirm' =>  Mage::helper('faq')->__('Usunąć wpis?')
                ),
            ),
            'filter' => false,'sortable' => false,'is_system' => true
        ));

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            'adminhtml/catalogCategoryFaq/grid',
            array('_current' => true, 'category_id' => $this->_getCategoryId())
        );
    }

    protected function _getCategoryId()
    {
        if (!empty($this->_categoryId)) {
            return (int)$this->_categoryId;
        }

        if ($id = (int)$this->getRequest()->getParam('category_id')) {
            return $id;
        }

        $category = Mage::registry('current_category');
        if ($category && $category->getId()) {
            return (int) $category->getId();
        }

        return 0;
    }

}
