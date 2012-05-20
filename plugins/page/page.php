<?php

xv_trigger("page.start");
xv_set_title("--xv-page-title--");

function xv_set_content($content){
	global $Smarty;
		$Smarty->assign('xv_page_content', $content);
}
xv_set_content("--xv-page-content--");

$xv_page_plugin = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
$xv_page_name = str_replace('.', '', strtolower($XVwebEngine->GetFromURL($PathInfo, 3)));
$xv_plugins_config = new xv_plugins_config();
if(!isset($xv_plugins_config->{$xv_page_plugin}) || empty($xv_page_name)){
	header('Location: '.$URLS['Script'].'Page/System/404/');
	exit();
}
$xv_plugin_info = $xv_plugins_config->{$xv_page_plugin};

$xv_page_location = ROOT_DIR.'plugins/'.$xv_plugin_info['name'].'/page/'.$xv_page_name.'.page.php';

if (!file_exists($xv_page_location)) {
	header('Location: '.$URLS['Script'].'Page/System/404/');
	exit();
}
xv_trigger("page.preload");
include($xv_page_location);
xv_trigger("page.load");

$Smarty->display('page/index.tpl');
xv_trigger("page.end");

?>