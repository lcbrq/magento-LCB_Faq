<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_category";
        $this->_blockGroup = "faq";
        $this->_headerText = Mage::helper("faq")->__("Faq Category Manager");
        $this->_addButtonLabel = Mage::helper("faq")->__("Add New Category");
        parent::__construct();
    }
}
