<?php
class Wsu_WebForms_Block_Adminhtml_Webforms extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_controller     = 'adminhtml_webforms';
		$this->_blockGroup     = 'webforms';
		$this->_headerText     = Mage::helper('webforms')->__('Manage Forms');
		$this->_addButtonLabel = Mage::helper('webforms')->__('Add New Form');
		parent::__construct();
	}
}