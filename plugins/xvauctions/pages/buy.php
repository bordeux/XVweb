<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

$auction_id =  strtolower($XVwebEngine->GetFromURL($PathInfo, 2));

$auction_info = xvp()->get_auction($XVauctions, $auction_id, true);
if(empty($auction_info)){
	header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
	exit;
}
if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
	header("location: ".$URLS['Script'].'Page/xvAuctions/SID_error/');
	exit;
}
if(!xv_perm("xva_buy")){
	$XVwebEngine->Session->Session("login_redirect", $URLS['Auction'].'/'.$auction_id.'/');
	header("location: ".$URLS['Script'].'Login/');
	exit;
}
$user_data = xvp()->get_user_data($XVauctions, $XVwebEngine->Session->Session('user_name'));
if(empty($user_data)){
	header("location: ".$URLS['Script'].'Users/'.$XVwebEngine->Session->Session('user_name').'/edit/?xva_set_data=true#xvauction-user-data');
	exit;
}
$buy_pieces = 1;

if(isset($_POST['pieces']) && is_numeric($_POST['pieces']) && $_POST['pieces'] > 0 )
$buy_pieces = $_POST['pieces'];


if(in_array($auction_info['Type'], array("buynow", "both", "dutch")) && ifsetor($_POST['type'], '') == "buynow"){
	$auction_selled = 0;
	$Smarty->assign('buy_type', "buy_now");
	$auction_offers = xvp()->get_offers($XVauctions, $auction_info['ID']);
	$count_auctions = count($auction_offers);
	foreach($auction_offers as $offer){
		if($offer['Type'] == "buynow")
		$auction_selled += $offer['Pieces'];
	}
	if( $auction_selled  >=  $auction_info['Pieces']){
		xvp()->end_auction($XVauctions,$auction_info['ID']);
		header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
		exit;
	}
	if( ($auction_selled + $buy_pieces ) >  $auction_info['Pieces']){
		header("location: ".$URLS['Script'].'Page/xvAuctions/To_many_pieces/');
		exit;
	}
	$to_pay = $auction_info['BuyNow']; // tutaj zmiana jak licytacja
	if(isset($_POST['confirm_buy']) && $_POST['confirm_buy'] == "1"){
		if(!xv_perm("xva_buy")){
			header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Buy/');
			exit;
		}
		xvp()->create_offer($XVauctions, $auction_info['ID'], $XVwebEngine->Session->Session('user_name'), "buynow" , $to_pay, $buy_pieces);
		$bought_id = xvp()->create_bought($XVauctions, $auction_info['ID'], $XVwebEngine->Session->Session('user_name'), $auction_info['Seller'], $auction_info['Type'], $to_pay, $buy_pieces, $auction_info['Title'], $auction_info['Thumbnail']);
		
		xvp()->edit_auction($XVauctions, $auction_info['ID'], array(
			"AuctionsCount" => $count_auctions+1,
		));
		//$XVwebEngine->Plugins()->Menager()->trigger("onPreAssing");
		if( ($auction_selled + $buy_pieces ) >=  $auction_info['Pieces']){
			xvp()->end_auction($XVauctions, $auction_info['ID']);
		}
		$auction_message = xvp()->get_auction_description($XVauctions, $auction_info['ID'], "message");
		
		$Smarty->assign('bought_id', $bought_id);
		$Smarty->assign('buy_done', true);
		$Smarty->assignByRef('buy_message', $auction_message);
	}
}elseif(in_array($auction_info['Type'], array("auction", "both")) && ifsetor($_POST['type'], '') == "auction"){

	$Smarty->assign('buy_type', "auction");

	$to_pay = floatval(number_format(floatval($_POST['offer']), 2, '.', ''));
	$buy_pieces = 1;
	$actual_cost = floatval($auction_info['Auction']);

	if($actual_cost > $to_pay){
		header("location: ".$URLS['Script'].'Page/xvAuctions/Min_cost/?cost='.$actual_cost.'&auction='.$auction_info['ID']);
		exit;
	}

	if(isset($_POST['confirm_buy']) && $_POST['confirm_buy'] == "1"){
		if(!xv_perm("xva_buy")){
			header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Buy/');
			exit;
		}
		$auction_offers = xvp()->get_offers($XVauctions, $auction_info['ID']);
		$count_auctions = count($auction_offers);
		xvp()->create_offer($XVauctions, $auction_info['ID'], $XVwebEngine->Session->Session('user_name'), "auction" , $to_pay, $buy_pieces);
		$to_update = array(
			"Auction" => $to_pay,
			"AuctionsCount" => $count_auctions+1,
		);
		if($auction_info['Type'] = "auction"){
			$to_update["BuyNow"] = $to_pay;
		}
		
		xvp()->edit_auction($XVauctions, $auction_info['ID'], $to_update);
		$Smarty->assign('buy_done', true);
	}

}elseif(in_array($auction_info['Type'], array("errand")) && ifsetor($_POST['type'], '') == "errand"){

	$Smarty->assign('buy_type', "errand");

	$to_pay = floatval(number_format(floatval($_POST['offer']), 2, '.', ''));
	$buy_pieces = 1;
	$actual_cost = floatval($auction_info['Auction']);
	$update_auction = false;
	if($actual_cost > $to_pay){
		$update_auction = true;
	}

	if(isset($_POST['confirm_buy']) && $_POST['confirm_buy'] == "1"){
		if(!xv_perm("xva_buy")){
			header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Buy/');
			exit;
		}
		$auction_offers = xvp()->get_offers($XVauctions, $auction_info['ID']);
		$count_auctions = count($auction_offers);
		xvp()->create_offer($XVauctions, $auction_info['ID'], $XVwebEngine->Session->Session('user_name'), "errand" , $to_pay, $buy_pieces);
		$to_update = array(
			"AuctionsCount" => $count_auctions+1,
		);
		if($update_auction){
			$to_update['Auction'] = $to_pay;
			$to_update["BuyNow"] = $to_pay;
			
		}
		
		xvp()->edit_auction($XVauctions, $auction_info['ID'], $to_update);
		$Smarty->assign('buy_done', true);
	}

}else{
	$buy_pieces = 1;
	exit("error");
}
$Smarty->assignByRef('buy_pieces', $buy_pieces);
$Smarty->assign('buy_sum', ($to_pay*$buy_pieces));
$Smarty->assignByRef('buy_cost', $to_pay);
$Smarty->assignByRef('auction_info', $auction_info);
$Smarty->display('xvauctions/buy_show.tpl');


?>