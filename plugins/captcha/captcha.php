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
$captcha_type = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
$captcha_type = str_replace(".", '', $captcha_type);
$captcha_file_location = dirname(__FILE__).'/pages/'.$captcha_type.'.captcha.php';
if(file_exists($captcha_file_location)){
	include($captcha_file_location);
}else{
	header("Location: ".$URLS['Script'].'Page/System/404/');
	exit;
}

?>