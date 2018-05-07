<?php

/**
 * Add FAQ set category position feature
 */

$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('lcb_faq_category'), 'position', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'default' => null,
        'after' => 'is_active',
        'comment' => 'set category position'
    ));

$installer->endSetup();
