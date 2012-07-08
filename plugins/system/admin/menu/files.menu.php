<?php

if(xv_perm("xv_ftp_online")){
	if(!isset($admin_menu['media'])){
		$admin_menu['media'] = array(
				"name" => "Media"
			);
	}
	$admin_menu['media']['submenu'][] = array ("name"=> "FTP online", "href"=>'Administration/Files/');
}
?>