<?php
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE  `{$this->getTable('customer/customer_group')}` ADD `webform_id` INT( 10 ) NOT NULL DEFAULT '0';
");

$webforms_table = 'webforms';

$installer->run("
ALTER TABLE  `{$webforms_table}` ADD  `crf_account`  tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_position`  int(11) NOT NULL DEFAULT '10';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_frontend`  tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_group_serialized`  text NOT NULL;
");



$installer->run("
ALTER TABLE  `{$this->getTable('customer/customer_group')}` ADD `crf_activation_status` INT( 10 ) NOT NULL DEFAULT '1';
");


$installer->endSetup();