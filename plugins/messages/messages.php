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
if(!xv_perm("xv_msg_access")){
	$XVwebEngine->Session->Session("login_redirect", $URLS['Site'].substr($_SERVER['REQUEST_URI'], 1));
	header("location: ".$URLS['Script'].'Login/');
	exit;
}
include_once(dirname(__FILE__)."/libs/class.messages.php");

$xv_messages = &$XVwebEngine->load_class("xv_messages");
$xv_address_book = xvp()->get_address_book($xv_messages ,$XVwebEngine->Session->Session('user_name'));
$Smarty->assignByRef('xv_address_book', $xv_address_book);

$xv_receiver = htmlspecialchars(($XVwebEngine->GetFromURL($PathInfo, 2)));
if(!empty($xv_receiver)){
	$xv_messages_list = xvp()->get_messages_history($xv_messages ,$XVwebEngine->Session->Session('user_name'), $xv_receiver);
	$Smarty->assignByRef('xv_messages_list', $xv_messages_list);
	$Smarty->assignByRef('xv_receiver', $xv_receiver);
}
$Smarty->display('messages/index.tpl');
?>