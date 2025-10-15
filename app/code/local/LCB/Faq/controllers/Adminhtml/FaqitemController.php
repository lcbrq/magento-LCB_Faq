<?php
class LCB_Faq_Adminhtml_FaqitemController extends Mage_Adminhtml_Controller_Action
{
    protected function _initItem(){
        $id = (int)$this->getRequest()->getParam('id');
        $m  = Mage::getModel('faq/item'); 
        if ($id) $m->load($id);
        Mage::register('lcb_faq_item',$m);
        return $m;
    }

    public function gridAction(){
        $block = $this->getLayout()->createBlock('faq/adminhtml_item_grid')
            ->setCategoryId((int)$this->getRequest()->getParam('category_id'));
        $this->getResponse()->setBody($block->toHtml());
    }

    public function editAction()
    {
        $this->_initItem();

        
        $this->loadLayout();

        
        $layout = $this->getLayout();
        if (!$layout->getBlock('content')) {
            
            $layout->createBlock('Mage_Adminhtml_Block_Template', 'content');
        }

        
        $editBlock = $layout->createBlock('faq/adminhtml_item_edit');
        $layout->getBlock('content')->append($editBlock);

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $m = $this->_initItem();
                $m->addData($data);

                // category_id z URL albo z POST
                $catId = (int)$this->getRequest()->getParam('category_id');
                if (!$catId && isset($data['category_id'])) {
                    $catId = (int)$data['category_id'];
                }
                if ($catId > 0) {
                    $m->setCategoryId($catId);
                }

                $m->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Zapisano.'));

                $storeId = (int)$this->getRequest()->getParam('store');
                return $this->_redirect('adminhtml/catalog_category/edit', array(
                    'id'         => (int)$m->getCategoryId(),
                    'store'      => $storeId,
                    'active_tab' => 'category_info_tabs_lcb_faq_items', 
                ));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        return $this->_redirectReferer(); 
    }




    public function deleteAction()
    {
        $id    = (int)$this->getRequest()->getParam('id');
        $catId = (int)$this->getRequest()->getParam('category_id');

        try {
            if ($id) {
                
                if (!$catId) {
                    $catId = (int)Mage::getModel('faq/item')->load($id)->getCategoryId();
                }
                Mage::getModel('faq/item')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Usunięto.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $storeId = (int)$this->getRequest()->getParam('store');
        return $this->_redirect('adminhtml/catalog_category/edit', array(
            'id'         => $catId ?: null,
            'store'      => $storeId,
            'active_tab' => 'category_info_tabs_lcb_faq_items', 
        ));
    }

}
