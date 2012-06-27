<?php
class xv_users_modules_files  extends xv_users_modules {
	public function widget(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data;
		include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		xv_append_header("
		<style  type='text/css' media='all'>
			.xv-user-files-list a {
			display: block;
			line-height: 16px;
			font-size: 15px;
			background: #DEEDF7;
			padding: 10px;
			padding-left: 25px;
			padding-right: 25px;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			float: left;
			border: 1px solid #AED0EA;
			margin: 5px;
			}
		</style>");
		$files_list = $XVwebEngine->module("user_info")->get_files($user_data->User, (int) $_GET['files_pager']);
		$files_count = $XVwebEngine->module("user_info")->get_last_count_records();
		$files_pager = pager(30, (int) $files_count,  "?".$XVwebEngine->add_get_var(array("files_pager"=>"-npage-id-"), true), (int) $_GET['files_pager']);
		

		$result = '';
		$result .=
		'<div class="xv-user-files">
		<div class="xv-user-seperate"><span> '.xv_lang("Files").' </span></div>
			<div class="xv-user-files-list">';
			foreach($files_list as $key=>$file){
			$result .=
				'<a href="'.$URLS['Script'].'File/'.$file['ID'].'/">'.$file['FileName'].'.'.$file['Extension'].'</a>';
			}
		$result .=
			'</div>
			<div style="clear: both;" ></div>
			'.$files_pager[1].'
		</div>';
		return $result;
	}
}