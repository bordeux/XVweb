<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   view.php          *************************
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
//! Disable mafic quotes //
function xv_appendJS($file, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('JSLoad');
		if(is_null($num))
		$myVar[] = $file; else $myVar[$num] = $file;
		$Smarty->assign('JSLoad', $myVar); 
}
function xv_appendFooter($text, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('footer');
		if(is_null($num))
		$myVar[] = $text; else $myVar[$num] = $text;
		$Smarty->assign('footer', $myVar); 
}
function xv_appendCSS($file, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('CCSLoad');
		if(is_null($num))
		$myVar[] = $file; else $myVar[$num] = $file;
		$Smarty->assign('CCSLoad', $myVar); 
}
function xvLang($var, $var2 =null){
return ifsetor($GLOBALS['Language'][$var],(is_null($var) ? $var : $var2));
}
function xvPerm($perm){
	return $GLOBALS['XVwebEngine']->permissions($perm);
}
function smarty_modifier_perm($perm){ //for smarty
	return $GLOBALS['XVwebEngine']->permissions($perm);
}


class XVTemplate {
	function xv_appendMeta($name, $content){
		global $Smarty;
			$myVar = (array) $Smarty->getTemplateVars('MetaTags');
			if(!is_array($myVar))
				$myVar = array();
			$myVar[$name] = $content;
			$Smarty->assign('MetaTags', $myVar); 
	}
}

DEFINE('SMARTY_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'smarty3'.DIRECTORY_SEPARATOR);
DEFINE('Cache_dir', dirname(__FILE__).DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR);
DEFINE('ROOT_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);


$RootDir = dirname(__FILE__).DIRECTORY_SEPARATOR;
$XVwebDir = $RootDir.'core'.DIRECTORY_SEPARATOR;

if(!@include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php')){
	if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'install/index.php')) 
	include(dirname(__FILE__).DIRECTORY_SEPARATOR.'install/index.php');
	exit();
}

if(Debug_Enabled === false){
	function CaughtErrors() { 
		global $XVwebEngine;
		$IgnoreErrors = array(8, 2, 2048);
		if(is_null($e = error_get_last()) === false && !in_array($e['type'], $IgnoreErrors))
		$XVwebEngine->Log("SystemError", array("ErrorInfo"=>$e, "_SERVER"=>$_SERVER));
	}
	register_shutdown_function('CaughtErrors');
}

require_once(SMARTY_DIR . 'Smarty.class.php');
include_once('core'.DIRECTORY_SEPARATOR.'XVWeb.class.php');


$XVwebEngine = new XVWeb(dirname(__FILE__).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);
$XVwebEngine->ConnectPDO(BdServer, BdServer_Base, BdServer_User, BdServer_Password);
$XVwebEngine->DataBasePrefix = BdServer_prefix;

/**Config File**/
$XVwebEngine->Date['ConfigFile'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.xml';
$XVwebEngine->Date['RootDir'] = $RootDir;
/**Config File**/

$XVwebEngine->PreWork();
$XVwebEngine->Plugins()->set("DirPlugins", (dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR));




/**************************THEME*******************/
$ThemeSelected = $XVwebEngine->Config("config")->find("theme")->text();
if($XVwebEngine->Session->Session('Logged_Theme') && is_dir('themes'.DIRECTORY_SEPARATOR.$XVwebEngine->Session->Session('Logged_Theme').DIRECTORY_SEPARATOR))
$ThemeSelected = $XVwebEngine->Session->Session('Logged_Theme');

if($XVwebEngine->Plugins()->Menager()->event("pre.seturl")) eval($XVwebEngine->Plugins()->Menager()->event("pre.seturl"));
/**Uzupelnienia**/
$URLS['Catalog'] = '';
if(isset($_SERVER['PHP_SELF']) && stripos($_SERVER['PHP_SELF'], basename(__FILE__)))
$URLS['Catalog'] = substr(substr($_SERVER['PHP_SELF'], 0,  stripos($_SERVER['PHP_SELF'], basename(__FILE__))), 1); 
	else
$URLS['Catalog'] = $XVwebEngine->Config("config")->find("config catalog")->text();


if(empty($URLS['Site'])) 			$URLS['Site']			= 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST']."/".$URLS['Catalog'];
if(empty($URLS['Path']))	        $URLS['Path']	        = $_SERVER[PHP_PathInfo];
if(empty($URLS['ThemeCatalog']))	$URLS['ThemeCatalog']	= $URLS['Site'].'themes/';
if(empty($URLS['JSCatalog']))		$URLS['JSCatalog']		= $URLS['Site'].'themes/';
if(empty($URLS['Script']))			$URLS['Script']			= $URLS['Site'].($XVwebEngine->Config("config")->find("config rewrite")->text() == "true" ?"":"view.php/");
if(empty($URLS['Theme']))			$URLS['Theme']			= $URLS['ThemeCatalog'].$ThemeSelected."/";
if(empty($URLS['Avats']))			$URLS['Avats']			= $URLS['Site'].'files/avants/';
if(empty($UploadDir))		       	$UploadDir		        = dirname(__FILE__).DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
$URLS['PathInfo']	= $XVwebEngine->AddSlashesStartAndEnd($URLS['Path']);
$URLS['Prefix'] 	= $XVwebEngine->ReadPrefix($URLS['PathInfo']);
$XVwebEngine->Date['UrlSite'] =		$URLS['Site'];
$XVwebEngine->Date['URLS'] =		$URLS;
$URLS['JSCatalog']		= $URLS['JSCatalog'].$ThemeSelected."/";

@header('Access-Control-Allow-Origin: '.$URLS['Site']);
//Plugin:onReady
if($XVwebEngine->Plugins()->Menager()->event("onready")) eval($XVwebEngine->Plugins()->Menager()->event("onready"));

//AutoLogin
if($XVwebEngine->Session->Session('Logged_Logged') != true && !empty($_COOKIE['LogedUser']) && !empty($_COOKIE['LogedUserPass']) && $_COOKIE['UnLoged']!="true"){
	if($XVwebEngine->Loggin($_COOKIE['LogedUser'], $_COOKIE['LogedUserPass'], true)){
		//Plugin:onLogin
		if($XVwebEngine->Plugins()->Menager()->event("onlogin")) eval($XVwebEngine->Plugins()->Menager()->event("onlogin")); 
		//!Plugin:onLogin
	}else {
		setcookie("LogedUser", "", time()- 3600);
		setcookie("LogedUserPass", "", time()- 3600);
	}
}
//AutoLogin


if ($XVwebEngine->Config("config")->find("config disable page disable")->text() == "true" && (in_array(strtolower($URLS['Prefix']), array("login", "captcha", "cron", "administration", "lostpass")) == false)){
	LoadLang("custom");
	if($XVwebEngine->Config("config")->find("config disable page method")->text() == "redirect"){
		header("location: ".$XVwebEngine->Config("config")->find("config disable page url")->text(), TRUE , 307);
		exit;
	}
	else
	exit(htmlspecialchars_decode($XVwebEngine->Config("config")->find("config disable page message")->text()));
}



//!Plugin:onReady
$XVwebEngine->SrvLocation = "http://".$_SERVER['HTTP_HOST']."/".$XVwebEngine->Config("config")->find("config catalog")->text();
$XVwebEngine->SrvName = $XVwebEngine->Config("config")->find("config sitename")->text();
$XVwebEngine->SrvDomain = $_SERVER['HTTP_HOST'];
$PathInfo = $XVwebEngine->AddSlashesStartAndEnd($URLS['Path']);

//Plugin:onVisit
if(!$XVwebEngine->Session->Session('SessionIsset')){
	if($XVwebEngine->Plugins()->Menager()->event("onvisit"))
	eval($XVwebEngine->Plugins()->Menager()->event("onvisit"));
	$XVwebEngine->Session->Session('SessionIsset', true);
}
//!Plugin:onVisit
//CheckBannned
if(!$XVwebEngine->Session->Session('BanChecked')){
	//CheckBannned
	$Banned = $XVwebEngine->InitClass("BanClass")->CheckBanned();
	if($Banned){
		$BanURL = "/System/Banned/";
		if(substr($PathInfo, 0, strlen($BanURL)) != $BanURL){
			header("location: ".$URLS['Script'].substr($BanURL , 1));
			exit;
		}
	}else
	$XVwebEngine->Session->Session('BanChecked', true);
}
//!CheckBannned

/**************************Lang*******************/
function LoadLang($lang){
	global $Language, $XVwebEngine;
	
	$UserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$UserLang.DIRECTORY_SEPARATOR.$lang.'.'.$UserLang.'.php')) {
		@include_once('languages'.DIRECTORY_SEPARATOR.$UserLang.DIRECTORY_SEPARATOR.$lang.'.'.$UserLang.'.php');
	} else {
		$DefaultLang = $XVwebEngine->Config("config")->find("config lang")->text();
		if(!@include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$DefaultLang.DIRECTORY_SEPARATOR.$lang.'.'.$DefaultLang.'.php'))
		die("XVweb Fatal Error. Don't isset language ".$lang.".".$DefaultLang);
	}
	
}
LoadLang("general");
/**************************Lang*******************/

/**Uzupelnienia**/
if(isset($_GET['LogOut']) && $_GET['LogOut']=="true"){
	$XVwebEngine->LogOut();
	@setcookie("LogedUser", "", time() - 3600, "/");
	@setcookie("LogedUserPass", "", time() - 3600, "/");
	@setcookie("UnLoged", "true", time()+10, "/");
	header("location: ".$URLS['Script'].'System/UnLoged/');
	exit;
}
try {
	$Smarty = new Smarty();
	$Smarty->plugins_dir[] = dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR;
	$Smarty->template_dir = 'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR;
	$CompileDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR;
	if(!is_dir($CompileDir))
	mkdir($CompileDir);
	$Smarty->compile_dir  = $CompileDir; unset($CompileDir);
	$Smarty->config_dir   = 'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
	$Smarty->cache_dir    = 'themes'.DIRECTORY_SEPARATOR.$ThemeSelected.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
	$Smarty->compile_check = Debug_Enabled;
	$Smarty->debugging = Debug_Enabled;
	$JSBinder = array();
	$CCSLoad = array();
	$JSLoad = array();
	$Smarty->assign('MediaBottom', true);
} catch (Exception $e) { 
			$XVwebEngine->ErrorClass($e);
} 

//AdminDetect - include admin lang
if(xvPerm('AdminPanel'))
LoadLang('admin');
//End AdminDetect

////////Uzupełnianie stałymi szablonu
$MetaTags = array(
	"Content-Language"=> "pl",
	"Content-Type"=>"text/html; charset=utf-8",
	"Content-Script-Type"=>"text/javascript",
	"Content-Style-Type"=>"text/css",
);


if($XVwebEngine->Config("config")->find("config adv")->length && $XVwebEngine->Config("config")->find("config adv")->text() == "false")
$Smarty->assign('Advertisement', false); else
$Smarty->assign('Advertisement', ($XVwebEngine->permissions('Adv') ? false : true));
if($XVwebEngine->Plugins()->Menager()->event("onPreAssing")) eval($XVwebEngine->Plugins()->Menager()->event("onPreAssing"));

$Smarty->assign('MetaTags', $MetaTags); unset($MetaTags);
$Smarty->assignByRef('Menu',   $XVwebEngine->genMenu());
$Smarty->assign('Session', $XVwebEngine->Session->Session());
$Smarty->assignByRef('language', $Language);
$Smarty->assign('SiteName',  $XVwebEngine->SrvName);
$GAnalistocs = $XVwebEngine->Config("config")->find("config google analistics id");
if($GAnalistocs->length)
$Smarty->assign('GAnalistics',  $GAnalistocs->html());
unset($GAnalistocs);

$Smarty->assignByRef('URLS', $URLS);
$Smarty->assign('Url', $URLS['Site']);
$Smarty->assign('UrlScript', $URLS['Script']);
$Smarty->assign('PathInfo', htmlspecialchars($PathInfo, ENT_QUOTES ));
$Smarty->assign('LogedUser', $XVwebEngine->Session->Session("Logged_Logged"));
$Smarty->assign('UrlTheme', $URLS['Theme']);
$Smarty->assign('AvantsURL', $URLS['Avats']);
$Smarty->assign('JSVars', (array('SIDUser'=>$XVwebEngine->Session->GetSID(), 'rootDir'=>$URLS['Site'], "UrlScript"=>$URLS['Script'], "JSCatalog"=>$URLS['JSCatalog'])	));

$Prefix =$XVwebEngine->Plugins()->Menager()->prefix($URLS['Prefix']);
//Plugin:preLoad
if($XVwebEngine->Plugins()->Menager()->event("preload")) eval($XVwebEngine->Plugins()->Menager()->event("preload")); 
//!Plugin:preLoad

if($Prefix)
require($Prefix);
else
require("articles.php");

//Plugin:onLoad
if($XVwebEngine->Plugins()->Menager()->event("onload")) eval($XVwebEngine->Plugins()->Menager()->event("onload")); 
//!Plugin:onLoad
?>