<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
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

class XV_Admin_system_config {
	var $style = "width: 80%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "";
	var $content = "";
	var $id = "";
	var $title = "";
	var $Date;
	public function __construct(&$XVweb){
		global $PathInfo, $URLS;
		$config_name = ($XVweb->GetFromURL($PathInfo, 5));
		$this->title = "Config editor: ".$config_name;
		$this->content = '';
		$this->URL = "System/Config/".$config_name.'/';
		$this->id = "xva-system-config-".$config_name;
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/xvauctions/icons/auction.png';
		$plugins_config = new xv_plugins_config();
		$plugins_list = array();
		foreach($plugins_config->get_all() as $val)
				$plugins_list[] = $val["name"];
			$file_to_include = null;
		foreach (glob((ROOT_DIR.'plugins/{'.implode(",", $plugins_list).'}/config/'.$config_name.'.config.php'),GLOB_BRACE) as $filename) {
			$file_to_include = $filename;
		}
		if(is_null($file_to_include)){
			$this->content = "<div class='error'>File ".$config_name.'.config.php'." not found</div>";
			return true;
		}
		include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'xv_config'.DIRECTORY_SEPARATOR.'editor.xv_config.class.php');
		include_once($file_to_include);

		$config->set_csrf($XVweb->Session->GetSID());
		$config->set_url($URLS['Script'].'Administration/get/System/Config/'.$config_name.'/');
		$config->set_form_attr(" data-xv-result='.content ' ");
		$config->add_form_class("xv-form");
		if($config->data_sent())
			$config->save($_POST);
			
		$config->generate();
		$form_show = $config;
		$headers = $config->get_headers_html();
		
		$this->content .= '
<style type="text/css" media="all">
.xv-config-form {

width: 800px;
margin: auto;
padding: 40px;
border-radius: 10px;

}
.xv-config-item {
background: rgba(71, 255, 255, 0.4);
padding: 10px;
margin-bottom: 10px;
border-radius: 10px;
}
.xv-config-error {
background: red;
}
.xv-config-caption {
float: left;
width: 180px;
background : #19D900;
padding: 10px;
margin-right: 20px;
border-radius: 10px;
}
.xv-config-desc {
background: #90FCF2;
margin-left: 220px;
padding: 8px;
border-radius: 10px;
margin-top: 10px;
}
.xv-config-submit {
width: 200px;
padding: 20px;
margin:0;
line-height: 20px;
margin: auto;
}
.xv-config-submit input {
width: 200px;
height: 40px;
line-height: 40px;
font-size: 30px;
border: 1px solid #17B509;
}
</style>
';
		$this->content .= $headers;
		$this->content .= $form_show;
		
		if($config->data_sent())
			exit($this->content);
	}
	
}

?>