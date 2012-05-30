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
		Pe³na dokumentacja znajduje siê na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
include_once(dirname(__FILE__).'/../wav_generator/captcha_wav.php');
header('Content-type: audio/x-wav');
header('Content-Disposition: attachment; name="CaptchaCode'.gmdate('DdMYHis').'.wav"');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Expires: Sun, 1 Jan 2000 12:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
generate_wav($XVwebEngine->Session->Session('captcha_key'));
exit;


?>