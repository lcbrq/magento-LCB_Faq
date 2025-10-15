<?php
class LCB_Faq_Block_Adminhtml_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_categoryId;

    public function __construct(){
        $this->_blockGroup = 'faq';                 
        $this->_controller = 'adminhtml_item';
        $this->_headerText = Mage::helper('adminhtml')->__('FAQ - wpisy');
        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $catId = $this->getCategoryId();

        $this->setChild('grid',
            $this->getLayout()->createBlock('faq/adminhtml_item_grid')
                ->setCategoryId($catId)
        );

        $this->_addButton('add', array(
            'label'   => Mage::helper('adminhtml')->__('Dodaj'),
            'class'   => 'add',
            'onclick' => "setLocation('".$this->getUrl('adminhtml/faqitem/new', array('category_id'=>$catId))."')"
        ));

        return parent::_prepareLayout();
    }


    public function setCategoryId($id)
    {
        $this->_categoryId = (int)$id;
        return $this;
    }

    public function getCategoryId()
    {
        
        if (!empty($this->_categoryId)) {
            return (int)$this->_categoryId;
        }
        
        $cat = Mage::registry('current_category');
        if ($cat && $cat->getId()) {
            return (int)$cat->getId();
        }
        
        $id = (int)Mage::app()->getRequest()->getParam('category_id');
        if (!$id) {
            
            $id = (int)Mage::app()->getRequest()->getParam('id');
        }
        return $id;
    }
}
