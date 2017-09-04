<?php

/**
 * Add FAQ set visibility feature
 */

$installer = $this;
$installer->startSetup();
$installer->getConnection()
        ->addColumn($installer->getTable('lcb_faq'), 'visibility_groups', array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            'nullable' => true,
            'default' => null,
            'after' => 'category',
            'comment' => 'set visibility groups'
        ));

$installer->endSetup();
