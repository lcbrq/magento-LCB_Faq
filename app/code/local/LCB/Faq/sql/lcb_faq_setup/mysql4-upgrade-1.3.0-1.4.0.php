<?php

/**
 * Add possibility to assign more than 1 category to FAQ set
 */
$installer = $this;
$installer->startSetup();

$installer->getConnection()->modifyColumn(
    $installer->getTable('lcb_faq'),
    'category',
    'VARCHAR(64) DEFAULT NULL'
);

$installer->endSetup();
