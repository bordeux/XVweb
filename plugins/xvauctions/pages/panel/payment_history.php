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
$Smarty->assign('Title',  xv_lang("xca_payments_transaction_history"));

include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
	

$queries_search = array();
$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		"by_seller"=>true,
	);
$record_limit = 30;

$payments_list = xvp()->get_payments(xvp()->load_class($XVwebEngine, "xvpayments"), $XVwebEngine->Session->Session('user_name'), $display_options, (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $payments_list[1],  "?".$XVwebEngine->add_get_var(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('payments_list', $payments_list[0] );

$Smarty->display('xvauctions/panel_show.tpl');

?>