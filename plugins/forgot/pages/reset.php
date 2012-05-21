<?php
xv_load_lang("forgot");
xv_trigger("forgot.reset.start");

$forgot_config = new forgot_config();
$Smarty->assign('forgot_config', $forgot_config);
$Smarty->assign('forgot_result', false);
$forgot_user = ($XVwebEngine->GetFromURL($PathInfo, 3));
$forgot_key = ($XVwebEngine->GetFromURL($PathInfo, 4));

include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
$users_class = new xv_users($XVwebEngine);
	
$user_data =  xvp()->get_user($users_class, $forgot_user);
			
if(empty($user_data)){
	$Smarty->display('forgot/index2.tpl');
	exit;
}

$hashed_password = substr(xvp()->hash_password($users_class, $user_data->Password), 0, 32);
	
if($forgot_key !== $hashed_password){
	$Smarty->display('forgot/index2.tpl');
	exit;
}	
				
$Smarty->assign('forgot_result', true);
$new_password = uniqid();
$new_password_hashed = xvp()->hash_password($users_class, $new_password );


xvp()->user_edit($users_class, $user_data->User, array(
	"Password" => $new_password_hashed
));


xvp()->user_send_email($users_class, $user_data->User , xv_lang("mail_new_password_topic"), xv_lang("mail_new_password_message"), array(
	"--xv-forgot-new-password--" => $new_password
));

$Smarty->display('forgot/index2.tpl');
?>