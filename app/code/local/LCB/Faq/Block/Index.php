<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Index extends Mage_Core_Block_Template {

    /**
     * Get questions and answers from current category
     * 
     * @uses module LCB_Faq
     * @return LCB_Faq_Model_Mysql4_Faq_Collection
     */
    public function getQuestionsAndAnswers()
    {
        $categoryId = $this->getRequest()->getParam('id');
        if (!$categoryId) {
            $categoryId = Mage::getModel('faq/category')->getCollection()->getFirstItem()->getId();
        }
        $category = Mage::getModel('faq/category')->load($categoryId);
        return $category->getFaqCollection();
    }

    /**
     * Get FAQ categories filtered by visibility
     * 
     * @return array
     */
    public function getCategories()
    {
        $categories = array();
        foreach (Mage::getModel('faq/category')->getCollection() as $category) {
            if($category->isVisible()){
               $categories[$category->getId()] = $category;
            }
        }
        return $categories;
    }

    /**
     * Get FAQ contact form POST action
     * @author Jigsaw Marcin Gierus <martin@lcbrq.com>
     * @return string 
     */
    public function getFormAction(){
    	return $this->getUrl('faq/index/email');
    }

    /**
     * Get native magento contact form post action
     * @author Jigsaw Marcin Gierus <martin@lcbrq.com>
     * @return string
     */
    public function getContactFormAction(){
        return $this->getUrl('contacts/index/post');
    }

}
