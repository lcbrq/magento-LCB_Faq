<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    public const XML_PATH_DEFAULT_FAQ_CATEGORY_ID = 'faq/general/default_category';

    /**
     * @var string
     */
    public const XML_PATH_FAQ_VISIBILITY_GROUPS_ENABLED = 'faq/general/visibility_groups';

    /**
     * Get custom FAQ routes
     * @since 1.5.0
     * @return array
     */
    public function getCustomRoutes()
    {
        return array('faq');
    }

    /**
     * Get default FAQ category id
     *
     * @since 1.5.1
     * @return int
     */
    public function getDefaultCategoryId()
    {
        return (int) Mage::getStoreConfig(self::XML_PATH_DEFAULT_FAQ_CATEGORY_ID);
    }

    /**
     * Slugify string
     * @return string
     */
    public function makeSlug($string)
    {
        return Mage::getModel('catalog/product_url')->formatUrlKey($string);
    }

    /**
     * Add new FAQ category

     * @param  string                 $name
     * @param  string                 $url
     * @param  int                    $parentId
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
     * @param  string            $question
     * @param  string            $answer
     * @param  int               $categoryId
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

    /**
     * Release event for custom visibility hook
     *
     * @param  LCB_Faq_Model_Resource_Faq_Collection $collection
     * @return LCB_Faq_Model_Resource_Faq_Collection
     */
    public function applyVisibilityFilterToCollection($collection)
    {
        $dispatch = new Varien_Object();
        $event = Mage::dispatchEvent('lcb_faq_set_visibility', array(
            'collection' => $collection,
            'dispatch' => $dispatch,
        ));

        if (!$dispatch->getProcessed()) {
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                $collection->addFieldToFilter(
                    array('visibility_groups', 'visibility_groups'),
                    array(
                            array('null' => true),
                            array('finset' => $customerGroupId),
                        )
                );
            } else {
                $collection->addFieldToFilter(
                    array('visibility_groups', 'visibility_groups'),
                    array(
                            array('null' => true),
                            array('finset' => Mage_Customer_Model_Group::NOT_LOGGED_IN_ID),
                        )
                );
            }
        }

        return $collection;
    }
}
