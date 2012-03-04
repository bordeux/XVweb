<?php
extract($GLOBALS);
$CacheNode = $XVwebEngine->Config("config")->find('config cachelimit articleparse');
if($CacheNode->length){
	$CacheNode->text(0);
}else{
	$XVwebEngine->Config("config")->find('config cachelimit')->append("<articleparse>0</articleparse>");
}
$MegaVideo = array();
$MegaVideo['Theme'] = $URLS['Site'].'plugins/megavideo/theme/';
function isValidURL($url){
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
parse_str(parse_url(trim(pq($element)->html()),  PHP_URL_QUERY), $output);

$MegaVideo['Link'] = 'http://www.megavideo.com/?v='.$output['v'];//trim(pq($element)->html());
$MegaVideo['ID'] = $output['v'];//trim(pq($element)->html());
$MegaVideo['Megavideo'] = trim(pq($element)->html());//trim(pq($element)->html());
$MegaVideo['Thumbnail'] = $this->text['#MegaVideoTable img:first']->attr("src");
$MegaVideo['Host'] = parse_url($MegaVideo['Link'], PHP_URL_HOST);
$MegaVideo['Description'] = $this->text["#MegaVideoTable tr td[style]"]->html();
$Comments = $Smarty->getTemplateVars('Comments');
if(is_array($Comments))
$MegaVideo['Comments'] = count($Comments); else
$MegaVideo['Comments'] = 0; 
if(!isValidURL(pq($element)->html()) && !isset($_GET['video'])){
	header('Location: ?video=comments');
	exit;
}

if(empty($_GET) or isset($_GET['frame'])){
	if(!file_exists($RootDir.'themes/'.$ThemeSelected."/video.tpl")) {	
		$Smarty->template_dir = $RootDir.'plugins/megavideo/theme/';
		$CompileDir = $RootDir.'tmp'.DIRECTORY_SEPARATOR.'videoPlugin'.DIRECTORY_SEPARATOR;
		if(!is_dir($CompileDir))
		mkdir($CompileDir);
		$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
		$Smarty->config_dir   = $Smarty->template_dir.'configs'.DIRECTORY_SEPARATOR;
		$Smarty->cache_dir    = $Smarty->template_dir.'cache'.DIRECTORY_SEPARATOR;
	}
	$Smarty->assign('Video', $MegaVideo);
	$Smarty->display('video.tpl');
	exit;
}else{
	pq($element)->replaceWith("<h1 style='text-align:center; '><a href='?frame=true'>Wejdź</a></h1>");
}
?>