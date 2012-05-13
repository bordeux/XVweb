<?php
xv_load_lang("ip_ban");
include_once(dirname(__FILE__).'/libs/ip_ban.class.php');
include_once(dirname(__FILE__).'/config/ip_ban_config.xv_config.php');
$ban_class = new xv_ip_ban($XVwebEngine);
$check_ip = xvp()->check_ip($ban_class, $_SERVER['REMOTE_ADDR']);
$ip_ban_config = new ip_ban_config();

if(empty($check_ip) || xv_perm("AdminPanel")){
	$XVwebEngine->Session->Session('xv_check_ban', true);
}else{
	global $Smarty;
	if(isset($_POST['ip_ban_login']) && isset($_POST['login'])){
	sleep(rand(10, 18));
		if($XVwebEngine->Session->GetSID() === ifsetor($_POST['xv_sid'], "")){
			include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
			$users_class = new xv_users($XVwebEngine);
			$password_hash = xvp()->hash_password($users_class, $_POST['password']);
			$user_data = xvp()->get_user($users_class, $_POST['login']);
			if(!empty($user_data)){
				if($user_data->Password === $password_hash){
					$user_group =  xvp()->group_get_permissions($users_class,$user_data->Group);
					foreach($user_group as $perm){
						if($perm == "AdminPanel"){
								$XVwebEngine->Session->Session('xv_check_ban', true);
								header( 'location: ?' );
								exit;
						}
					}
				}
			}
		}
	}
		$Smarty->template_dir = dirname(__FILE__).'/theme/';
		$CompileDir = getcwd().DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'ip_ban'.DIRECTORY_SEPARATOR;
		if(!is_dir($CompileDir))
			mkdir($CompileDir);
		$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
		$Smarty->config_dir   = dirname(__FILE__).'/theme/config/';
		$Smarty->cache_dir    = dirname(__FILE__).'/theme/cache/';
		$Smarty->assign('check_ip', $check_ip);
		$Smarty->assign('ip_ban_config', $ip_ban_config);
		$Smarty->display('index.tpl');
		exit;
}

?>