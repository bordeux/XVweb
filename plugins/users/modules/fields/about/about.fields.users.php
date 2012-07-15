<?php
class xv_users_fields_about extends xv_users_fields {
	var $plg_author = "Krzysztof Bednarczyk";
	var $plg_title = "About";
	var $plg_webiste = "http://bordeux.net/";
	var $plg_description = "About me";
	
	public function field(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data, $user_class;
		
		if($user_data->User != $XVwebEngine->Session->Session('user_name') && !xv_perm("AdminPanel"))
			return '';
			
			
		xv_append_header("
		<style type='text/css' media='all'>
			.xv-user-about-content {
				margin-top: 10px;
				padding: 10px;
				background: #F2F7FA;
				border: 1px solid #AED0EA;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
				
			}
			.xv-user-about-content .form-row label {
				float:left;
				width: 150px;
			}

		</style>");
		if(isset($_GET['xv_about_save']) && isset($_POST['xv_about_text'])){
		include_once(ROOT_DIR.'plugins/texts/libs/htmlpurifier/HTMLPurifier.auto.php');
		include(ROOT_DIR.'plugins/texts/htmlpurifier_configs/default/default.config.php');
		$xv_text_hp = new HTMLPurifier($xv_texts_hp_config);
		$xv_about = $xv_text_hp->purify($_POST['xv_about_text']);
			xvp()->set_user_about($user_class, $user_data->User, $xv_about);
		}
		$xv_user_about = xvp()->get_user_about($user_class, $user_data->User);
		xv_append_js($URLS['Site'].'plugins/texts/editors/tinymce/jscripts/tiny_mce/jquery.tinymce.js');
		xv_append_js($URLS['Site'].'plugins/texts/editors/tinymce/tinymce.js');
		$result = '';
		$result .=
		'<div class="xv-user-about" id="xvauction-user-data">
		<div class="xv-user-seperate"><span> '.xv_lang("about_me").' </span></div>
		<div class="xv-user-about-content">
			<form action="?xv_about_save=true" method="post">
			<textarea name="xv_about_text"  style="width: 100%; min-height: 500px;" class="tinymce">'.htmlspecialchars($xv_user_about).'</textarea>
				<input type="submit" value="Save" />
			</form>
		</div>
			<div style="clear: both;" ></div>
		</div>';
		return $result;
	}
}