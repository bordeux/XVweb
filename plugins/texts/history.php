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
xv_load_lang('texts');
$xv_page_url = substr($URLS['PathInfo'], strlen("/history"));
include_once(dirname(__FILE__)."/libs/texts.class.php");
$xv_texts = &$XVwebEngine->load_class("xv_texts");
$xv_texts_versions = xvp()->get_all_versions($xv_texts, $xv_page_url);
if(empty($xv_texts_versions)){
		header("location: ".$URLS['Script'].'Page/System/404/');
		exit;
}
if(isset($_POST['texts']['version'])){
	if(!xv_perm("texts_set_version")){
		header("location: ".$URLS['Script'].'Page/System/Permissions/texts_set_version/');
		exit;
	}
	xvp()->set_version($xv_texts, $xv_page_url, $_POST['texts']['version']);
	header("location: ?");
	exit;
}

$Smarty->assignByRef('xv_texts_versions', $xv_texts_versions);
$Smarty->assignByRef('xv_texts_page', $xv_page_url);

$Smarty->display('texts/history_index.tpl');

?>