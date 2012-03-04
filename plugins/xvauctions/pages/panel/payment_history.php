<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xvPerm("xva_payments")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_payments/');
	exit;
}
$Smarty->assign('Title',  xvLang("xca_payments_transaction_history"));

include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
	

$queries_search = array();
$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		"by_seller"=>true,
	);
$record_limit = 30;

$payments_list = xvp()->get_payments(xvp()->InitClass($XVwebEngine, "xvpayments"), $XVwebEngine->Session->Session('Logged_User'), $display_options, (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $payments_list[1],  "?".$XVwebEngine->AddGet(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('payments_list', $payments_list[0] );

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>