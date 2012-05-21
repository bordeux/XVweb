<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_payments")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Payments/');
	exit;
}

$amount_commission = 0.01;

include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
$Smarty->assign('Title',  xv_lang("xca_payments_transfer"));

$queries_search = array();
$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		"by_seller"=>true,
	);
$record_limit = 30;

$payments_list = xvp()->get_payments(xvp()->InitClass($XVwebEngine,"xvpayments"), $XVwebEngine->Session->Session('Logged_User'), $display_options, (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);
$isset_user = false;
if(isset($_POST['transfer']['user'])){
	if($XVwebEngine->isset_user($_POST['transfer']['user']) && ($_POST['transfer']['user'] != $XVwebEngine->Session->Session('Logged_User'))){
		$isset_user = true;
		$Smarty->assign('isset_user', true);
	}else{
		$Smarty->assign('isset_user', false);
	}
}

if(isset($_POST['transfer']['amount'])){
	$_POST['transfer']['amount'] = preg_replace('/[^0-9\.]/i', '', $_POST['transfer']['amount']); 
}
if(isset($_POST['finish_mode']) && $isset_user == true){
	if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'Page/xvAuctions/SID_Error/');
		exit;
	}
	$user_amount = xvp()->get_user_amount(xvp()->InitClass($XVwebEngine,"xvpayments"), $XVwebEngine->Session->Session('Logged_User'));
	
	if($user_amount >= (($_POST['transfer']['amount'])*(100))){
		xvp()->add_transaction(xvp()->InitClass($XVwebEngine,"xvpayments"),$XVwebEngine->Session->Session('Logged_User'), ($_POST['transfer']['amount'])*(-100) , "transfer_to", "Przelew dla użytkownika ".$_POST['transfer']['user'] , array(
			"to_user" => $_POST['transfer']['user'],
			"amount_commission" => $amount_commission
		));	
		
		xvp()->add_transaction(xvp()->InitClass($XVwebEngine,"xvpayments"), $_POST['transfer']['user'], floor(($_POST['transfer']['amount'])*100*(1-$amount_commission)) , "transfer_from", "Przelew od użytkownika ".$XVwebEngine->Session->Session('Logged_User'), array(
			"from_user" => $XVwebEngine->Session->Session('Logged_User'),
			"amount_commission" => $amount_commission
		));
		$Smarty->assign('send_mode', true);
	}else{
		$Smarty->assign('send_mode', false);
	}
}
$Smarty->assign('amount_commission', $amount_commission);

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>