<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Adminhtml_CategoriesController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("faq/faq")->_addBreadcrumb(Mage::helper("adminhtml")->__("Faq  Manager"), Mage::helper("adminhtml")->__("Faq Manager"));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__("Faq"));
        $this->_title($this->__("Manager Faq"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__("Faq"));
        $this->_title($this->__("Faq"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("faq/category")->load($id);
        if ($model->getId()) {
            Mage::register("faq_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("faq/faq");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Manager"), Mage::helper("adminhtml")->__("Category Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Description"), Mage::helper("adminhtml")->__("Category Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("faq/adminhtml_category_edit"))->_addLeft($this->getLayout()->createBlock("faq/adminhtml_category_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("faq")->__("Category does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction()
    {

        $this->_title($this->__("Categories"));
        $this->_title($this->__("Categories"));
        $this->_title($this->__("New Category"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("faq/category")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("faq_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("faq/category");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Manager"), Mage::helper("adminhtml")->__("Category Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Description"), Mage::helper("adminhtml")->__("Category Description"));

        $this->_addContent($this->getLayout()->createBlock("faq/adminhtml_category_edit"))->_addLeft($this->getLayout()->createBlock("faq/adminhtml_category_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction()
    {

        $post_data = $this->getRequest()->getPost();


        if ($post_data) {

            try {

                if (isset($post_data['stores'])) {
                    if (in_array('0', $post_data['stores'])) {
                        $post_data['store_id'] = '0';
                    } else {
                        $post_data['store_id'] = join(",", $post_data['stores']);
                    }
                    unset($post_data['stores']);
                }

                $model = Mage::getModel("faq/category")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Category was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setFaqData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setFaqData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("faq/faq");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("faq/faq");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'faq.csv';
        $grid = $this->getLayout()->createBlock('faq/adminhtml_faq_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'faq.xml';
        $grid = $this->getLayout()->createBlock('faq/adminhtml_faq_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
