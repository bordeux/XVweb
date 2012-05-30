<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_buy") || !xv_perm("xva_sell")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Buy/');
	exit;
}
$Smarty->assign('Title',  "Otrzymane komentarze");

$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
	);
$record_limit = 30;

$comments_list = xvp()->get_comments($XVauctions, $XVwebEngine->Session->Session('user_name'), $display_options, (int) $_GET['page'], $record_limit);

$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $comments_list[1],  "?".$XVwebEngine->add_get_var(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('comments_list', $comments_list[0] );


$Smarty->display('xvauctions/panel_show.tpl');

?>