<?php
if(xv_perm("xv_view_logs")){
	if(!isset($admin_menu['logs'])){
		$admin_menu['logs'] = array(
				"name" => "Logs",
			);
	}
	$admin_menu['logs']['submenu'][] = array ("name"=> "System Logs", "href"=>'Administration/Logs/');
}
?>