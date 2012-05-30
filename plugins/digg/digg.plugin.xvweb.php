<?php
extract($GLOBALS);
$CacheNode = 600;
if($CacheNode->length){
	$CacheNode->item(0)->nodeValue = 0;
}else{
	$XVwebEngine->Config("config")->find('config cachelimit')->append("<articleparse>0</articleparse>");
}
$Digg = array();
$Digg['Theme'] = $URLS['Site'].'plugins/digg/theme/';
function isValidURL($url){
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
$Digg['Link'] = trim(pq($element)->html());
$Digg['Host'] = parse_url($Digg['Link'], PHP_URL_HOST);
$Comments = $Smarty->getTemplateVars('Comments');
if(is_array($Comments))
$Digg['Comments'] = count($Comments); else
$Digg['Comments'] = 0; 
if(!isValidURL(pq($element)->html()) && !isset($_GET['digg'])){
	header('Location: ?digg=comments');
	exit;
}

if(empty($_GET) or isset($_GET['frame'])){
	if(!file_exists(ROOT_DIR.'themes/'.$xv_theme_name."/digg.tpl")) {	
		$Smarty->template_dir = ROOT_DIR.'plugins/digg/theme/';
		$CompileDir = ROOT_DIR.'tmp'.DIRECTORY_SEPARATOR.'DiggPlugin'.DIRECTORY_SEPARATOR;
		if(!is_dir($CompileDir))
		mkdir($CompileDir);
		$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
		$Smarty->config_dir   = $Smarty->template_dir.'configs'.DIRECTORY_SEPARATOR;
		$Smarty->cache_dir    = $Smarty->template_dir.'cache'.DIRECTORY_SEPARATOR;
	}
	$Smarty->assign('Digg', $Digg);
	$Smarty->display('digg.tpl');
	exit;
}else{
	pq($element)->replaceWith("<h1 style='text-align:center; '><a href='?frame=true'>Wejdź</a></h1>");
}
?>