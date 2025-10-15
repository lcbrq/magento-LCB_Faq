<?php
/** @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$group = 'FAQ';

$add = function($code, array $def) use ($installer, $group) {
    $attr = Mage::getSingleton('eav/config')->getAttribute('catalog_category', $code);
    if (!$attr || !$attr->getId()) {
        $def = array_merge(array(
            'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'visible'      => true,
            'required'     => false,
            'user_defined' => true,
            'group'        => $group,
        ), $def);
        $installer->addAttribute('catalog_category', $code, $def);
    }
};

$sort = 50; // kolejność w zakładce FAQ
for ($i=1; $i<=5; $i++) {
    $add('faq_q'.$i, array(
        'type'       => 'varchar',
        'label'      => 'FAQ: pytanie '.$i,
        'input'      => 'text',
        'sort_order' => $sort++,
    ));
    $add('faq_a'.$i, array(
        'type'       => 'text',
        'label'      => 'FAQ: odpowiedź '.$i,
        'input'      => 'textarea',
        'sort_order' => $sort++,
    ));
}

$installer->endSetup();
