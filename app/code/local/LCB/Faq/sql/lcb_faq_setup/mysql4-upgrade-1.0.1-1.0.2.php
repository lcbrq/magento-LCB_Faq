<?php

$installer = $this;
$installer->startSetup();
$sql = <<<SQLTEXT
DROP TABLE IF EXISTS `{$this->getTable('lcb_faq_category')}`;
CREATE TABLE `{$this->getTable('lcb_faq_category')}` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `store_id` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


SQLTEXT;

$installer->run($sql);
$installer->endSetup();
