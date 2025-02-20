<?php

/**
 * Easy FAQ management
 *
 * @category   LCB
 * @package    LCB_Faq
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("faq_form", array("legend" => Mage::helper("faq")->__("Item information")));

        $fieldset->addField("question", "text", array(
            "label" => Mage::helper("faq")->__("Question"),
            "name" => "question",
            "style" => "width: 600px",
        ));

        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
                array(
                        'add_widgets' => false,
                        'add_variables' => false,
                        'add_images' => true,
                )
            );
            $fieldset->addField("answer", "editor", array(
                "label" => Mage::helper("faq")->__("Answer"),
                "name" => "answer",
                "wysiwyg" => true,
                "config" => $wysiwygConfig,
                "style" => "width: 600px",
            ));
        } else {
            $fieldset->addField("answer", "textarea", array(
                "label" => Mage::helper("faq")->__("Answer"),
                "name" => "answer",
                "style" => "width: 600px",
            ));
        }

        $values = [];
        $categories = Mage::getModel('faq/category')->getCollection();
        foreach ($categories as $category) {
            $values[] = array('value' => $category->getId(), 'label' => $category->getId() .  '-' . $category->getName());
        }

        $fieldset->addField('category', 'multiselect', array(
            'label' => Mage::helper('faq')->__('Category'),
            'values' => $values,
            'name' => 'category',
        ));

        $fieldset->addField("url_key", "text", array(
            "label" => Mage::helper("faq")->__("URL Key"),
            "name" => "url_key",
            "class" => 'validate-identifier',
        ));

        $fieldset->addField("position", "text", array(
            "label" => Mage::helper("faq")->__("Position"),
            "name" => "position",
            "class" => 'validate-number',
        ));

        if (Mage::helper('faq')->visibilityGroupsEnabled()) {
            $fieldset->addField("visibility_groups", "multiselect", array(
                'label' => Mage::helper("faq")->__("Visibility"),
                'name' => 'visibility_groups',
                'values' => Mage::getSingleton('faq/system_config_groups')->toOptionArray(),
                'required' => true,
           ));
        }

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
