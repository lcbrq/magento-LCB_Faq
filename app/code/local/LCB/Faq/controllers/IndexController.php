<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("FAQ"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");

        if ($breadcrumbs) {
            $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link" => Mage::getBaseUrl(),
            ));

            $breadcrumbs->addCrumb("faq", array(
                "label" => $this->__("FAQ"),
                "title" => $this->__("FAQ"),
            ));
        }

        $this->renderLayout();
    }

    /**
     * Send email to customer from frontend form
     *
     * @return void
     */
    public function emailAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirect('*/*');
            return;
        }

        $data = $this->getRequest()->getParams();

        $storeName = Mage::getStoreConfig('trans_email/ident_general/name');
        $storeEmail = Mage::getStoreConfig('trans_email/ident_general/email');

        $customerEmail = $data['email'];

        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('lcb_faq_template');

        $emailTemplate->setTemplateSubject($this->__('Contact'));

        $emailTemplate->setSenderName($customerEmail);
        $emailTemplate->setSenderEmail($storeEmail);

        $emailTemplateVariables = array();

        $emailTemplateVariables['firstname'] = $data['firstname'];
        $emailTemplateVariables['telephone'] = $data['telephone'];
        $emailTemplateVariables['email'] = $data['email'];
        $emailTemplateVariables['order'] = $data['order'];
        $emailTemplateVariables['comment'] = $data['comment'];

        try {
            $emailTemplate->send($storeEmail, null, $emailTemplateVariables);
            $emailTemplate->send($customerEmail, null, $emailTemplateVariables);
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('faq')->__("Successfully Sent"));
        } catch (Exception $error) {
            Mage::getSingleton('core/session')->addError($error->getMessage());
        }

        $this->_redirect('*/*/');
    }
}
