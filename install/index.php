<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   install/index.php *************************
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
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
@header('Content-Type: text/html; charset=utf-8');
session_name('InstallSession');
session_id('Install');
session_start(); 

chdir(dirname(__FILE__).'/../');
DEFINE('SMARTY_DIR', getcwd().DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'smarty3'.DIRECTORY_SEPARATOR);

require_once(SMARTY_DIR . 'Smarty.class.php');

if(isset($_SESSION['Lang'])){
	if(!@include_once('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$_SESSION['Lang']))
	die("Install XVweb Fatal Error. Don't isset language ".$_SESSION['Lang']);
}else{
	$UserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$Lang = "en";
	if (file_exists('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$UserLang.'.php')) {
		@include_once('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$UserLang.'.php');
	} else {
		if(!@include_once('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$Lang.'.php'))
		die("Install XVweb Fatal Error. Don't isset language ".$Lang);
	}
}
function Step1(){
	extract($GLOBALS); 
	$Smarty->assign('Step', 1);
	
	foreach (glob('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.'*.php') as $filename) 
	$LangsList[basename($filename)] = basename($filename);
	$Smarty->assign('LangList', $LangsList);
	$Smarty->assign('SelecedLang', $Language['Lang']);
	
}

function Step2(){
	extract($GLOBALS); 
	if(isset($_POST['Lang']))
	$_SESSION['Lang']= $_POST['Lang']; 
	if(!@include('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$_SESSION['Lang']))
	die("Install XVweb Fatal Error. Don't isset language ".$_SESSION['Lang']);
	$Smarty->assign('language',  $Language);
	$Smarty->assign('Step', 2);
}

function Step3(){
	extract($GLOBALS); 
	
	
	$RequiredFunctions = array(
	"gzopen",
	"gd_info",
	"json_decode",


	);

	$RequiredClass = array(

	);

	$RequiredExtension = array(
	"tidy",
	"pdo",
	"dom",
	"pdo_mysql",
	"json",
	"libxml",
	"iconv",
	"date",
	);

	$CheckingResult = array();
	foreach ($RequiredFunctions as $Function)
	$CheckingResult['Functions'][] = array("Name"=>$Function, "Result"=>(function_exists($Function)));
	

	foreach ($RequiredClass as $Class)
	$CheckingResult['Class'][] = array("Name"=>$Class, "Result"=>(class_exists($Class)));
	

	foreach ($RequiredExtension as $Extension)
	$CheckingResult['Extension'][] = array("Name"=>$Extension, "Result"=>(extension_loaded($Extension)));
	
	$Smarty->assign('CheckResult', $CheckingResult);
	$Smarty->assign('Step', 3);


}
function step4(){
	extract($GLOBALS);
	if(isset($_GET['ValidMYSQl'])){
		$Result = array("Result"=>true);
		try {	
			$dbh = new PDO('mysql:host='.$_POST['Server'].';dbname='.$_POST['DataBase'], $_POST['User'], $_POST['Password']);
		} catch (PDOException $e) {
			$Result = array("Result"=>false, "Code"=>$e->getCode(), "Message"=>($e->getMessage()));
		}
		header('Content-type: application/x-json');
		exit(json_encode($Result));
	}
	$Smarty->assign('Step', 4);

}
function Step5(){
	extract($GLOBALS); 
	$Smarty->assign('Step', 5);
	try {	
		$dbh = new PDO('mysql:host='.$_POST['Server'].';dbname='.$_POST['DataBase'], $_POST['User'], $_POST['Password']);
	} catch (PDOException $e) {
		header("location: ?Step=4");
		exit();
	}
	$_SESSION['DataBase'] = array("Server"=>$_POST['Server'], "DataBase"=>$_POST['DataBase'], "User"=>$_POST['User'],"Password"=>$_POST['Password'],"Prefix"=>$_POST['Prefix']);
	
	$SQLFile = 'install'.DIRECTORY_SEPARATOR.'DataBaseStructure.sql';
	$SQLImport = file_get_contents($SQLFile);
	$SQLImport = $SQLImport;
	if(!empty($_SESSION['DataBase']['Prefix']))
	$SQLImport = str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `'.($_SESSION['DataBase']['Prefix']), $SQLImport);
	$SQLImport = strtr($SQLImport, array("||Prefix||"=>$_SESSION['DataBase']['Prefix'] ));
	$MySQLResult = array("Result"=>true);
	try {
		$dbh->exec($SQLImport);
	} catch (PDOException $e) {
		$MySQLResult = array("Result"=>false, "Code"=>$e->getCode(), "Message"=>($e->getMessage()));
	}
	$Smarty->assign('MySQLResult', $MySQLResult);
}

function checkEmail($email)
{
	if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
	return false; 
	return true;
}
function Step6(){
	extract($GLOBALS); 
	$Smarty->assign('Step', 6);
	$Listing['Lang'] = array();
	foreach (glob('languages'.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) as $filename){
		if(file_exists($filename.DIRECTORY_SEPARATOR.'general.'.basename($filename).'.php'))
		$Listing['Lang'][basename($filename)] = basename($filename);
	}
	$Smarty->assign('Listing', $Listing);
}
function Step7(){
	extract($GLOBALS); 
	$Smarty->assign('Step', 7);
	try {	
		$dbh = new PDO('mysql:host='.$_SESSION['DataBase']['Server'].';dbname='.$_SESSION['DataBase']['DataBase'], $_SESSION['DataBase']['User'], $_SESSION['DataBase']['Password']);
	$SQLFile = ('install'.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.$Language['SQLFile']);
	if (!file_exists($SQLFile)) {
		header('location: ?Error='.urlencode('Fatal error - SQL file '.$Language['SQLFile'].' don\'t exist! Install aborted!').'&ErrorCode=1');
		exit();
	}
	if(isset($_POST['Mail'])){
		if(checkEmail($_POST['Mail']))
		$_SESSION['Config']['Mail'] =$_POST['Mail']; 
		else{
			header("location: ?Step=6&Error=Mail&ErrorMSG=".urlencode('Invalid email adress'));
			exit();
		}
	}
	if(isset($_POST['LPassword'])){
		if(strlen($_POST['LPassword'])>4)
		$_SESSION['Config']['LPassword'] =$_POST['LPassword']; 
		else{
			header("location: ?Step=6&Error=Password&ErrorMSG=".urlencode('Short password'));
			exit();
		}
	}
	if(isset($_POST['SiteLang']))
	$_SESSION['Config']['SiteLang'] = $_POST['SiteLang'];
	if(isset($_POST['SiteName']))
	$_SESSION['Config']['SiteName'] = $_POST['SiteName'];
	if(isset($_POST['MD5Key']))
	$_SESSION['Config']['MD5Key'] = $_POST['MD5Key'];
	if(isset($_POST['Catalog']))
	$_SESSION['Config']['Catalog'] = $_POST['Catalog'];
	if(isset($_POST['Login'])){
		if(preg_match("/^([a-zA-Z0-9 _.-])+$/i",  $_POST['Login']))
		$_SESSION['Config']['Login'] = $_POST['Login']; else{
			header("location: ?Step=6&Error=Login&ErrorMSG=".urlencode('Invalid user login'));
			exit();
		}
	}
	

	
	$AdminQuery = "INSERT INTO `".$_SESSION['DataBase']['Prefix']."users` (`id`, `user`, `openid`, `sex`, `name`, `vorname`, `password`, `mail`, `gg`, `icq`, `skype`, `tlen`, `page`, `signature`, `born`, `creation`, `info`, `wherefrom`, `avantr`, `ip`, `admin`, `theme`, `registercode`, `languages`) VALUES
(1, '".addslashes($_SESSION['Config']['Login'])."', '', '2', 'XVweb', 'Project', '".md5($_SESSION['Config']['MD5Key'].$_SESSION['Config']['LPassword'])."', '".addslashes($_SESSION['Config']['Mail'])."', 0, '', 'xvweb', '', 'http://www.bordeux.net/XVweb', 'Welcome in XVweb!', '".date("d.m.Y")."', '".date("Y-m-d H:i:s")."', 'Bordeux.NET', 'XVweb', '', '127.0.0.1, Bordeux.NET', '11111111111111111111111111111111111111111111111111', NULL, '1', 'XVweb');";
	$SQLImport = file_get_contents($SQLFile);
	$SQLImport = $SQLImport;
	$SQLImport = strtr($SQLImport, array("||Prefix||"=>$_SESSION['DataBase']['Prefix'] ));
	$MySQLResult = array("Result"=>true);
		$dbh->exec($SQLImport);
		$dbh->exec($AdminQuery);
	
	$ConfigFile = '<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   config.php        *************************
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
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
DEFINE(\'BdServer\', \''.addslashes($_SESSION['DataBase']['Server']).'\', true);
DEFINE(\'BdServer_User\', \''.addslashes($_SESSION['DataBase']['User']).'\', true);
DEFINE(\'BdServer_Password\', \''.addslashes($_SESSION['DataBase']['Password']).'\', true);
DEFINE(\'BdServer_Base\', \''.addslashes($_SESSION['DataBase']['DataBase']).'\', true);
DEFINE(\'BdServer_prefix\', \''.addslashes($_SESSION['DataBase']['Prefix']).'\', true);
DEFINE(\'PHP_PathInfo\', \'PATH_INFO\', true);
DEFINE(\'Debug_Enabled\', false, true); 
DEFINE(\'XVweb_DisplayErrors\', true, true); 
DEFINE(\'MD5Key\', \''.addslashes($_SESSION['Config']['MD5Key']).'\', true); 
?>';
	file_put_contents('config.php', $ConfigFile);
	
$XMLConfigFile  = 'config'.DIRECTORY_SEPARATOR.'config.xml';
$doc = new DOMDocument();
$doc->load($XMLConfigFile);
$doc->getElementsByTagName('sitename')->item(0)->nodeValue = $_SESSION['Config']['SiteName'];
$doc->getElementsByTagName('catalog')->item(0)->nodeValue = $_SESSION['Config']['Catalog'];
$doc->getElementsByTagName('lang')->item(0)->nodeValue = $_SESSION['Config']['SiteLang'];
$doc->save($XMLConfigFile);

} catch (PDOException $e) {
			$MySQLResult = array("Result"=>false, "Code"=>$e->getCode(), "Message"=>($e->getMessage()));
	}

$Smarty->assign('MySQLResult', $MySQLResult);
}
function step8(){
rename('install/', mt_rand().'install/');
$Catalog = $_SESSION['Config']['Catalog'];
	session_unset();
	session_destroy();  
	header("location: http://".$_SERVER['HTTP_HOST']."/".$Catalog);
	exit();
}
$Smarty = new Smarty();
$Smarty->plugins_dir[] = getcwd().DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR;
$Smarty->template_dir = 'install'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR;
$Smarty->compile_dir  = 'install'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.'compile'.DIRECTORY_SEPARATOR;
$Smarty->config_dir   = 'install'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
$Smarty->cache_dir    = 'install'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
$Smarty->compile_check = true;
$Smarty->debugging = false;
$Smarty->assign('language',  $Language);


$Smarty->assign('License', file_get_contents('install'.DIRECTORY_SEPARATOR.'license.txt'));
if(isset($_GET['Step'])){
	switch($_GET['Step'])
	{
	case 1:
		Step1();			
		break;
	case 2:
		Step2();			
		break;
	case 3:
		Step3();
		break;
	case 4:
		step4();
		break;
	case 5:
		step5();
		break;
	case 6:
		step6();
		break;
	case 7:
		step7();
		break;
	case 8:
		step8();
		break;
	default:
		Step1();
	}
}else
Step1();

$Smarty->display('view.tpl');

?>