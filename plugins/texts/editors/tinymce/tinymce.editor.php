<?php
class xv_texts_editor_tinymce {
	var $editor_name ="TinyMCE";
	var $editor_author ="Krzysztof Bednarczyk";
	var $editor_version ="1.0";
	var $XVweb;
	
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
	}
	
	public function get_button(){
		global $URLS;
		return "<img src='{$URLS['Site']}/plugins/texts/editors/tinymce/button.png' /><br />{$this->editor_name}";
	}
	
	public function get_editor($content=''){
		global $URLS;
		xv_append_js($URLS['Site'].'plugins/texts/editors/tinymce/jscripts/tiny_mce/jquery.tinymce.js');
		xv_append_js($URLS['Site'].'plugins/texts/editors/tinymce/tinymce.js');
		
		
		return '<textarea name="xv-texts-content"  style="width: 100%; min-height: 500px;" class="tinymce">'.htmlspecialchars($content).'</textarea>';
	}
}
?>