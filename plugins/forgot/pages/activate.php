<?php
xv_load_lang("forgot");
xv_trigger("forgot.activate.start");

$register_config = new register_config();

$activate_user = ($XVwebEngine->GetFromURL($PathInfo, 3));
$activate_key = ($XVwebEngine->GetFromURL($PathInfo, 4));
$Smarty->assign('register_config', $register_config);
include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
$users_class = new xv_users($XVwebEngine);

$activate_result = xvp()->user_activate($users_class, $activate_user, $activate_key);
if($activate_result && $register_config->mail_activated){
	xvp()->user_send_email($users_class, $activate_user, xv_lang("mail_activated_topic"), xv_lang("mail_activated_message"), array());
}

$Smarty->assign('activate_result', $activate_result);

$Smarty->display('activate/index.tpl');
?>