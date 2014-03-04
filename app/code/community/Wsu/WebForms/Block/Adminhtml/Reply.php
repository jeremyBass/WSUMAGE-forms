<?php
class Wsu_WebForms_Block_Adminhtml_Reply extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct() {
		$this->_controller = 'adminhtml_reply';
		$this->_blockGroup = 'webforms';
		$this->_headerText = $this->__('Selected Result(s)');
		parent::__construct();
		$this->_removeButton('delete');
		$this->_updateButton('save', 'label', $this->__('Save Reply'));
		$Ids = $this->getRequest()->getParam('id');
		if (!is_array($Ids)) {
			$Ids = array(
				$Ids
			);
		}
		if (count($Ids) == 1)
			$this->_addButton('edit', array(
				'label' => Mage::helper('webforms')->__('Edit Result'),
				'onclick' => 'setLocation(\'' . $this->getUrl('*/*/edit', array(
					'id' => $Ids[0]
				)) . '\')'
			));
		$this->addButton('reply', array(
			'label' => $this->__('Save Reply And E-mail'),
			'class' => 'save',
			'onclick' => 'saveAndEmail()'
		), -100);
		$this->_formScripts[] = "
			function saveAndEmail(){
				$('email').value = true;
				editForm.submit();
			}
		";
	}
	public function getBackUrl() {
		return $this->getUrl('*/*/', array(
			'webform_id' => $this->getRequest()->getParam('webform_id')
		));
	}
	protected function _prepareLayout() {
		parent::_prepareLayout();
		// add scripts
		$js = $this->getLayout()->createBlock('core/template', 'reply_js', array(
			'template' => 'webforms/reply/js.phtml'
		));
		$this->getLayout()->getBlock('content')->append($js);
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			$this->_formScripts[] = Mage::helper('webforms')->editorConfig();
		}
	}
}