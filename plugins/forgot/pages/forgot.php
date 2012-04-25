<?php
$forgot_config = new forgot_config();
$Smarty->assign('forgot_config', $forgot_config);

if(isset($_POST['xv_forgot']) && $forgot_config->forgot_enabled){
	include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
	$users_class = new xv_users($XVwebEngine);
	
	if($XVwebEngine->Session->GetSID() != ifsetor($_POST['xv_sid'], "")){
		$Smarty->assign('forgot_error', true);
		$Smarty->assign('forgot_error_msg', "invalid_sid");
	}else{
		if($forgot_config->captcha_protection === false || ($forgot_config->captcha_protection === true && $_POST['xv_captcha'] == $XVwebEngine->Session->Session('Captcha_code')) ){


			$user_data =  xvp()->get_user($users_class, $_POST['xv_forgot']['nick']);
			
			if(!empty($user_data)){
				$hashed_password = substr(xvp()->hash_password($users_class, $user_data->Password), 0, 32);
				
				xvp()->user_send_email($users_class, $user_data->User , $forgot_config->mail_reset_topic, $forgot_config->mail_reset_message, array(
					"--xv-forgot-link--" => $URLS['Script'].'Forgot/Reset/'.$user_data->User.'/'.$hashed_password.'/'
				));
				
				$Smarty->assign('forgot_error', false);
				$Smarty->assign('forgot_success_mgs', $forgot_config->forgot_success_message);
				$Smarty->assign('forgot_success', true);
			}else{
				$Smarty->assign('forgot_error', true);
				$Smarty->assign('forgot_error_msg', "invalid_username");
			}
		}else{
				$Smarty->assign('forgot_error', true);
				$Smarty->assign('forgot_error_msg', "invalid_captcha");
		}
		
	
	}
	
}


$Smarty->display('forgot/index.tpl');
?>