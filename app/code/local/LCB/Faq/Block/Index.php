<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Index extends Mage_Core_Block_Template {

    public function getCategories()
    {
        $categories = array();
        foreach (Mage::getModel('faq/category')->getCollection() as $category) {
            $categories[$category->getId()] = $category;
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
