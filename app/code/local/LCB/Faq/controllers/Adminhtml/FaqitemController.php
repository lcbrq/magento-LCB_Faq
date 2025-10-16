<?php

class LCB_Faq_Adminhtml_FaqitemController extends Mage_Adminhtml_Controller_Action
{
    protected function _initItem()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $m  = Mage::getModel('faq/item'); // alias modeli = faq
        if ($id) {
            $m->load($id);
        }
        Mage::register('lcb_faq_item', $m);
        return $m;
    }

    public function gridAction()
    {
        $block = $this->getLayout()->createBlock('faq/adminhtml_item_grid')
            ->setCategoryId((int)$this->getRequest()->getParam('category_id'));
        $this->getResponse()->setBody($block->toHtml());
    }

    public function editAction()
    {
        $this->_initItem();

        // Załaduj layout admina
        $this->loadLayout();

        // DEFENSYWNIE: upewnij się, że istnieje kontener 'content'
        $layout = $this->getLayout();
        if (!$layout->getBlock('content')) {
            // w bardzo rzadkich przypadkach content nie istnieje – twórz go ręcznie
            $layout->createBlock('Mage_Adminhtml_Block_Template', 'content');
        }

        // Dołóż nasz kontener z formularzem
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
                    'active_tab' => 'category_info_tabs_lcb_faq_items', // << jedna, spójna wartość
                ));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        return $this->_redirectReferer(); // fallback
    }




    public function deleteAction()
    {
        $id    = (int)$this->getRequest()->getParam('id');
        $catId = (int)$this->getRequest()->getParam('category_id');

        try {
            if ($id) {
                // fallback: jeśli brak category_id w URL, pobierz z rekordu
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
            'active_tab' => 'category_info_tabs_lcb_faq_items', // << spójnie jak w saveAction
        ));
    }

}
