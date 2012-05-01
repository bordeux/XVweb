<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
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
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}
xv_trigger("users.profile.edit.start");

	$Smarty->assign('ContextEdit',  $ContextEdit);
	$Smarty->assign('Title', $GLOBALS['Language']['User'].': '.htmlspecialchars($user_data->User,  ENT_QUOTES));
	$Smarty->assign('SiteTopic', $GLOBALS['Language']['User'].': '.htmlspecialchars($user_data->User,  ENT_QUOTES));
	$Smarty->assign('profile', $user_data);
	
	$Smarty->assign('MiniMap', array(
			array("Url"=>"/Users/", "Name"=>$Language['Users']),
			array("Url"=>"/Users/".urlencode($user_data->User).'/', "Name"=>$user_data->User),
			array("Url"=>"/Users/".urlencode($user_data->User).'/Edit/', "Name"=>"Edit"),
		)
	);
	
	include_once(dirname(__FILE__).'/libs/fields_interface.php');
	
	$field_class = array();
	$fields_html = array();
	$fields_css = array();
	
	
	foreach (glob(dirname(__FILE__).'/modules/fields/*/*.fields.users.php') as $field_file) {
	
		$field = substr(basename($field_file), 0, -17);
		$field_class_name = "xv_users_fields_".$field;
			include_once($field_file);
			if (class_exists($field_class_name)) {
				$field_class[$field] = new $field_class_name();
			}
	}
	
	$selected_big_fields = array("password", "email", "avatar");
	foreach($selected_big_fields  as $big_field){
		if(isset($field_class[$big_field]) && method_exists($field_class[$big_field], 'field')){
			$fields_html[] = xvp()->field($field_class[$big_field]);
		}
	}
	
	$Smarty->assignByRef('fields_html',  $fields_html);
	$Smarty->assign('users_mode',  "edit");
	$Smarty->display('users/index.tpl');
?>