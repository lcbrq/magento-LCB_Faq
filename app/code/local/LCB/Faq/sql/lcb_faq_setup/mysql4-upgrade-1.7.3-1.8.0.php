<?php

/**
 * @var Mage_Core_Model_Resource_Setup $installer
 */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('faq/catalog_category'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Entity ID')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Category ID')
    ->addColumn('question', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Question')
    ->addColumn('answer', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Answer')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Position')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default'  => '1',
    ), 'Is Active')
    ->addIndex(
        $installer->getIdxName('lcb_faq', array('category_id')),
        array('category_id')
    )
    ->addForeignKey(
        $installer->getFkName('lcb_faq', 'category_id', 'catalog/category', 'entity_id'),
        'category_id',
        $installer->getTable('catalog/category'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Catalog Category FAQ Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
