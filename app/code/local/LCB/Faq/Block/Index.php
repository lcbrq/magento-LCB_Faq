<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Index extends Mage_Core_Block_Template
{
    /**
     * Get questions and answers from current category
     *
     * @uses module LCB_Faq
     * @return LCB_Faq_Model_Mysql4_Faq_Collection
     */
    public function getQuestionsAndAnswers()
    {
        $categoryId = $this->getRequest()->getParam('id', $this->getData('id'));
        if (!$categoryId) {
            $categoryId = Mage::helper('gtx_faq')->getDefaultCategoryId();
        }

        if ($categoryId) {
            $category = Mage::getModel('faq/category')->load($categoryId);
            $collection = $category->getFaqCollection();
        } else {
            $collection = Mage::getModel('faq/faq')->getCollection()->addStoreFilter(Mage::app()->getStore()->getStoreId());
        }

        $collection = Mage::helper('faq')->applyVisibilityFilterToCollection($collection);
        $collection->getSelect()->order('position ASC');
        return $collection;
    }

    /**
     * Get FAQ categories filtered by visibility
     *
     * @return array
     */
    public function getCategories()
    {
        $categories = array();
        $collection = Mage::getModel('faq/category')->getCollection();
        $collection->getSelect()->order('position ASC');
        foreach ($collection as $category) {
            if ($category->getIsActive() && $category->isVisible()) {
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
    public function getFormAction()
    {
        return $this->getUrl('faq/index/email');
    }

    /**
     * Get native magento contact form post action
     * @author Jigsaw Marcin Gierus <martin@lcbrq.com>
     * @return string
     */
    public function getContactFormAction()
    {
        return $this->getUrl('contacts/index/post');
    }
}
