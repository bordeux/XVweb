<?php
class xv_texts_editor_markitup {
	var $editor_name ="MarkItUp";
	var $editor_author ="Krzysztof Bednarczyk";
	var $editor_version ="1.0";
	var $XVweb;
	
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
	}
	
	public function get_button(){
		global $URLS;
		return "<img src='{$URLS['Site']}/plugins/texts/editors/markitup/button.png' /><br />{$this->editor_name}";
	}
	
	public function get_editor($content=''){
		global $URLS;
		xv_append_js($URLS['Site'].'plugins/texts/editors/markitup/markitup/jquery.markitup.js');
		xv_append_js($URLS['Site'].'plugins/texts/editors/markitup/markitup/sets/default/set.js');
		xv_append_css($URLS['Site'].'plugins/texts/editors/markitup/markitup/skins/markitup/style.css');
		xv_append_css($URLS['Site'].'plugins/texts/editors/markitup/markitup/sets/default/style.css');
		return '<textarea id="markItUp" name="xv-texts-content" style="width: 100%; min-height: 500px;">'.htmlspecialchars($content).'</textarea>
<script type="text/javascript">
$(function(){
	$("#markItUp").markItUp(mySettings);
});
</script>
';
	}
}
?>