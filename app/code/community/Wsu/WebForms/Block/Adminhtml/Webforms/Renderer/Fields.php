<?php
class Wsu_WebForms_Block_Adminhtml_Webforms_Renderer_Fields extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$value = Mage::getModel('webforms/fields')->getCollection()->addFilter('webform_id', $row->getId())->count();
		return $value;
	}
}