<?php
xv_load_lang("ip_ban");
include_once(dirname(__FILE__).'/libs/ip_ban.class.php');
include_once(dirname(__FILE__).'/config/ip_ban_config.xv_config.php');
$ban_class = new xv_ip_ban($XVwebEngine);
$check_ip = xvp()->check_ip($ban_class, $_SERVER['REMOTE_ADDR']);
$ip_ban_config = new ip_ban_config();

if(empty($check_ip)){
	$XVwebEngine->Session->Session('xv_check_ban', true);
}else{
	global $Smarty;
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