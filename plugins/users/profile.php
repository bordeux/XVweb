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

LoadLang('user');

	if(!$XVwebEngine->ReadUser($UserFromUrl)){
		header("location: ".$URLS['Script'].'System/UserDoesNotExist/');
		exit;
	}
	if(isset($_GET['delete'])){
		if($_GET['SIDCheck'] == $XVwebEngine->Session->GetSID() && $XVwebEngine->ReadUser['ID']!=1)
		$XVwebEngine->DeleteUser()->DeletUserByNick($XVwebEngine->ReadUser['User']);
		header("location: ?");
		exit;
	}
	if(!empty($Command) && strtolower($Command) == "edit"){
		include(dirname(__FILE__).'/edit.php');
		goto end;
	}
	$XVwebEngine->ReadUser['Password'] = "***Secure***";
	$Smarty->assign('ContextEdit',  $ContextEdit);
	$Smarty->assign('Title', $GLOBALS['Language']['User'].': '.htmlspecialchars($UserFromUrl,  ENT_QUOTES));
	$Smarty->assign('SiteTopic', $GLOBALS['Language']['User'].': '.htmlspecialchars($UserFromUrl,  ENT_QUOTES));
	$Smarty->assign('profile', $XVwebEngine->ReadUser);
	
	$Smarty->assign('MiniMap', array(
			array("Url"=>"/Users/", "Name"=>$Language['Users']),
			array("Url"=>"/Users/".urlencode($XVwebEngine->ReadUser['Nick']).'/', "Name"=>$XVwebEngine->ReadUser['Nick']),
		)
	);
	
	include_once(dirname(__FILE__).'/libs/widgets_interface.php');
	
	$widget_class = array();
	$widgets_html = array();
	$widgets_css = array();
	
	
	foreach (glob(dirname(__FILE__).'/modules/widgets/*/*.widgets.users.php') as $widget_file) {
		$widget = substr(basename($widget_file), 0, -18);
		$widget_class_name = "xv_users_modules_".$widget;
			include_once($widget_file);
			if (class_exists($widget_class_name)) {
				$widget_class[$widget] = new $widget_class_name();
			}
	}
	
	$selected_big_widgets = array("xvauctions_comments", "modifications", "files");
	foreach($selected_big_widgets  as $big_widget){
		if(isset($widget_class[$big_widget]) && method_exists($widget_class[$big_widget], 'widget')){
			$widgets_html[] = xvp()->widget($widget_class[$big_widget]);
		}
	}
	
	$Smarty->assignByRef('widgets_html',  $widgets_html);
	$Smarty->assign('users_mode',  "profile");
	$Smarty->display('users/index.tpl');
	
end:
?>