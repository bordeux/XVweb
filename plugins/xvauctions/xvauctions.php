<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}
include_once(dirname(__FILE__).'/libs/class.xvauctions.php');
$XVauctions = &$XVwebEngine->InitClass("xvauctions");
$auction_prefix = strtolower($XVwebEngine->GetFromURL($PathInfo, 1));

//xvp()->load_plugin('sms_notification');
xvp()->load_plugin('email_notification');


LoadLang('xvauctions');

$URLS['Auctions'] = $URLS['Script']."auctions";
$URLS['AuctionsAdd'] = $URLS['Script']."auction_add";
$URLS['Auction'] = $URLS['Script']."auction";
$URLS['AuctionBuy'] = $URLS['Script']."buy";
$URLS['AuctionPanel'] = $URLS['Script']."auction_panel"; //array(pay, bought)

$URLS['Thumbnails'] = $URLS['Site']."plugins/xvauctions/th";

switch ($auction_prefix) {
	case "auctions":
	case "a":
		include_once(dirname(__FILE__).'/pages/auctions.php');
		break;
	case "auction_add":
		include_once(dirname(__FILE__).'/pages/add.php');
		break;
	case "auction":
		include_once(dirname(__FILE__).'/pages/auction.php');
	break;
	case "buy":
		include_once(dirname(__FILE__).'/pages/buy.php');
	break;
	case "auction_panel":
	case "panel":
		include_once(dirname(__FILE__).'/pages/panel.php');
	break;	
	case "xvauctions_cron":
		include_once(dirname(__FILE__).'/pages/cron.php');
	break;	
	case "auction_index":
		include_once(dirname(__FILE__).'/pages/index_page.php');
	break;
}

?>