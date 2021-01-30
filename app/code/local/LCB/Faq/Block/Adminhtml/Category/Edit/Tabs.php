<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("faq_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(Mage::helper("faq")->__("Category Information"));
    }

    protected function _beforeToHtml()
    {
        $this->addTab("form_section", array(
            "label" => Mage::helper("faq")->__("Category Information"),
            "title" => Mage::helper("faq")->__("Category Information"),
            "content" => $this->getLayout()->createBlock("faq/adminhtml_category_edit_tab_form")->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}
