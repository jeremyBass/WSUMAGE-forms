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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/fields')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/fieldsets')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");


$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/results')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('webforms/results_values')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `result_id` (`result_id`,`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");


$installer->endSetup();
?>