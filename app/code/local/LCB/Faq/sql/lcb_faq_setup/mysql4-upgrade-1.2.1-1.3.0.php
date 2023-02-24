<?php

/**
 * Add FAQ category visibility feature
 */
$installer = $this;
$installer->startSetup();
$installer->getConnection()
        ->addColumn($installer->getTable('lcb_faq_category'), 'visibility_groups', array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            'nullable' => true,
            'default' => null,
            'after' => 'is_active',
            'comment' => 'faq category visibility groups',
        ));

$installer->endSetup();
