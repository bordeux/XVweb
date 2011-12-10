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
$Command = $XVwebEngine->GetFromURL($PathInfo, 2);

switch(strtolower($Command)){
	case "audio" :
		CaptchaWav();
	break;
	default :
		CaptchaImage();
	break;
}
function CaptchaWav(){
	global $XVwebEngine;
	include_once('core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Captcha'.DIRECTORY_SEPARATOR.'CaptchaWav.php');
	header('Content-type: audio/x-wav');
	header('Content-Disposition: attachment; name="CaptchaCode'.gmdate('DdMYHis').'.wav"');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Expires: Sun, 1 Jan 2000 12:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	generateWAV($XVwebEngine->Session->Session('Captcha_code'), 'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Captcha'.DIRECTORY_SEPARATOR.'audio'.DIRECTORY_SEPARATOR);
	exit;
}

function CaptchaImage(){
	$GLOBALS['XVwebEngine']->Session->Session('Captcha_code', $GLOBALS['XVwebEngine']->GeneratePassword());
	include_once('core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Captcha'.DIRECTORY_SEPARATOR.'CaptchaImage.php');
	GetCaptchaImage($GLOBALS['XVwebEngine']->Session->Session('Captcha_code'), 30, 90);
exit;
}



?>