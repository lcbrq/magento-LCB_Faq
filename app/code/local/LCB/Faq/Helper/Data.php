<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Helper_Data extends Mage_Core_Helper_Abstract {
    
     const XML_PATH_FAQ_VISIBILITY_GROUPS_ENABLED = 'faq/general/visibility_groups';
    
    /**
     * Slugify string
     * @return string
     */
    public function makeSlug($string){
        return Mage::getModel('catalog/product_url')->formatUrlKey($string);
    }
    
    
    /**
     * Add new FAQ category
     
     * @param string $name
     * @param string $url
     * @param int $parentId
     * @return LCB_Faq_Model_Category
     */
    public function addCategory($name, $identifier, $parentId = null)
    {
        $category = Mage::getModel('faq/category');
        $category->setName($name);
        $category->setIdentifier($identifier);
        $category->setParentId($parentId);
        $category->save();
        return $category;
    }

    /**
     * Add new FAQ Q&A set
     * 
     * @param string $question
     * @param string $answer
     * @param int $categoryId
     * @return LCB_Faq_Model_Faq
     */
    public function addQA($question, $answer, $categoryId = null, $storeId = 0)
    {
        $set = Mage::getModel('faq/faq');
        $set->setQuestion($question);
        $set->setAnswer($answer);
        $set->setCategory($categoryId);
        $set->setStoreId($storeId);
        $set->save();
        return $set;
    }
    
    /**
     * Check if visibility groups are enabled
     * 
     * @return boolean
     */
    public function visibilityGroupsEnabled()
    {
        return Mage::getStoreConfig(self::XML_PATH_FAQ_VISIBILITY_GROUPS_ENABLED);
    }
    
}
