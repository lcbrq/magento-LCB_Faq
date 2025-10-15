<?php
/** @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$group = 'FAQ';

$installer->addAttribute('catalog_category','faq_enabled', array(
    'type'         => 'int',
    'label'        => 'FAQ: włączone',
    'input'        => 'select',
    'source'       => 'eav/entity_attribute_source_boolean',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'      => true,
    'required'     => false,
    'user_defined' => true,
    'group'        => $group,
    'sort_order'   => 10,
));

$installer->addAttribute('catalog_category','faq_title', array(
    'type'         => 'varchar',
    'label'        => 'FAQ: tytuł',
    'input'        => 'text',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'      => true,
    'required'     => false,
    'user_defined' => true,
    'group'        => $group,
    'sort_order'   => 20,
));

$installer->addAttribute('catalog_category','faq_content', array(
    'type'         => 'text',
    'label'        => 'FAQ: treść',
    'input'        => 'textarea',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'      => true,
    'required'     => false,
    'user_defined' => true,
    'group'        => $group,
    'sort_order'   => 30,
));

$installer->endSetup();
