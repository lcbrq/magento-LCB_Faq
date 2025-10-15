<?php

class LCB_Faq_Block_Adminhtml_Item_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $catId = (int)$this->getRequest()->getParam('category_id');
        $m     = Mage::registry('lcb_faq_item');

        $form = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id'          => $this->getRequest()->getParam('id'),
                'category_id' => $catId,
            )),
            'method' => 'post'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fs = $form->addFieldset('base', array('legend' => Mage::helper('adminhtml')->__('Wpis FAQ')));

        $fs->addField('category_id', 'hidden', array('name' => 'category_id','value' => $catId));
        $fs->addField('question', 'text', array('name' => 'question','label' => Mage::helper('adminhtml')->__('Pytanie'),'required' => 1));
        $fs->addField('answer', 'textarea', array('name' => 'answer','label' => Mage::helper('adminhtml')->__('Odpowiedź'),'style' => 'height:200px;'));
        $fs->addField('position', 'text', array('name' => 'position','label' => Mage::helper('adminhtml')->__('Pozycja'),'class' => 'validate-number','value' => 0));
        $fs->addField('is_active', 'select', array('name' => 'is_active','label' => Mage::helper('adminhtml')->__('Włącz'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),'value' => 1));

        if ($m) {
            $form->setValues($m->getData());
        }
        return parent::_prepareForm();
    }
}
