<?php

class xv_users_modules_xvauctions_auctions extends xv_users_modules {
	var $plg_author = "xvAuctions";
	var $plg_title = "xvAuctions Auctions";
	var $plg_webiste = "http://xvauctions.pl/";
	var $plg_description = "Show auctions";
	
	public function widget(){
	global $LocationXVWeb, $XVwebEngine, $URLS, $user_data;
	include_once(ROOT_DIR.'plugins/xvauctions/includes/functions.xvauctions.php');
	include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
	$XVauctions = &$XVwebEngine->InitClass("xvauctions");
	include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');


	$record_limit = 30;

	$comments_list = xvp()->get_comments($XVauctions, $XVwebEngine->Session->Session('Logged_User'), array("type"=> ifsetor($_GET['xva_c_type'], "")), (int) $_GET['xva_comments'], $record_limit);
	$comments_pager = pager($record_limit, (int) $comments_list[1],  "?".$XVwebEngine->AddGet(array("xva_comments"=>"-npage-id-"), true), (int) $_GET['xva_comments']);

//var_dump($comments_list);
	$result = '';
	$result .=
	'<div class="xv-xvauction-comments">
		<div class="xv-user-seperate"><span>Aukcje użytkownika  </span></div>
		

		'.$comments_pager[1].'
	</div>';
	
	
		xv_append_header("
		<style type='text/css' media='all'>

		</style>");
		return $result;
	}
}