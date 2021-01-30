<?php
/**
 * Add FAQ QA url feature
 */
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('lcb_faq'), 'url_key', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'nullable' => true,
        'after' => 'answer',
        'comment' => 'URL key',
    ));

$installer->endSetup();
