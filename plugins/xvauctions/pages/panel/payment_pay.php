<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_payments")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_payments/');
	exit;
}
$Smarty->assign('Title',  ("Kasa płatności"));

$bought_id = strtolower($XVwebEngine->GetFromURL($PathInfo, 3));
if(!is_numeric($bought_id)){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_commented/');
	exit;
}
$bought_info = xvp()->get_bought_item($XVauctions, $bought_id);

if(empty($bought_info)){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_not_found/');
	exit;
}

if(($bought_info['User'] != $XVwebEngine->Session->Session('Logged_User'))){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_payments/');
	exit;
}

$Smarty->assign('bought_info', $bought_info);

$fields = xvp()->get_fields($XVauctions, '/');

	foreach($fields as $key => $val){
		if($val['Name'] != 'shipment'){
			unset($fields[$key]);
		}
	};
	
$fields = end($fields);
$field_val = xvp()->get_field_value($XVauctions, $fields['ID'], $bought_info['Auction']);
$field_val = unserialize($field_val);
$shipment_methods = array();
$shipment_available_methods = array();
foreach(explode("\n", $fields['FieldOptions']['methods']) as $val){
	$shipment_methods[] = $val;
}

if(is_array($field_val)){

	foreach($field_val as $key=>$val){
		if(isset($shipment_methods[$key])){
				$shipment_available_methods[$key] = array("key"=> $key, "name" => trim($shipment_methods[$key]), "cost" => $val[0]/100, "pieces"=>$val[1]/100);
		
		}
	}

}
if(ifsetor($_GET['pay'], "false") == "true"){
	if($XVwebEngine->Session->GetSID() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'System/Auctions/Bad_SID/');
		exit;
	}

	$selected_method = ifsetor($shipment_available_methods[ifsetor($_POST['shipment_method'], '')], '');
	if(empty($selected_method)){
		header('Location: ?');
		exit;
	}
	include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');

	$to_pay_auction =  ($bought_info['Cost']* $bought_info['Pieces']);
	
	$to_pay_shipment = $selected_method['cost'];
	$to_pay_shipment += ($bought_info['Pieces']-1)*$selected_method['pieces'];
	
	$to_pay = $to_pay_auction+$to_pay_shipment;
	
	$user_amount = xvp()->get_user_amount(xvp()->InitClass($XVwebEngine, "xvpayments"), $XVwebEngine->Session->Session('Logged_User'));
	
	if($user_amount < ($to_pay*100)){
		header('Location: ?error=amount');
		exit;
	}
	$logged_user = $XVwebEngine->Session->Session('Logged_User');
	$trans_id = xvp()->add_transaction(xvp()->InitClass($XVwebEngine,"xvpayments"), $logged_user, ($to_pay * (-100)) , "bought", "Zapłata za przedmiot od ".htmlspecialchars($logged_user) , array(
			"user" => $logged_user,
			"shipment" => $selected_method,
			"shipment_cost" => $to_pay_shipment*100,
			"cost" => $to_pay_auction*100,
			"bought_info" => $bought_info
		), "bh-".$bought_info['ID'] ,$bought_info['Auction']);	

		xvp()->set_done_boguht($XVauctions, $bought_info['ID'], $trans_id );
		
			header('Location: '.$URLS['AuctionPanel'].'/bought/?paid=true');
			exit;
}

$Smarty->assign('shipment_available_methods', $shipment_available_methods);
$Smarty->assign('amount_commission', $amount_commission);

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>