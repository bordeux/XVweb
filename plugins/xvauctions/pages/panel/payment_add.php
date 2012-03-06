<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');

$Smarty->assign('Title',  "Doładowanie konta");


$selected_payment_method = strtolower($XVwebEngine->GetFromURL($PathInfo, 3));
if(empty($selected_payment_method)){
if(!xvPerm("xva_payments")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_payments/');
	exit;
}
	$Smarty->assign('payments_mode', "select_method");
	include_once(ROOT_DIR.'plugins/xvauctions/payments/payments.class.php');
	foreach (glob(ROOT_DIR.'plugins/xvauctions/payments/*.payments.class.php') as $filename) {
		include_once($filename);
	}
	$payments_list = xvp()->get_classes_by_prefix($XVwebEngine, "xv_payments_method_");
	$payments = array();
	$payments_buttons = array();
	foreach($payments_list as $payment_method){
		$payments[$payment_method] = new $payment_method($XVwebEngine);
		$payment_tmp_button = xvp()->button($payments[$payment_method]);
		if(!is_null($payment_tmp_button))
		$payments_buttons[] = $payment_tmp_button;
	}

	$Smarty->assignByRef('payments_buttons', $payments_buttons);
}else{
	$selected_payment_method = str_replace(array(".", "/", "\\"), '', $selected_payment_method);
	include_once(ROOT_DIR.'plugins/xvauctions/payments/payments.class.php');
	if (file_exists(ROOT_DIR.'plugins/xvauctions/payments/'.$selected_payment_method.'.payments.class.php')) {
		include_once(ROOT_DIR.'plugins/xvauctions/payments/'.$selected_payment_method.'.payments.class.php');
	}
	$payments_list = xvp()->get_classes_by_prefix( $XVwebEngine, "xv_payments_method_");
	if(!isset($payments_list[0])){
		header("location: ".$URLS['AuctionPanel'].'/payment_add/');
		exit;
	}
	$payment_class = $payments_list[0];
	$payment_class = new $payment_class($XVwebEngine);
	
	$selected_payment_method2 = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if($selected_payment_method2 == "form"){
		if(!xvPerm("xva_payments")){
			header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_payments/');
			exit;
		}
		$payments_form = xvp()->form($payment_class);
		$Smarty->assign('payments_mode', "form");
		$Smarty->assignByRef('payments_form', $payments_form);

		
	}elseif($selected_payment_method2 == "worker"){
		$payments_worker = xvp()->worker($payment_class);
	}
}
//$Smarty->assignByRef('pager', $pager);
//$Smarty->assignByRef('payments_list', $payments_list[0] );

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>