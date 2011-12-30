<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   lostpass.php      *************************
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

switch(strtolower($XVwebEngine->GetFromURL($PathInfo, 2))){
case "get":
	FirstStep();
	break;
case "reset":
	SecondStep();
	break; 

}


function FirstStep(){
	global $Smarty, $XVwebEngine;
	try{
		if($XVwebEngine->LostPassword()->FirstStep($_POST['LostEmail'])){
			$Smarty->assign('Content', $XVwebEngine->LostPassword()->Date['MSG']);	
			$Smarty->assign('Result', true);	
		}
		
	} catch (XVwebException $e) {
		$Smarty->assign('Result', false);
		$Smarty->assign('ErrorCode', $e->getCode());
	}
	if($XVwebEngine->Plugins()->Menager()->event("lostpassword.firststep")) eval($XVwebEngine->Plugins()->Menager()->event("lostpassword.firststep")); 
	$Smarty->display('lostpassword_show.tpl');
	exit;
}
function SecondStep(){

	global $Smarty, $XVwebEngine, $PathInfo, $URLS;
	
	try{
		if($XVwebEngine->LostPassword()->SecondStep($XVwebEngine->GetFromURL($PathInfo, 3),$XVwebEngine->GetFromURL($PathInfo, 4) )){
		header("location: ".$URLS['Script'].'System/ResetPassword/Step2MSG/'); 
		exit;
		}else{
		header("location: ".$URLS['Script'].'System/ResetPassword/Step2MSG/?error=0');
		exit;
		}
		
	} catch (XVwebException $e) {
		header("location: ".$URLS['Script'].'System/ResetPassword/Step2MSG/?error='.$e->getCode());
		exit;
	}
	if($XVwebEngine->Plugins()->Menager()->event("lostpassword.secondstep")) eval($XVwebEngine->Plugins()->Menager()->event("lostpassword.secondstep")); 
	exit;
}


?>