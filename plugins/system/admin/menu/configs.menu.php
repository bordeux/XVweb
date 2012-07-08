<?php
if(xv_perm("xv_edit_configs"))
	$admin_menu['system']['submenu'][] = array ("name"=> "Configs", "href"=>'Administration/System/Config/');

?>