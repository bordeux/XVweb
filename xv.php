<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   xv.php            *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
	Klasa XVweb jest na licencji GNU v3.(GNU General Public License)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
@header('Content-Type: text/html; charset=utf-8');
// Load Counter //
function microtime_float(){list($usec, $sec) = explode(" ", microtime()); return ((float)$usec + (float)$sec);}
$XVwebStart = microtime_float();
//! Load Counter //
// Disable mafic quotes //
if (get_magic_quotes_gpc()) {
	function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);}
	$gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	array_walk_recursive($gpc, 'magicQuotes_awStripslashes');
}

// DEFINED
DEFINE('SMARTY_DIR', getcwd().DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'smarty3'.DIRECTORY_SEPARATOR);
DEFINE('Cache_dir', getcwd().DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR);
DEFINE('ROOT_DIR', getcwd().DIRECTORY_SEPARATOR);
DEFINE('XV_CONFIG_DIR', getcwd().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);

include_once(ROOT_DIR.'core/libraries/plugins_api.xv.php');

if (!file_exists(ROOT_DIR.'config/db_config.config')){
	header('Location: install/');
	exit();
}
include_once(getcwd().DIRECTORY_SEPARATOR.'config.php');

function xv_caught_errors() {
	global $XVwebEngine;
	$ignore_errors = array(8, 2, 2048);
	if(is_null($e = error_get_last()) === false && !in_array($e['type'], $ignore_errors))
	$XVwebEngine->Log("system.error", array("informations"=>$e, "_SERVER"=>$_SERVER));
}
register_shutdown_function('xv_caught_errors');


require_once(SMARTY_DIR . 'Smarty.class.php');
require_once('core'.DIRECTORY_SEPARATOR.'XVWeb.class.php');
include_once('core'.DIRECTORY_SEPARATOR.'libraries/plugins.class.php');
$xv_plugins = new xv_plugins(ROOT_DIR.'plugins'.DIRECTORY_SEPARATOR);
function xvp(){global $xv_plugins; return $xv_plugins;}
class main_config extends xv_config {};
$xv_main_config = new main_config();
function xv_main_config(){global $xv_main_config; return $xv_main_config;}

$XVwebEngine = new XVWeb(getcwd().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);
xvp()->connect_db($XVwebEngine);

/**Config File**/

xvp()->PreWork($XVwebEngine);
xvp()->Plugins($XVwebEngine)->set("DirPlugins", (getcwd().DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR));
xv_trigger("xvweb.start");


/**************************THEME*******************/
$xv_theme_name = xv_main_config()->theme;

xv_trigger("xvweb.pre_set_urls");

$URLS['Catalog'] = parse_url(substr(substr($_SERVER['PHP_SELF'], 0,  stripos($_SERVER['PHP_SELF'], basename(__FILE__))), 1),  PHP_URL_PATH); 
if(empty($URLS['Site'])) 			$URLS['Site']			= 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST']."/".$URLS['Catalog'];
if(empty($URLS['Path']))	        $URLS['Path']	        = (isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : $_SERVER['PATH_INFO']);
if(empty($URLS['ThemeCatalog']))	$URLS['ThemeCatalog']	= $URLS['Site'].'themes/';
if(empty($URLS['JSCatalog']))		$URLS['JSCatalog']		= $URLS['Site'].'themes/';
if(empty($URLS['Script']))			$URLS['Script']			= $URLS['Site'].(xv_main_config()->mod_rewrite ? '' :"xv.php/");
if(empty($URLS['Theme']))			$URLS['Theme']			= $URLS['ThemeCatalog'].$xv_theme_name."/";
if(empty($URLS['Avats']))			$URLS['Avats']			= $URLS['Site'].'plugins/users/modules/fields/avatar/f/'; //wtf bug?! avats?!
if(empty($UploadDir))		       	$UploadDir		        = getcwd().DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
if(empty($URLS['Path']))			$URLS['Path'] 			= xv_main_config()->index_page; //index page
$URLS['PathInfo']					= $XVwebEngine->add_path_slashes($URLS['Path']);
$URLS['Prefix'] 					= $XVwebEngine->read_prefix_from_url($URLS['PathInfo']);
$XVwebEngine->Date['UrlSite'] =		$URLS['Site'];
$XVwebEngine->Date['URLS'] =		$URLS;
$URLS['JSCatalog']		= $URLS['JSCatalog'].$xv_theme_name."/";


@header('Access-Control-Allow-Origin: '.$URLS['Site']);
//Plugin:onReady
xv_trigger("xvweb.ready");


//!Plugin:onReady

$PathInfo = $XVwebEngine->add_path_slashes($URLS['Path']);

if(!$XVwebEngine->Session->Session('xv_visit')){
	xv_trigger("xvweb.visit");
	$XVwebEngine->Session->Session('xv_visit', true);
}


/**************************Lang*******************/
function xv_load_lang($lang){
	global $Language, $XVwebEngine;
	$user_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if (file_exists(ROOT_DIR.'languages'.DIRECTORY_SEPARATOR.$user_lang.DIRECTORY_SEPARATOR.$lang.'.'.$user_lang.'.php')) {
		@include_once(ROOT_DIR.'languages'.DIRECTORY_SEPARATOR.$user_lang.DIRECTORY_SEPARATOR.$lang.'.'.$user_lang.'.php');
	} else {
		$default_lang = xv_main_config()->lang;
		if(!@include_once(ROOT_DIR.'languages'.DIRECTORY_SEPARATOR.$default_lang.DIRECTORY_SEPARATOR.$lang.'.'.$default_lang.'.php')){
			exit("XVweb Fatal Error. Don't isset language ".$lang.".".$default_lang);
		}
	}

}
xv_load_lang("general");
/**************************Lang*******************/

try {
	$Smarty = new Smarty();
	$Smarty->addPluginsDir(ROOT_DIR.'plugins/smarty/');
	$Smarty->plugins_dir[] = (getcwd()).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR;
	$Smarty->template_dir = 'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR;
	$CompileDir = getcwd().DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR;
	if(!is_dir($CompileDir))
	mkdir($CompileDir);
	$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
	$Smarty->config_dir   = 'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
	$Smarty->cache_dir    = 'themes'.DIRECTORY_SEPARATOR.$xv_theme_name.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
	$Smarty->compile_check = false;
	$Smarty->debugging = false;
	$JSBinder = array();
	$CCSLoad = array();
	$JSLoad = array();
	$Smarty->assign('MediaBottom', true);
} catch (Exception $e) { 
			xvp()->ErrorClass($XVwebEngine, $e);
} 
xv_append_meta("Content-Language", "pl");
xv_append_meta("Content-Type", "text/html; charset=utf-8");

//AdminDetect - include admin lang
if(xv_perm('AdminPanel'))
	xv_load_lang('admin');
//End AdminDetect

////////Uzupełnianie stałymi szablonu


$Smarty->assignByRef('Menu',   xvp()->genMenu($XVwebEngine));
$Smarty->assignByRef('xv_main_config',   $xv_main_config);
$Smarty->assign('Session', $XVwebEngine->Session->Session());
$Smarty->assignByRef('language', $Language);

$Smarty->assignByRef('URLS', $URLS);
$Smarty->assign('PathInfo', htmlspecialchars($PathInfo, ENT_QUOTES ));
$Smarty->assign('LogedUser', $XVwebEngine->Session->Session("user_logged_in"));
$Smarty->assign('AvantsURL', $URLS['Avats']);
$Smarty->assign('JSVars', (array('SIDUser'=>$XVwebEngine->Session->get_sid(), 'rootDir'=>$URLS['Site'])	));
xv_trigger("xvweb.smarty.loaded");

$xv_prefix_file = $XVwebEngine->Plugins()->Menager()->prefix($URLS['Prefix']);

xv_trigger("xvweb.preload_module");
$xv_redirect_404 = true;
if($xv_prefix_file){
	require($xv_prefix_file);
}else{
	xv_trigger("xvweb.404");
	if($xv_redirect_404 === false && isset($xv_include_404)){
		include($xv_include_404);
	}
	if($xv_redirect_404){
		header("location: ".$URLS['Script'].'Page/System/404/'.substr($URLS['Path'],1));
		exit;
	}
}

xv_trigger("xvweb.end");

?>