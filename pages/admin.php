<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   admin.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
if(!$XVwebEngine->permissions('AdminPanel')){ // Brak dostepu
	header("location: ".$URLS['Script'].'System/AccessDenied/');
	exit;
}
@set_time_limit(0);
$ThemeSelected  = "default";
DEFINE('ADMIN_ROOT_DIR', ROOT_DIR.'admin'.DIRECTORY_SEPARATOR);

$URLS['ThemeCatalog']	= $URLS['Site'].'admin/data/themes/';
$URLS['JSCatalog']		= $URLS['Site'].'admin/data/themes/';
$URLS['Theme']			= $URLS['ThemeCatalog'].$ThemeSelected."/";
$URLS['JSCatalog']		= $URLS['JSCatalog'].$ThemeSelected."/";


$Smarty->assignByRef('URLS', $URLS);
$Smarty->assignByRef('UserConfig', $XVwebEngine->user_config($XVwebEngine->Session->Session('Logged_User')));
$Smarty->assign('UrlTheme', $URLS['Theme']);
$Smarty->assign('JSVars', (array('SIDUser'=>$XVwebEngine->Session->GetSID(), 'rootDir'=>$URLS['Site'],  "UrlScript"=>$URLS['Script'], "JSCatalog"=>$URLS['JSCatalog'])	));


try {
	$Smarty->template_dir = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR;
	$CompileDir = ROOT_DIR.'tmp'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR;
	if(!is_dir($CompileDir))
	mkdir($CompileDir);
	$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
	$Smarty->config_dir   = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
	$Smarty->cache_dir    = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
} catch (Exception $e) { 
			$XVwebEngine->ErrorClass($e);
} 
		class XV_Admin_error{
				var $style = "height: 100px; width: 200;";
				var $title = "Error";
				var $URL = "Error/";
				var $content = "Error - not found module";
				var $id = "error";
				public function __construct(&$XVweb){
					$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/ban.png';
					$this->id = "error-".uniqid();
				}
		}
function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}
//*WLASCIWA
$Command = $XVwebEngine->GetFromURL($PathInfo, 2);
$Prefix = $XVwebEngine->Plugins()->Menager()->AdminPrefix($XVwebEngine->GetFromURL($PathInfo, 2));
if(strtolower($Command) == "get"){
	$admin_page = basename(strtolower($XVwebEngine->GetFromURL($PathInfo, 3)));
	$admin_page_file =  $admin_page .'.php';
	$admin_page_file =  ADMIN_ROOT_DIR.'pages'.DIRECTORY_SEPARATOR.$admin_page.DIRECTORY_SEPARATOR.$admin_page_file;

if (file_exists($admin_page_file)) 
	require($admin_page_file);
		else{
			$XVClassName = "XV_Admin_error";
		}
	if(!class_exists($XVClassName))
		$XVClassName = "XV_Admin_error";
	ob_get_clean();
	header("Pragma: no-cache");
	header("Cache-Control: no-cache"); 
	header ("content-type: text/javascript; charset: UTF-8");   
	header ('Vary: Accept-Encoding');
	header("XVwebMSG: Sended");
	exit(json_encode($XVwebEngine->InitClass($XVClassName)));
}else{
include_once(ADMIN_ROOT_DIR.'data/menu/menu.php');

foreach (glob(ADMIN_ROOT_DIR.'data/menu/*.menu.php') as $filename) 
	include_once($filename);
	
$Smarty->assignByRef('admin_menu',   $admin_menu);	

$Smarty->display('index.tpl');
}

?>