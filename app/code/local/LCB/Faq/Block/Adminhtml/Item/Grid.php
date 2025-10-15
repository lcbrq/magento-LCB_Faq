<?php
class LCB_Faq_Block_Adminhtml_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_categoryId=0;
    public function setCategoryId($id){ $this->_categoryId=(int)$id; return $this; }

    public function __construct(){
        parent::__construct();
        $this->setId('lcb_faq_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $catId = $this->_getCategoryId();
        $c = Mage::getModel('faq/item')->getCollection()
            ->addFieldToFilter('category_id', $catId);
        $this->setCollection($c);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $h = Mage::helper('adminhtml');
        $catId = $this->_getCategoryId(); 

        $this->addColumn('item_id',  array('header'=>'ID','index'=>'item_id','width'=>'50px'));
        $this->addColumn('question', array('header'=>$h->__('Pytanie'),'index'=>'question'));
        $this->addColumn('position', array('header'=>$h->__('Pozycja'),'index'=>'position','width'=>'80px'));
        $this->addColumn('is_active', array(
            'header'=>$h->__('Włącz'),'index'=>'is_active','type'=>'options',
            'options'=>array(0=>$h->__('Nie'),1=>$h->__('Tak')),'width'=>'80px'
        ));
        $this->addColumn('action', array(
            'header'=>$h->__('Akcje'),'width'=>'120px','type'=>'action','getter'=>'getId',
            'actions'=>array(
                array(
                    'caption'=>$h->__('Edytuj'),
                    'url'    => array('base'=>'adminhtml/faqitem/edit','params'=>array('category_id'=>$catId)),
                    'field'  =>'id'
                ),
                array(
                    'caption'=>$h->__('Usuń'),
                    'url'    => array('base'=>'adminhtml/faqitem/delete','params'=>array('category_id'=>$catId)),
                    'field'  =>'id',
                    'confirm'=>$h->__('Usunąć wpis?')
                ),
            ),
            'filter'=>false,'sortable'=>false,'is_system'=>true
        ));
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl(
            'adminhtml/faqitem/grid',
            array('_current'=>true, 'category_id'=>$this->_getCategoryId()) // <<<
        );
    }

    protected function _getCategoryId()
    {
        // 1) ustawione przez ->setCategoryId()
        if (!empty($this->_categoryId)) {
            return (int)$this->_categoryId;
        }
        // 2) przy AJAX-ie przychodzi w parametrze
        $id = (int)$this->getRequest()->getParam('category_id');
        if ($id) return $id;

        // 3) fallback z registry (edycja kategorii)
        $cat = Mage::registry('current_category');
        if ($cat && $cat->getId()) {
            return (int)$cat->getId();
        }
        return 0;
    }
   


}
