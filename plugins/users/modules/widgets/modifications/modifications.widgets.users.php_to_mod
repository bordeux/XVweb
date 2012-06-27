<?php
class xv_users_modules_modifications  extends xv_users_modules {
	public function widget(){
	global $LocationXVWeb, $XVwebEngine, $URLS, $user_data;
	include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
	
	$modifications_list = $XVwebEngine->module("user_info")->get_modifications($user_data->User, (int) $_GET['mod_pager']);
	$modifications_count = $XVwebEngine->module("user_info")->get_last_count_records();
	$modifications_pager =  pager(30, (int) $modifications_count,  "?".$XVwebEngine->add_get_var(array("mod_pager"=>"-npage-id-"), true), (int) $_GET['mod_pager']);
		xv_append_header("
		<style type='text/css' media='all'>

		.xv-user-texts-list > div {
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

		.xv-user-texts-list > div a {
			font-size: 18px;
			line-height: 18px;
		}
		.xv-user-texts-list > div > div {
			font-size: 10px;
			color : #707070;
			float:right;
		}
		</style>");
		
	$result = '';
	$result .=
	'<div class="xv-user-texts">
		<div class="xv-user-seperate"><span> Modyfikacje </span></div>
		<div class="xv-user-texts-list">';
		foreach($modifications_list as $key=>$modification){
		$result .=
			'<div>
				<a href="'.$URLS['Script'].substr($XVwebEngine->URLRepair(str_replace(' ', '_', $modification['index_url'])), 1).'" >
					'.$modification['index_title'].'
				</a>
				<div>Data : '.$modification['text_date'].', wyświetleń: '.$modification['index_views'].'</div>
			</div>';
		}
	$result .=
		'</div>
		'.$modifications_pager[1].'
	</div>';
		return $result;
	}
}