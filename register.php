<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   register.php      *************************
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

if(isset($_GET["activate"])){
	if($GLOBALS['XVwebEngine']->ActivateUser($_GET['login'], $_GET['temppass'])){
	if($XVwebEngine->Plugins()->Menager()->event("register.activate")) eval($XVwebEngine->Plugins()->Menager()->event("register.activate")); 
	header("location: ".$URLS['Script'].'System/Registration/Activate/');
	} else header("location: ".$URLS['Script'].'System/Registration/Activate_error/');
	exit;

}

if(isset($_GET["SingUp"])){
	Register();
	exit;
}

function Register(){
global $XVwebEngine, $Smarty;

if($XVwebEngine->Plugins()->Menager()->event("register.predone")) eval($XVwebEngine->Plugins()->Menager()->event("register.predone")); 

			$_POST['register']['Admin'] = ($XVwebEngine->Config("config")->find("config rank user")->html());
			$_POST['register']['IP'] = $_SERVER['REMOTE_ADDR'];
			$_POST['register']['RegisterCode'] = substr(md5(uniqid()),0 ,9);
			$_POST['register']['Password'] = md5(MD5Key.$_POST['register']['Password']);
			$_POST['register']['Creation'] = date( 'Y-m-d H:i:s' );
			
	if($_POST['register']['Captcha'] != $XVwebEngine->Session->Session('Captcha_code'))
		$Smarty->assign('Error', "BadCaptcha"); else{
	if($XVwebEngine->module("Register", "Register")->set($_POST['register']) !== true)
		$Smarty->assign('Error', $XVwebEngine->module("Register", "Register")->Date['Error']);
	}
if($XVwebEngine->Plugins()->Menager()->event("register.done")) eval($XVwebEngine->Plugins()->Menager()->event("register.done")); 
if($XVwebEngine->Plugins()->Menager()->event("register.show")) eval($XVwebEngine->Plugins()->Menager()->event("register.show")); 
$Smarty->display('register_show.tpl');
}
if($XVwebEngine->Plugins()->Menager()->event("register.show")) eval($XVwebEngine->Plugins()->Menager()->event("register.show")); 
$Smarty->display('register_show.tpl');

?>