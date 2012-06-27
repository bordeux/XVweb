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
$Smarty->assign('xv_texts_step', 'set_title');

if(isset($_POST['texts']['category'])){
	if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'write/');
		exit;
	}
	
	$xv_texts_index = xvp()->get_texts_index($xv_texts,  $_POST['texts']['category']);
	if(($_POST['texts']['category'] != "/" && (empty($xv_texts_index) || ($xv_texts_index['Blocked'] && !xv_perm("texts_block_page"))))){
		header('Location: '.$URLS['Script'].'Page/Texts/Blocked/');
		exit;
	}
	$XVwebEngine->Session->Session('xv_texts_category', $_POST['texts']['category']);
	header('Location: '.$URLS['Script'].'write/set_title/');
	exit;
}

if($XVwebEngine->Session->Session('xv_texts_category') == ''){
	header('Location: '.$URLS['Script'].'write/');
	exit;
}
$Smarty->assign('xv_texts_category', $XVwebEngine->Session->Session('xv_texts_category'));


?>