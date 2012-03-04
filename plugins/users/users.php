<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
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
}

$UserFromUrl = $XVwebEngine->GetFromURL($PathInfo, 2);
$Command = $XVwebEngine->GetFromURL($PathInfo, 3);

if(empty($UserFromUrl)){
	include(dirname(__FILE__).'/list.php');
}else{
	include(dirname(__FILE__).'/profile.php');
}
?>