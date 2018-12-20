<?php
/**
 * Add FAQ set position feature
 */

$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('lcb_faq'), 'position', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'default' => 0,
        'after' => 'category',
        'comment' => 'QA set position'
    ));

$installer->endSetup();
