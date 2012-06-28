<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   messages.php      *************************
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
if(!xv_perm("texts_view_page")){
	header("location: ".$URLS['Script'].'Page/System/Permissions/texts_view_page/');
	exit;
}
xv_load_lang('texts');
$xv_redirect_404 = false;
include_once(dirname(__FILE__)."/libs/texts.class.php");
$xv_texts = &$XVwebEngine->load_class("xv_texts");

$xv_texts_page = xvp()->get_page($xv_texts, $URLS['PathInfo'], (isset($_GET['date']) ? $_GET['date'] : null));
if(empty($xv_texts_page)){
	$xv_redirect_404 = true;
	return true;
}
if(isset($_GET['edit'])){
	header("location: ".$URLS['Script'].'edit/?page='.urlencode($URLS['PathInfo']));
	exit;
}
$xv_texts_categories = xvp()->get_categories($xv_texts, $xv_texts_page['URL']);

$Smarty->assignByRef('xv_texts_categories', $xv_texts_categories);
$Smarty->assignByRef('xv_texts_page', $xv_texts_page);

$Smarty->display('texts/texts_index.tpl');

?>