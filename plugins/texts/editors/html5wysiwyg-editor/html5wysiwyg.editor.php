<?php
class xv_texts_editor_html5wysiwyg {
	var $editor_name ="HTML 5 Wysiwyg Editor";
	var $editor_author ="Krzysztof Bednarczyk";
	var $editor_version ="1.0";
	var $XVweb;
	
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
	}
	
	public function get_button(){
		global $URLS;
		return "<img src='{$URLS['Site']}/plugins/texts/editors/html5wysiwyg-editor/button.png' /><br />{$this->editor_name}";
	}
	
	public function get_editor($content=''){
		global $URLS;
		xv_append_js('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');
		xv_append_js($URLS['Site'].'plugins/texts/editors/html5wysiwyg-editor/h5w/h5w.js');
		xv_append_css($URLS['Site'].'plugins/texts/editors/html5wysiwyg-editor/h5w/h5w.css');
		$editor_html = file_get_contents(dirname(__FILE__).'/editor.html');
		$editor_html = str_replace("--xv-val--", htmlspecialchars($content), $editor_html);
		
		return $editor_html;
	}
}
?>