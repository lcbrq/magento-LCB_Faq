<?php

class LCB_Faq_Adminhtml_CatalogCategoryFaqController extends Mage_Adminhtml_Controller_Action
{
    protected function _initItem()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $faq  = Mage::getModel('faq/catalog_category');
        if ($id) {
            $faq->load($id);
        }

        Mage::register('lcb_catalog_category_faq', $faq);
        return $faq;
    }

    public function gridAction()
    {
        $block = $this->getLayout()->createBlock('faq/adminhtml_catalog_category_grid')
            ->setCategoryId((int)$this->getRequest()->getParam('category_id'));
        $this->getResponse()->setBody($block->toHtml());
    }

    public function editAction()
    {
        $this->_initItem();

        $this->loadLayout();

        $layout = $this->getLayout();

        $editBlock = $layout->createBlock('faq/adminhtml_catalog_category_edit');
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
                $faq = $this->_initItem();
                $faq->addData($data);

                $categoryId = (int)$this->getRequest()->getParam('category_id');
                if (!$categoryId && isset($data['category_id'])) {
                    $categoryId = (int)$data['category_id'];
                }
                if ($categoryId > 0) {
                    $faq->setCategoryId($categoryId);
                }

                $faq->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Saved'));

                $storeId = (int)$this->getRequest()->getParam('store');
                return $this->_redirect('adminhtml/catalog_category/edit', array(
                    'id'         => (int)$faq->getCategoryId(),
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
        $categoryId = (int)$this->getRequest()->getParam('category_id');

        try {
            if ($id) {
                if (!$categoryId) {
                    $categoryId = (int)Mage::getModel('faq/catalog_category')->load($id)->getCategoryId();
                }
                Mage::getModel('faq/catalog_category')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Deleted.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $storeId = (int)$this->getRequest()->getParam('store');

        return $this->_redirect('adminhtml/catalog_category/edit', array(
            'id'         => $categoryId ?: null,
            'store'      => $storeId,
            'active_tab' => 'category_info_tabs_lcb_faq_items',
        ));
    }
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids', array());
        if (!is_array($ids) || empty($ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('No items selected.'));
            return $this->_redirectReferer();
        }

        try {
            $count = 0;
            foreach ($ids as $id) {
                Mage::getModel('faq/catalog_category')->setId((int)$id)->delete();
                $count++;
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('%d item(s) have been deleted.', $count)
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $categoryId = (int)$this->getRequest()->getParam('category_id');
        $storeId    = (int)$this->getRequest()->getParam('store');

        return $this->_redirect('adminhtml/catalog_category/edit', array(
            'id'         => $categoryId ?: null,
            'store'      => $storeId,
            'active_tab' => 'category_info_tabs_lcb_faq_items',
        ));
    }
}
