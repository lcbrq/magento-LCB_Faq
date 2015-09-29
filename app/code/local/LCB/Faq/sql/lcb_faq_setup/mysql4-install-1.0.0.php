<?php

$installer = $this;
$installer->startSetup();
$sql = <<<SQLTEXT
DROP TABLE IF EXISTS `{$this->getTable('lcb_faq')}`;
CREATE TABLE `{$this->getTable('lcb_faq')}` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `question` varchar(512) NOT NULL,
  `answer` longtext NOT NULL,
  `category` smallint(6),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

SQLTEXT;

$installer->run($sql);
$installer->endSetup();
