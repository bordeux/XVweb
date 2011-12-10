<?php
require_once('plugins/data/facebook/facebook.php');

if(isset($_GET['Path']))
$_GET['Path'] = urlencode($_GET['Path']);
else
$_GET['Path'] = "";
if (!$XVwebEngine->Config("config")->find("config facebook login enable")->length OR $XVwebEngine->Config("config")->find("config facebook login enable")->text() != "true"){
	header("location: ".$URLS['Script'].'System/Facebook/Disabled');
	exit;
	}

	if(($XVwebEngine->Session->Session('Logged_Logged'))) {
		header("location: ".$URLS['Script']);
		exit;
		}
	if(($XVwebEngine->Config("config")->find("config facebook appid")->length + $XVwebEngine->Config("config")->find("config facebook secret")->length) < 2 ){
		header("location: ".$URLS['Script'].'System/Facebook/ConfigError');
		exit;
		}

if(strtolower($XVwebEngine->GetFromURL($PathInfo, 2)) == "register" ){
$RegisterArray = $XVwebEngine->Session->Session("FBRegister");

if(!$XVwebEngine->isset_user($_POST['changenick']['Nick']) && !empty($RegisterArray )){
$RegisterArray['User'] = $_POST['changenick']['Nick'];

	if($XVwebEngine->module("Register", "Register")->set($RegisterArray) === true){
		$XVwebEngine->Loggin($RegisterArray['User'], null, false , false);
		header("location: ".$URLS['Script'].$_GET['Path']);
	exit;
	}else
		$Smarty->assign('Error', $XVwebEngine->module("Register", "Register")->Date['Error']);
}

}

$facebook = new Facebook(array(
  'appId'  => trim($XVwebEngine->Config("config")->find("config facebook appid")->text()),
  'secret' => trim($XVwebEngine->Config("config")->find("config facebook secret")->text()),
  'cookie' => true,
));

$session = $facebook->getSession();
$UserFB = null;
if ($session) {
  try {
    $uid = $facebook->getUser();
    $UserFB = $facebook->api('/me/');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}


if ($UserFB) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array(
        'req_perms' => 'email,user_birthday,user_hometown,user_location,user_website'
        ));
	header('Location: '.$loginUrl);
	exit;
}

$FBLogin = $XVwebEngine->DataBase->prepare('SELECT {Users:User} AS `User` FROM  {Users} WHERE {Users:Facebook} = :FacebookID LIMIT 1');
$FBLogin->execute(array(":FacebookID"=>$UserFB['id']));
$FBLogResult = $FBLogin->fetch();

if($FBLogResult){
		header("location: ".$URLS['Script'].$_GET['Path']);
		$XVwebEngine->Loggin($FBLogResult['User'], null, false , false);
	exit;
}

$BirthDate = explode('/', $UserFB['birthday']);

	$UserRegister  = array(
	"User" => 'user',
	"Name" => $UserFB['first_name'],
	"VorName" => $UserFB['last_name'],
	"Password" => md5(getrandmax().uniqid()),
	"Mail" => $UserFB['email'],
	"Page" => $UserFB['website'],
	"Born" => $BirthDate[2].'-'.$BirthDate[0].'-'.$BirthDate[1], 
	"Creation" => date( 'Y-m-d H:i:s' ),
	"WhereFrom" => $UserFB['hometown']['name'],
	"IP" => $_SERVER['REMOTE_ADDR'],
	"RegisterCode" =>1,
	"Admin" => ($XVwebEngine->Config("config")->find("config rank facebook")->length ? $XVwebEngine->Config("config")->find("config rank facebook")->html() : $XVwebEngine->Config("config")->find("config rank user")->html()),
	"Facebook" =>$UserFB['id'],
	);
	
$XVwebEngine->Session->Session("FBRegister", $UserRegister);

$Smarty->assign('FormPath', 'Facebook/Register?Path='.$_GET['Path']);
$Smarty->display('changenick_show.tpl');


?>