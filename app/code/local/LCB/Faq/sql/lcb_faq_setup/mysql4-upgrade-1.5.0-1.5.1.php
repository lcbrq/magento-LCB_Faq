<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->modifyColumn($installer->getTable('lcb_faq'), 'store_id', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'nullable' => true,
        'default' => null,
        'comment' => 'store_selector',
    ));
$installer->endSetup();
