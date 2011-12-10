<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'GOpenID.class.php');

if(isset($_GET['Path']))
$_GET['Path'] = urlencode($_GET['Path']);
else
$_GET['Path'] = "";
if (!$XVwebEngine->Config("config")->find("config google login enable")->length OR $XVwebEngine->Config("config")->find("config google login enable")->text() != "true"){
	header("location: ".$URLS['Script'].'System/Google/Disabled');
	exit;
	}

	if(($XVwebEngine->Session->Session('Logged_Logged'))) {
		header("location: ".$URLS['Script']);
		exit;
		}
$GoogleID = new GOpenID();

if(strtolower($XVwebEngine->GetFromURL($PathInfo, 2)) == "register" ){
$RegisterArray = $XVwebEngine->Session->Session("GORegister");

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

if(strtolower($XVwebEngine->GetFromURL($PathInfo, 2)) == "get" ){

if(!$GoogleID->Validate()){
	header("location: ".$URLS['Script'].'System/Google/Error/');
	exit;
}

$GOLogin = $XVwebEngine->DataBase->prepare('SELECT {Users:User} AS `User` FROM {Users} WHERE {Users:Mail} = :Mail LIMIT 1');
$GOLogin->execute(array(":Mail"=>$GoogleID->GetEmail()));
$GOLogResult = $GOLogin->fetch();

if($GOLogResult){
		header("location: ".$URLS['Script'].$_GET['Path']);
		$XVwebEngine->Loggin($GOLogResult['User'], null, false , false);
	exit;
}


	$UserRegister  = array(
	"User" => 'user',
	"Name" => $GoogleID->GetFirst(),
	"VorName" => $GoogleID->GetLast(),
	"Password" => md5(getrandmax().uniqid()),
	"Mail" => $GoogleID->GetEmail(),
	"Creation" => date( 'Y-m-d H:i:s' ),
	"IP" => $_SERVER['REMOTE_ADDR'],
	"RegisterCode" =>1,
	"Admin" => ($XVwebEngine->Config("config")->find("config rank google")->length ? $XVwebEngine->Config("config")->find("config rank google")->html() : $XVwebEngine->Config("config")->find("config rank user")->html())
	);
	
$XVwebEngine->Session->Session("GORegister", $UserRegister);


}
if(strtolower($XVwebEngine->GetFromURL($PathInfo, 2)) == "" ){
$GoogleID->set("openid.return_to", $URLS['Script'].'GoogleID/Get');
$GoogleID->set("openid.realm", $URLS['Site']);
$GoogleID->Redirect();
}
$Smarty->assign('FormPath', 'GoogleID/Register?Path='.$_GET['Path']);
$Smarty->display('changenick_show.tpl');

?>