<?php
class xv_texts_editor {
	var $editor_name ="";
	var $editor_author ="";
	var $editor_version ="";
	var $XVweb;
	
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
	}
	
	public function get_button(){
		return "";
	}
	
	public function get_editor($name, $content){
	
		return "";
	}
}
?>