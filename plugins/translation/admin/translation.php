<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

class xv_admin_translation {
	var $style = "width: 100%; ";
	var $title = "Translation";
	var $URL = "";
	var $contentStyle = "height: 600px;";
	var $id = "xv-translation-main";
	public function __construct(&$XVweb){
	global $URLS, $XVwebEngine;
			$this->icon = $URLS['Site'].'plugins/translation/admin/icons/translation.png';
			$this->URL = "Translation/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$XVweb->add_get_var(array(), true));

			if(strlen(ifsetor($_GET['lang'], '')) == 2){
				if(isset($_GET['file'])){
					include(dirname(__FILE__).'/includes/lang_editor.php');
				}else{
					include(dirname(__FILE__).'/includes/select_file.php');
				}
				exit;
			}else{
				$this->content =  get_include_contents(dirname(__FILE__).'/includes/load.php');
			}
	
	}
}
class xv_admin_translation_save{
	public function __construct(&$XVweb){
			if($XVweb->Session->GetSID() != $_POST['xv-sid']){
				exit("<div class='error'>Error: Wrong SID</div>");
			}
		$update_key = $XVweb->DataBase->prepare("INSERT INTO {Translation} ({Translation:Lang}, {Translation:Key}, {Translation:Val}) VALUES ( :lang, :key, :val) ON DUPLICATE KEY UPDATE {Translation:Val} = :val;");
		$update_key->execute(array(
			":val" => $_POST['val'],
			":key" =>$_POST['key'],
			":lang" => $_POST['lang'],
		));
		exit("<div class='success'>Saved</div>");
	}
}



$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('xv_admin_translation_'.$CommandSecond)) {
	$xv_admin_class_name = 'xv_admin_translation_'.$CommandSecond;
}else{
	$xv_admin_class_name = "xv_admin_translation";
}

?>