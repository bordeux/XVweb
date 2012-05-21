<?php

xv_trigger("login.logout.start");

xv_load_lang("login");
include_once(dirname(__FILE__).'/config/login_config.xv_config.php');

$login_config = new login_config();
$Smarty->assign('login_config', $login_config);
xv_set_title(xv_lang("logout_title"));



$logout_sid = ($XVwebEngine->GetFromURL($PathInfo, 2));
$Smarty->assign('logout_success', false);

if($logout_sid === $XVwebEngine->Session->get_sid()){
	foreach ($_COOKIE as $c_id => $c_value){
		@setcookie($c_id, 'delete', time()-10000, "/");
	}
	$XVwebEngine->Session->Clear();
	$Smarty->assign('logout_success', true);
}


$Smarty->display('login/index2.tpl');

?>