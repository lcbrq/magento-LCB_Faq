<?php

class LCB_Faq_Block_Adminhtml_Catalog_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $categoryId = (int) $this->getRequest()->getParam('category_id');
        $faq = Mage::registry('lcb_catalog_category_faq');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id'),
                'category_id' => $categoryId,
            )),
            'method' => 'post'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('base', array(
            'legend' => Mage::helper('faq')->__('FAQ')
        ));

        $fieldset->addField('category_id', 'hidden', array(
            'name' => 'category_id',
            'value' => $categoryId,
        ));

        $fieldset->addField('question', 'text', array(
            'name' => 'question',
            'label' => Mage::helper('faq')->__('Question'),
            'required' => true,
        ));

        $fieldset->addField('answer', 'textarea', array(
            'name' => 'answer',
            'label' => Mage::helper('faq')->__('Answer'),
            'style' => 'height:200px;',
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('faq')->__('Position'),
            'class' => 'validate-number',
            'value' => 0,
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('faq')->__('Włącz'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            'value' => 1,
        ));

        if ($faq) {
            $form->setValues($faq->getData());
        }

        return parent::_prepareForm();
    }

}
