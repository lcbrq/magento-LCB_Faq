<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()
        ->addColumn($installer->getTable('lcb_faq'), 'store_id', array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT, 63,
            'nullable' => true,
            'default' => null,
            'comment' => 'store_selector'
        ));

$installer->endSetup();
