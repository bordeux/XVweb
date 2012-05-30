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
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Buy/');
	exit;
}

$Smarty->assign('Title',  xv_lang("xca_bought"));


if(isset($_POST['auction']) && is_array($_POST['auction']) && isset($_POST['hidde']))
	$XVauctions->set_hidden_boguht($XVwebEngine->Session->Session('user_name'), $_POST['auction']);
	
	
$queries_search = array();
$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		
	);
$record_limit = 30;

$boughts_list = xvp()->get_bought($XVauctions, $XVwebEngine->Session->Session('user_name'), $display_options = array(), (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $boughts_list[1],  "?".$XVwebEngine->add_get_var(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('boughts_list', $boughts_list[0] );

$Smarty->display('xvauctions/panel_show.tpl');

?>