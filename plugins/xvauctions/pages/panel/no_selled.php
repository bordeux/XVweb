<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xvPerm("xva_Sell")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_sell/');
	exit;
}

if(isset($_POST['auction']) && is_array($_POST['auction']) && isset($_POST['hidde']))
	xvp()->set_hidden_no_selled($XVauctions, $XVwebEngine->Session->Session('Logged_User'), $_POST['auction']);
	
$Smarty->assign('Title',  xvLang("xca_no_selled"));

$queries_search = array();
$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		"by_seller"=>true,
		
	);
$record_limit = 30;

$no_selled_list = xvp()->get_no_selled($XVauctions, $XVwebEngine->Session->Session('Logged_User'), $display_options, (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $no_selled_list[1],  "?".$XVwebEngine->AddGet(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('no_selled_list', $no_selled_list[0] );

$Smarty->display('xvauctions_theme/panel_show.tpl');

?>