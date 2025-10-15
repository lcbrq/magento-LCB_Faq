<?php

$table = $installer->getTable('faq/item');
$installer->run("
CREATE TABLE IF NOT EXISTS `{$table}` (
  `item_id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `question`    VARCHAR(255)     NOT NULL,
  `answer`      TEXT             NULL,
  `position`    INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active`   TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`item_id`),
  KEY `IDX_LCBFAQ_CATEGORY` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();