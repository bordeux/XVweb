<?php

class xv_users_modules_xvauctions_comments extends xv_users_modules {
	var $plg_author = "xvAuctions";
	var $plg_title = "xvAuctions Comments";
	var $plg_webiste = "http://xvauctions.pl/";
	var $plg_description = "Show auction comments";
	
	public function widget(){
	global $LocationXVWeb, $XVwebEngine, $URLS, $user_data;
	include_once(ROOT_DIR.'plugins/xvauctions/includes/functions.xvauctions.php');
	include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
	$XVauctions = &$XVwebEngine->load_class("xvauctions");
	include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');


	$record_limit = 30;

	$comments_list = xvp()->get_comments($XVauctions, $user_data->User, array("type"=> ifsetor($_GET['xva_c_type'], "")), (int) $_GET['xva_comments'], $record_limit);
	$comments_pager = pager($record_limit, (int) $comments_list[1],  "?".$XVwebEngine->add_get_var(array("xva_comments"=>"-npage-id-"), true), (int) $_GET['xva_comments']);

//var_dump($comments_list);
	$result = '';
	$result .=
	'<div class="xv-xvauction-comments">
		<div class="xv-user-seperate"><span> Komentarze xvAuctions </span></div>
		<div class="xv-xvauction-legends">
			 <a href="?'.$XVwebEngine->add_get_var(array("xva_c_type"=>null), true).'"><span class="xv-xvauction-legend xv-xvauction-legend-all"></span> Wszystkie</a>
			 <a href="?'.$XVwebEngine->add_get_var(array("xva_c_type"=>"positive"), true).'"><span class="xv-xvauction-legend xv-xvauction-legend-positive"></span> Pozytywne</a>
			 <a href="?'.$XVwebEngine->add_get_var(array("xva_c_type"=>"neutral"), true).'"><span class="xv-xvauction-legend xv-xvauction-legend-neutral"></span> Neutralne</a>
			 <a href="?'.$XVwebEngine->add_get_var(array("xva_c_type"=>"negative"), true).'"><span class="xv-xvauction-legend xv-xvauction-legend-negative"></span> Negatywne</a>
		</div>
		<div class="xv-xvauction-comments-list">';
		if(empty($comments_list[0])){
		$result .=
				'<div style="background: #F3FFCD; border: 1px solid #B1DA81; color: #4B5D40; text-align:center; padding: 20px; ">
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">Obecnie nie ma nic do wyświetlenia.</h2>
				</div>';
		}else{
			foreach($comments_list[0] as $key=>$comment){
			$author_comment = $comment['Seller'];
			if($user_data->User == $author_comment){
				$author_comment = $comment['Buyer'];
			}
			$result .=
				'<div class="xv-xvauction-comments-opinion xv-xvauction-comments-otype-'.$comment['Type'].'">
					<span>'.htmlspecialchars($comment['Opinion']).'</span>
					<div class="xv-xvauction-comments-details">Data : '.$comment['Date'].', Aukcja nr <a href="'.$URLS['Script'].'auction/'.$comment['Auction'].'/">'.$comment['Auction'].'</a>, Użytkownik <a href="'.$URLS['Script'].'Users/'.$author_comment.'/">'.$author_comment.'</a></div>
				</div>';
			}
		}
	$result .=
		'</div>
		'.$comments_pager[1].'
	</div>';
	
	
		xv_append_header("
		<style type='text/css' media='all'>
		.xv-xvauction-comments {
			margin-top: 20px;
		}
		.xv-xvauction-comments-opinion {
			margin-top: 15px;
			background: #F2F7FA;
			padding: 5px;
			padding-left: 25px;
			padding-right: 25px;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			border: 1px solid #AED0EA;
		}
		.xv-xvauction-comments-details {
			font-size: 10px;
			color : #707070;
			float:right;
		}
		.xv-xvauction-comments .xv-xvauction-comments-otype-negative {
			background: #FFBABA;
			border-color: #D8000C;
		}	
		.xv-xvauction-comments .xv-xvauction-comments-otype-neutral {
			background: #FEEFB3;
			border-color: #9F6000;
		}	
		.xv-xvauction-comments .xv-xvauction-comments-otype-positive{
			background: #DFF2BF;
			border-color: #4F8A10;
		}
		.xv-xvauction-legend {
			height: 12px;
			width:12px;
			display: block;
			float:left;
			margin-right: 5px;
			margin-top: 2px;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		}
		.xv-xvauction-legend-positive {
			background: #DFF2BF;
			border: 1px solid #4F8A10;
		}		
		.xv-xvauction-legend-negative {
			background: #FFBABA;
			border: 1px solid #D8000C;
		}		
		.xv-xvauction-legend-neutral {
			background: #FEEFB3;
			border: 1px solid #9F6000;
		}	
		.xv-xvauction-legend-all {
			background: #FFF;
			border: 1px solid #9F6000;
		}
		.xv-xvauction-legends {
			height:30px;
		}
		.xv-xvauction-legends a {
			display:block;
			float:left;
			padding: 5px;
		}
		</style>");
		return $result;
	}
}