<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xvPerm("xva_Buy") || !xvPerm("xva_Sell")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_buy/');
	exit;
}

$Smarty->assign('Title',  "Dodawanie komentarza");


$auction_id = strtolower($XVwebEngine->GetFromURL($PathInfo, 3));
if(!is_numeric($auction_id)){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_commented/');
	exit;
}
$bought_info = xvp()->get_bought_item($XVauctions, $auction_id);
if(empty($bought_info)){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_commented/');
	exit;
}
$comment_mode = "none";
if(($bought_info['Seller'] == $XVwebEngine->Session->Session('Logged_User') && $bought_info['CommentedSeller'] == 0)){
	$comment_mode = "seller";
}
if(($bought_info['User'] == $XVwebEngine->Session->Session('Logged_User') && $bought_info['CommentedBuyer'] == 0)){
	$comment_mode = "buyer";
}

if($comment_mode == "none"){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_commented/');
	exit;
}

if(ifsetor($_GET['add'], '') == "true"){
	if($XVwebEngine->Session->GetSID() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'System/Auctions/Bad_SID/');
		exit;
	}
	function valid_rate(&$rate){
		$rate = (int) ifsetor($rate, 5);
		if($rate < 6 && $rate > 0)
			return $rate;
		return 4;
	}
	if($comment_mode == "buyer"){
		$user_add = $bought_info['Seller'];
		xvp()->set_hidden($XVauctions, "{AuctionBought}", "{AuctionBought:CommentedBuyer}", array(
				"user_field" => "1",
				"user" => "1",
				"auctions" => array($bought_info['Auction']),
				"auctions_field" => "{AuctionBought:Auction}",
			));
			
	}else{
		$user_add = $bought_info['User'];
		xvp()->set_hidden($XVauctions, "{AuctionBought}", "{AuctionBought:CommentedSeller}", array(
				"user_field" => "1",
				"user" => "1",
				"auctions" => array($bought_info['Auction']),
				"auctions_field" => "{AuctionBought:Auction}",
			));
	}
	xvp()->create_opinion($XVauctions, $user_add, $bought_info['Auction'], $_POST['comment_type'], htmlspecialchars($_POST['comment']),valid_rate($_POST['compatibility']) , valid_rate($_POST['contact']), valid_rate($_POST['realization']), valid_rate($_POST['shipping']) ,$bought_info['Seller'], $bought_info['User']);
	$Smarty->assign('added_comment', true);
}
$Smarty->assignByRef('comment_mode', $comment_mode);
$Smarty->assignByRef('bought_info', $bought_info);


$Smarty->display('xvauctions_theme/panel_show.tpl');

?>