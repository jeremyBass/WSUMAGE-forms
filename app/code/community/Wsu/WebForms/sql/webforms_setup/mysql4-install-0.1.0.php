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

$installer->endSetup();
?>