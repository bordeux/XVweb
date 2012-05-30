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
if(!xv_perm("AdminPanel")){ // Brak dostepu
	header("location: ".$URLS['Script'].'Page/System/Permissions/AdminPanel/');
	exit;
}

@set_time_limit(0);
$xv_theme_name  = "default";
DEFINE('ADMIN_ROOT_DIR', ROOT_DIR.'admin'.DIRECTORY_SEPARATOR);

$URLS['ThemeCatalog']	= $URLS['Site'].'admin/data/themes/';
$URLS['JSCatalog']		= $URLS['Site'].'admin/data/themes/';
$URLS['Theme']			= $URLS['ThemeCatalog'].$xv_theme_name."/";
$URLS['JSCatalog']		= $URLS['JSCatalog'].$xv_theme_name."/";


$Smarty->assignByRef('URLS', $URLS);
$Smarty->assignByRef('UserConfig', $XVwebEngine->user_config($XVwebEngine->Session->Session('user_name')));
$Smarty->assign('UrlTheme', $URLS['Theme']);
$Smarty->assign('JSVars', (array('SIDUser'=>$XVwebEngine->Session->get_sid(), 'rootDir'=>$URLS['Site'])	));


try {
	$Smarty->template_dir = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR;
	$CompileDir = ROOT_DIR.'tmp'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR;
	if(!is_dir($CompileDir))
		mkdir($CompileDir);
	$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
	$Smarty->config_dir   = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
	$Smarty->cache_dir    = ROOT_DIR.'admin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
} catch (Exception $e) { 
			$XVwebEngine->ErrorClass($e);
} 
		class xv_admin_error{
				var $style = "height: 100px; width: 200;";
				var $title = "Error";
				var $URL = "Error/";
				var $content = "<div class='error'>Error - page not found</div>";
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
if(strtolower($Command) == "get"){
	$admin_page = basename(strtolower($XVwebEngine->GetFromURL($PathInfo, 3)));
	$admin_page_file_name =  $admin_page .'.php';
	$admin_page_file =  ADMIN_ROOT_DIR.'pages'.DIRECTORY_SEPARATOR.$admin_page.DIRECTORY_SEPARATOR.$admin_page_file_name;

	foreach (glob('{admin/pages/*/'.$admin_page_file_name.',plugins/*/admin/'.$admin_page_file_name.'}', GLOB_BRACE) as $filename) {
		$admin_page_file = $filename;
	}
	
	

if (file_exists($admin_page_file)) 
	require($admin_page_file);
		else{
			$xv_admin_class_name = "xv_admin_error";
		}
	if(!class_exists($xv_admin_class_name))
		$xv_admin_class_name = "xv_admin_error";
	ob_get_clean();
	header("Pragma: no-cache");
	header("Cache-Control: no-cache"); 
	header ("content-type: text/javascript; charset: UTF-8");   
	header ('Vary: Accept-Encoding');
	header("XVwebMSG: Sended");
	exit(json_encode($XVwebEngine->load_class($xv_admin_class_name)));
}else{
include_once(ADMIN_ROOT_DIR.'data/menu/menu.php');

foreach (glob('{admin/data/menu/*.menu.php,plugins/*/admin/menu/*.menu.php}', GLOB_BRACE) as $filename) 
	include_once($filename);
	
$Smarty->assignByRef('admin_menu',   $admin_menu);	

$Smarty->display('index.tpl');
}

?>