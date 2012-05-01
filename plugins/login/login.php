<?php

xv_trigger("login.start");

xv_load_lang("login");

include_once(dirname(__FILE__).'/config/login_config.xv_config.php');

$login_config = new login_config();
$Smarty->assign('login_config', $login_config);

xv_set_title(xv_lang("login_title"));

if(isset($_POST['xv_login'])){
	include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
	$users_class = new xv_users($XVwebEngine);
	
	if($XVwebEngine->Session->GetSID() != ifsetor($_POST['xv_sid'], "")){
		$Smarty->assign('login_error', true);
		$Smarty->assign('login_error_msg', "invalid_sid");
	}else{
		if($login_config->captcha_protection === false || ($login_config->captcha_protection === true && $_POST['xv_captcha'] == $XVwebEngine->Session->Session('Captcha_code')) ){
			$random_key = uniqid().rand(100, 999);
			$password_hash = xvp()->hash_password($users_class, $_POST['xv_login']['password']);
			$login_user_result =  xvp()->user_login($users_class, $_POST['xv_login']['nick'], $password_hash);
			if($login_user_result === true){
			if(ifsetor($_POST['xv_login']['remember'], '') == "true"){
				$password_hash_2 = xvp()->hash_password($users_class, $password_hash);
				$key = $_SERVER['HTTP_USER_AGENT'].$_SERVER['SERVER_ADMIN'];
				$data_login = json_encode(array(
					"user"=> $_POST['xv_login']['nick'],
					"pass_hash"=>$password_hash_2,
				));
				$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data_login, MCRYPT_MODE_CBC, md5(md5($key))));
				@setcookie('xv_login_remember', $encrypted, time()+$login_config->login_cookie_time, "/");
			}
				$Smarty->assign('Session', $XVwebEngine->Session->Session());
				$Smarty->assign('login_error', false);
				$Smarty->assign('login_success_mgs', $login_config->login_success_message);
				$Smarty->assign('login_success', true);
			}else{
				$Smarty->assign('login_error', true);
				$Smarty->assign('login_error_msg', $login_user_result);
			}
		}else{
				$Smarty->assign('login_error', true);
				$Smarty->assign('login_error_msg', "invalid_captcha");
		}
	}
}



$Smarty->display('login/index.tpl');

?>