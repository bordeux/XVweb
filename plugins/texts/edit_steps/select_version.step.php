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
$Smarty->assign('xv_texts_step', 'select_version');

if(isset($_POST['texts']['page'])){
	if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'edit/');
		exit;
	}
	
	$xv_texts_index = xvp()->get_texts_index($xv_texts,  $_POST['texts']['page']);
	
	if(empty($xv_texts_index) || ($xv_texts_index['Blocked'] && !xv_perm("texts_block_page"))){
		header('Location: '.$URLS['Script'].'Page/Texts/Blocked/');
		exit;
	}
	$XVwebEngine->Session->Session('xv_texts_page', $_POST['texts']['page']);
	header('Location: '.$URLS['Script'].'edit/select_version/');
	exit;
}

if($XVwebEngine->Session->Session('xv_texts_page') == ''){
	header('Location: '.$URLS['Script'].'edit/');
	exit;
}
$xv_texts_versions = xvp()->get_all_versions($xv_texts, $XVwebEngine->Session->Session('xv_texts_page'));
$Smarty->assign('xv_texts_page', $XVwebEngine->Session->Session('xv_texts_page'));
$Smarty->assign('xv_texts_versions', $xv_texts_versions);


?>