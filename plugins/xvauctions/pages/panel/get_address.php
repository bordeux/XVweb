<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_buy")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Sell/');
	exit;
}

$Smarty->assign('Title',  ("Dane kontrahenta"));

include_once(ROOT_DIR.'core/libraries/arrays/countries.php');
$user_name = ($XVwebEngine->GetFromURL($PathInfo, 3));

$check_perm = xvp()->check_perm_to_user_data($XVauctions, $XVwebEngine->Session->Session('user_name'), $user_name);

if(!$check_perm){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/User_data/');
	exit;
}

$user_data  = xvp()->get_user_data($XVauctions, $user_name);
if(empty($user_data)){
	header("location: ".$URLS['Script'].'Page/xvAuctions/User_404/');
	exit;
}
foreach($user_data as &$val){
	$val = htmlspecialchars($val);
}

$Smarty->assign('user_data', $user_data );

$Smarty->display('xvauctions/panel_show.tpl');

?>