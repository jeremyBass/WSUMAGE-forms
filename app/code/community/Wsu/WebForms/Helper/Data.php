<?php
class Wsu_WebForms_Helper_Data extends Mage_Core_Helper_Abstract {
	public function getIp() {
		$ip = Mage::helper('core')->isModuleEnabled('Wsu_NetworkSecurities') ? Mage::helper('wsu_networksecurities')->get_ip_address() : $_SERVER['REMOTE_ADDR'];
		return $ip;
	}
	public function captchaAvailable() {
		if (Mage::helper('core')->isModuleEnabled('Wsu_NetworkSecurities')){
			return Mage::helper('wsu_networksecurities')->captchaAvailable(); //class_exists('Zend_Service_ReCaptcha') && Mage::getStoreConfig('webforms/captcha/public_key') && Mage::getStoreConfig('webforms/captcha/private_key')
		}
		return false;
	}
	public function htmlCut($text, $max_length) {
		$tags             = array();
		$result           = "";
		$is_open          = false;
		$grab_open        = false;
		$is_close         = false;
		$in_double_quotes = false;
		$in_single_quotes = false;
		$tag              = "";
		$i                = 0;
		$stripped         = 0;
		$stripped_text    = strip_tags($text);
		while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length) {
			$symbol = $text{$i};
			$result .= $symbol;
			switch ($symbol) {
				case '<':
					$is_open   = true;
					$grab_open = true;
					break;
				case '"':
					if ($in_double_quotes){
						$in_double_quotes = false;
					}else{
						$in_double_quotes = true;
					}
					break;
				case "'":
					if ($in_single_quotes){
						$in_single_quotes = false;
					}else{
						$in_single_quotes = true;
					}
					break;
				case '/':
					if ($is_open && !$in_double_quotes && !$in_single_quotes) {
						$is_close  = true;
						$is_open   = false;
						$grab_open = false;
					}
					break;
				case ' ':
					if ($is_open){
						$grab_open = false;
					}else{
						$stripped++;
					}
					break;
				case '>':
					if ($is_open) {
						$is_open   = false;
						$grab_open = false;
						array_push($tags, $tag);
						$tag = "";
					} else if ($is_close) {
						$is_close = false;
						array_pop($tags);
						$tag = "";
					}
					break;
				default:
					if ($grab_open || $is_close){
						$tag .= $symbol;
					}
					if (!$is_open && !$is_close){
						$stripped++;
					}
			}
			$i++;
		}
		while ($tags) {
			$result .= "</" . array_pop($tags) . ">";
		}
		return $result;
	}
	public function addAssets(Mage_Core_Model_Layout $layout) {
		$head    = $layout->getBlock('head');
		$content = $layout->getBlock('content');
		if ($head && $content) {
			$head->addCss('webforms/form.css');
			$head->addJs('prototype/window.js');
			$head->addItem('js_css', 'prototype/windows/themes/default.css');
			$head->addItem('js_css', 'prototype/windows/themes/alphacube.css');
			// logic
			$head->addJs('webforms/logic.js');
			// stars
			$head->addJs('webforms/stars.js');
			$head->addCss('webforms/stars.css');
			// tooltips
			$head->addJs('webforms/HelpBalloon.js');
			$head->addCss('webforms/helpballoon.css');
			// wysiwyg
			$head->addJs('tiny_mce/tiny_mce.js');
			// calendar
			$head->addJs('calendar/calendar.js');
			$head->addJs('calendar/calendar-setup.js');
			$head->addItem('js_css', 'calendar/calendar-blue.css');
			// ajax file uploader
			if (Mage::getStoreConfig('webforms/files/ajax')) {
				if (Mage::getStoreConfig('webforms/files/load_jquery')) {
					$head->addJs('webforms/jQuery/jquery-1.7.1.min.js');
					$head->addJs('webforms/jQuery/no-conflict.js');
				}
				$head->addJs('webforms/blueimp/js/vendor/jquery.ui.widget.js');
				$head->addJs('webforms/blueimp/js/jquery.iframe-transport.js');
				$head->addJs('webforms/blueimp/js/jquery.fileupload.js');
				$head->addCss('webforms/file-upload.css');
			}
		}
		// add custom assets
		Mage::dispatchEvent('webforms_add_assets', array(
			'layout' => $layout
		));
		return $this;
	}
	public function randomAlphaNum($length = 6) {
		$rangeMin   = pow(36, $length - 1); //smallest number to give length digits in base 36
		$rangeMax   = pow(36, $length) - 1; //largest number to give length digits in base 36
		$base10Rand = @mt_rand($rangeMin, $rangeMax); //get the random number
		if (!$base10Rand){
			$base10Rand = @mt_rand($rangeMax, $rangeMin);
		}
		$newRand = base_convert($base10Rand, 10, 36); //convert it
		return $newRand; //spit it out
	}
	public function getVersion() {
		return (string) Mage::getConfig()->getNode()->modules->Wsu_WebForms->version;
	}
	public function editorConfig(){
		return "function toggleEditor() {
					if (tinyMCE.getInstanceById('page_content') == null) {
						tinyMCE.execCommand('mceAddControl', false, 'content');
					} else {
						tinyMCE.execCommand('mceRemoveControl', false, 'content');
					}
				}";
	}
}