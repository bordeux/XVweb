<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_Buy")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_sell/');
	exit;
}

$Smarty->assign('Title',  ("Dane kontrahenta"));

include_once($GLOBALS['XVwebDir'].'libraries/arrays/countries.php');
$user_name = ($XVwebEngine->GetFromURL($PathInfo, 3));

$check_perm = xvp()->check_perm_to_user_data($XVauctions, $XVwebEngine->Session->Session('Logged_User'), $user_name);

if(!$check_perm){
	header("location: ".$URLS['Script'].'System/Auctions/You_dont_have_perm_to_this/');
	exit;
}

$user_data  = xvp()->get_user_data($XVauctions, $user_name);
if(empty($user_data)){
	header("location: ".$URLS['Script'].'System/Auctions/No_exsist_user/');
	exit;
}


$Smarty->assign('user_data', $user_data );

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>