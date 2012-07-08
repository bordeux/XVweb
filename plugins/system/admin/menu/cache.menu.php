<?php
if(xv_perm("xv_clear_cache"))
	$admin_menu['system']['submenu'][] = array ("name"=> "Cache", "href"=>'Administration/Cache/');

?>