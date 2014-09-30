<?php
$installer = $this;

$installer->startSetup();

$webforms_table = $this->getTable('webforms/webforms');

$installer->run("
ALTER TABLE  `{$webforms_table}` ADD  `crf_account`  tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_position`  int(11) NOT NULL DEFAULT '10';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_frontend`  tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE  `{$webforms_table}` ADD  `crf_account_group_serialized`  text NOT NULL;
");

$customerGroup_table = $this->getTable('customer/customer_group');
$installer->run("
ALTER TABLE `{$customerGroup_table}` ADD `webform_id` INT( 10 ) NOT NULL DEFAULT '0';
");
$installer->run("
ALTER TABLE `{$customerGroup_table}` ADD `crf_activation_status` INT( 10 ) NOT NULL DEFAULT '1';
");


$installer->endSetup();