<?php
class xv_texts_editor_ckeditor {
	var $editor_name ="CKEditor";
	var $editor_author ="Krzysztof Bednarczyk";
	var $editor_version ="1.0";
	var $XVweb;
	
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
	}
	
	public function get_button(){
		global $URLS;
		return "<img src='{$URLS['Site']}/plugins/texts/editors/ckeditor/button.png' /><br />{$this->editor_name}";
	}
	
	public function get_editor($content=''){
		global $URLS;
			include_once(dirname(__FILE__).'/ckeditor_php5.php' ) ;
			$CKEditor = new CKEditor();
			$CKEditor->returnOutput = true;
			$CKEditor->basePath = $URLS['Site'].'plugins/texts/editors/ckeditor/';
			return $CKEditor->editor("xv-texts-content", $content);
	}
}
?>