<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Search extends Mage_Core_Block_Template
{
    /**
     * Get questions and answers from search
     *
     * @uses module LCB_Faq
     * @return LCB_Faq_Model_Resource_Faq_Collection
     */
    public function getQuestionsAndAnswers()
    {
        $searchTerm = $this->getRequest()->getParam('q');

        $collection = Mage::getModel('faq/faq')->getCollection()->addFieldToFilter(
            array('question', 'answer'),
            array(
                array('like' => '%' . $searchTerm . '%'),
                array('like' => '%' . $searchTerm . '%')
        )
        );

        $collection = Mage::helper('faq')->applyVisibilityFilterToCollection($collection);
        $collection->getSelect()->order('position ASC');

        return $collection;
    }
}
