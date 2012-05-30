<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_sell")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Sell/');
	exit;
}

$Smarty->assign('Title',  xv_lang("xca_finish_auction"));

$auction_id = strtolower($XVwebEngine->GetFromURL($PathInfo, 3));

if(!is_numeric($auction_id)){
	header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
	exit;
}
$auction_info = xvp()->get_auction($XVauctions, $auction_id, true);

if(empty($auction_info)){
	header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
	exit;
}

if($auction_info['Seller'] != $XVwebEngine->Session->Session('user_name')){
	header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
	exit;
}

$Smarty->assign('finished', false);
if(ifsetor($_POST['finish'], '') == "true"){
	if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'Page/xvAuctions/SID_Error/');
		exit;
	}
	
	xvp()->end_auction($XVauctions, $auction_info['ID']);
	$Smarty->assign('finished', true);
}

$Smarty->assignByRef('auction_info', $auction_info);

$Smarty->display('xvauctions/panel_show.tpl');

?>