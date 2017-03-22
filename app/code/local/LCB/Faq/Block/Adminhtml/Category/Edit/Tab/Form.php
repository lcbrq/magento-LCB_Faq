<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Prepare values for parent category selection
     * @author Jigsaw Marcin Gierus <martin@lcbrq.com>
     * @return array
     */
    protected function getValues(){

        $result = array(
            "NULL"=>' '
            );
        $collection = Mage::getModel("faq/category")->getCollection();
        foreach ($collection as $category) {
            $result[$category->getId()] = $category->getName();
        }

        return $result;
    }

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("faq_form", array("legend" => Mage::helper("faq")->__("Category information")));


        $fieldset->addField("name", "text", array(
            "label" => Mage::helper("faq")->__("Name"),
            "name" => "name",
        ));

        $fieldset->addField("parent_id", "select", array(
            "label" => Mage::helper("faq")->__("Parent Category"),
            "name" => "parent_id",
            "options"=>$this->getValues(),
            "required"=>false,
            "after_element_html"=>$this->__('Please select parent category if needed')
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('faq')->__('Store View'),
                'title' => Mage::helper('faq')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId(),
            ));
        }

        if (Mage::getSingleton("adminhtml/session")->getFaqData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getFaqData());
            Mage::getSingleton("adminhtml/session")->setFaqData(null);
        } elseif (Mage::registry("faq_data")) {
            $form->setValues(Mage::registry("faq_data")->getData());
        }
        return parent::_prepareForm();
    }

}
