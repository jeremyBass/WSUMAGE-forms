<?php
class Wsu_WebFormsCRF_Block_Adminhtml_Group extends Mage_Adminhtml_Block_Customer_Group_Edit_Form {

	protected function _prepareLayout() {
		parent::_prepareLayout();

		$form = $this->getForm();
		$customerGroup = Mage::registry('current_group');

		$fieldset = $form->addFieldset('webforms', array('legend' => Mage::helper('webforms')->__('Web-forms')));

		$default = array('0' => $this->__('- System default -'));

		$fieldset->addField('webform_id', 'select', array
		(
			'label' => Mage::helper('core')->__('Registration form'),
			'title' => Mage::helper('core')->__('Registration form'),
			'note' => Mage::helper('webformscrf')->__('Use Web-forms: Customer Registration Form widget to register customers from the CMS page'),
			'name' => 'webform_id',
			'required' => false,
			'values' => array_merge($default, Mage::getModel('webforms/webforms')->toOptionArray()),
		));


		if (Mage::getSingleton('adminhtml/session')->getCustomerGroupData()) {
			$form->addValues(Mage::getSingleton('adminhtml/session')->getCustomerGroupData());
			Mage::getSingleton('adminhtml/session')->setCustomerGroupData(null);
		} else {
			$form->addValues($customerGroup->getData());
		}
	}
}
?>
