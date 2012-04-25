<?php
$register_config = new register_config();
$Smarty->assign('register_config', $register_config);

if(isset($_POST['xv_register'])){
	include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
	$users_class = new xv_users($XVwebEngine);
	
	if($XVwebEngine->Session->GetSID() != ifsetor($_POST['xv_sid'], "")){
		$Smarty->assign('register_error', true);
		$Smarty->assign('register_error_msg', "invalid_sid");
	}else{
		if($register_config->captcha_protection === false || ($register_config->captcha_protection === true && $_POST['xv_captcha'] == $XVwebEngine->Session->Session('Captcha_code')) ){
			$random_key = uniqid().rand(100, 999);
			
			$password_hash = xvp()->hash_password($users_class, $_POST['xv_register']['password']);
			
			$add_user_result =  xvp()->user_add($users_class, $_POST['xv_register']['nick'], $password_hash, $_POST['xv_register']['email'], $register_config->default_group, $random_key);
			
			if($add_user_result === true){
				
				xvp()->user_send_email($users_class, $_POST['xv_register']['nick'], $register_config->mail_activation_topic, $register_config->mail_activation_message, array(
					"--xv-activate-link--" => $URLS['Script'].'Register/Activate/'.$_POST['xv_register']['nick'].'/'.$random_key.'/'
				));
				
				$Smarty->assign('register_error', false);
				$Smarty->assign('register_success_mgs', $register_config->register_success_message);
				$Smarty->assign('register_success', true);
			}else{
				$Smarty->assign('register_error', true);
				$Smarty->assign('register_error_msg', $add_user_result);
			}
		}else{
				$Smarty->assign('register_error', true);
				$Smarty->assign('register_error_msg', "invalid_captcha");
		}
		
	
	}
	
}

$Smarty->display('register/index.tpl');
?>