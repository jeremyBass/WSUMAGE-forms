<?php


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->dropTable($this->getTable('webforms/webforms'));
$installer->getConnection()->dropTable($this->getTable('webforms/fields'));
$installer->getConnection()->dropTable($this->getTable('webforms/fieldsets'));
$installer->getConnection()->dropTable($this->getTable('webforms/results'));
$installer->getConnection()->dropTable($this->getTable('webforms/results_values'));
$installer->getConnection()->dropTable($this->getTable('webforms/message'));
$installer->getConnection()->dropTable($this->getTable('webforms/quickresponse'));
$installer->getConnection()->dropTable($this->getTable('webforms/store'));
$installer->getConnection()->dropTable($this->getTable('webforms/logic'));

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/webforms')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` VARCHAR( 255 ) NOT NULL,
  `redirect_url` TEXT NOT NULL,
  `description` text NOT NULL,
  `success_text` text NOT NULL,
  `registered_only` tinyint(1) NOT NULL,
  `send_email` tinyint(1) NOT NULL,
  `add_header` tinyint(1) NOT NULL DEFAULT '1',
  `duplicate_email` tinyint(1) NOT NULL,
  `email` VARCHAR( 255 ) NOT NULL,
  `email_reply_to` TEXT NOT NULL,
  `email_template_id` int( 11 ) NOT NULL,
  `email_customer_template_id` int( 11 ) NOT NULL,
  `email_reply_template_id` int( 11 ) NOT NULL DEFAULT '0',
  `email_smtpvalidation` TINYINT( 1 ) NOT NULL,
  `survey` tinyint(1) NOT NULL,
  `approve` TINYINT( 1 ) NOT NULL,
  `captcha_mode` varchar( 40 ) NOT NULL,
  `files_upload_limit` int( 11 ) NOT NULL DEFAULT '0',
  `images_upload_limit` int( 11 ) NOT NULL DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `menu`  tinyint(1) NOT NULL DEFAULT '1',
  `submit_button_text` varchar( 255 ),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/fields')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  `fieldset_id` int(11) NOT NULL,
  `name` TEXT NOT NULL,
  `comment` TEXT NOT NULL,
  `result_label` TEXT NOT NULL,
  `result_display` varchar( 10 ) NOT NULL DEFAULT 'on',
  `code` VARCHAR( 255 ) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` varchar(20) NOT NULL,
  `value` text NOT NULL,
  `email_subject` tinyint(1) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `css_style` varchar(255) NOT NULL,
  `validate_message` text NOT NULL,
  `validate_regex` varchar( 255 ) NOT NULL,
  `validate_length_max` int( 11 ) NOT NULL DEFAULT '0',
  `validate_length_min` int( 11 ) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `hint` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/fieldsets')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  `name` TEXT NOT NULL,
  `result_display` varchar( 10 ) NOT NULL DEFAULT 'on',
  `position` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");


$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/results')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/results_values')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text  NOT NULL,
  `key` varchar( 10 ) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `result_id` (`result_id`,`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/message')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Admin User ID',
  `message` longtext NOT NULL,
  `author` varchar(100) NOT NULL COMMENT 'Author Name',
  `is_customer_emailed` tinyint(4) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/quickresponse')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `message` longtext NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/store')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `entity_type` varchar(10) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `store_data` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `OBJECT` (`store_id`,`entity_type`,`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/logic')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `logic_condition` varchar(20) NOT NULL DEFAULT 'equal',
  `action` varchar(20) NOT NULL DEFAULT 'show',
  `aggregation` varchar(20) NOT NULL DEFAULT 'any',
  `value_serialized` text NOT NULL,
  `target_serialized` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");



$installer->endSetup();
?>