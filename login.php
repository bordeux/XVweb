<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   login.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :  1.0                *************************
****************   Authors   :  XVweb team         *************************
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
}
if($XVwebEngine->Session->Session('Logged_Logged') == true){
    header("location: ".$URLS['Script']);
	exit;
	}

function Login(){
	extract($GLOBALS);
	$Smarty->assign('action', 'signin');
	if($XVwebEngine->Loggin($_POST['LoginLogin'], $_POST['LoginPassword'])){
		//Plugin:onLogin
		if($XVwebEngine->Plugins()->Menager()->event("onlogin")) eval($XVwebEngine->Plugins()->Menager()->event("onlogin")); 
		//!Plugin:onLogin
		
		$Smarty->assign('LogedReturn', true);
		$Smarty->assign('LogedUser', $XVwebEngine->Loggin['User']);
		if(isset($_POST['LoginRemember'])){
			setcookie("LogedUser", ($XVwebEngine->Session->Session('Logged_User')), strtotime("+14 days"), "/");
			setcookie("LogedUserPass", md5(MD5Key.$XVwebEngine->Session->Session('Logged_Password')), strtotime("+14 days"), "/");
			$Smarty->assign('LogedLoginRemember', true);
		}
	}else{
		$Smarty->assign('LogedReturn', false);
		$Smarty->assign('LogedError', $XVwebEngine->Loggin['Error']);
	}
	$Smarty->assign('Session', $XVwebEngine->Session->Session());
	$Smarty->display('login_show.tpl');
	exit;
}
$action = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
switch($action){
	case "signin" :
		Login();
	break;
}
$Smarty->display('login_show.tpl');
?>