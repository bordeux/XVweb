<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
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
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
$xv_texts_actual_category = '/';
if($XVwebEngine->Session->Session('xv_texts_category') != ''){
	$xv_texts_actual_category = htmlspecialchars($XVwebEngine->Session->Session('xv_texts_category'));
}
if(isset($_GET['cat']) && !empty($_GET['cat'])){
	$xv_texts_actual_category = htmlspecialchars($_GET['cat']);
}

$Smarty->assign('xv_texts_actual_category', $xv_texts_actual_category);
$Smarty->assign('xv_texts_step', 'select_category');

?>