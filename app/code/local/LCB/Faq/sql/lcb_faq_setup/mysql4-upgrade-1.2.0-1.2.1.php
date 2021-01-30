<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()
        ->addColumn(
            $installer->getTable('lcb_faq_category'),
            'is_active',
            array(
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT, 1,
            'length' => 1,
            'default' => 1,
            'comment' => 'Enabled',
        )
        );

$installer->getConnection()
        ->addColumn(
            $installer->getTable('lcb_faq_category'),
            'identifier',
            array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            'length' => 255,
            'nullable' => true,
            'default' => null,
            'comment' => 'optional identifier',
        )
        );

$installer->endSetup();
