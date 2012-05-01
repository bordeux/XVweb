<?php
{
global $XVwebEngine;
$decrypt_password = $_SERVER['HTTP_USER_AGENT'].$_SERVER['SERVER_ADMIN'];
$decrypted_data = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($decrypt_password), base64_decode($_COOKIE['xv_login_remember']), MCRYPT_MODE_CBC, md5(md5($decrypt_password))), "\0");
$login_data = json_decode($decrypted_data);
$remove_cookie = true;

if(!empty($login_data)){
	include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
	$users_class = new xv_users($XVwebEngine);
	$user_data = xvp()->get_user($users_class, $login_data->user);
	if(!empty($user_data)){
		$password_hash_2 = xvp()->hash_password($users_class, $user_data->Password);
		if($password_hash_2 === $login_data->pass_hash){
			xvp()->user_login($users_class, $login_data->user, '', false)	;
			$remove_cookie = false;
		}
	}
}
if($remove_cookie){
	@setcookie('xv_login_remember', null, -1, "/");
}
unset($login_data, $remove_cookie, $decrypted_data, $decrypt_password, $password_hash_2, $user_data);
}
?>