<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()
        ->addColumn($installer->getTable('lcb_faq_category'), 'parent_id', array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER, 6,
            'nullable' => true,
            'default' => null,
            'comment' => 'id of parent category',
        ));

$installer->endSetup();
