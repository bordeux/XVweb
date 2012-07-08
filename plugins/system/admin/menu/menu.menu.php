<?php
if(xv_perm("xv_menu_edit")){
	if(!isset($admin_menu['menu'])){
		$admin_menu['menu'] = array(
				"name" => "Menu",
			);
	}

	$admin_menu['menu']['submenu'][] = array ("name"=> "Visual editor", "href"=>'Administration/Menu/Visual/');
	$admin_menu['menu']['submenu'][] = array ("name"=> "Text editor", "href"=>'Administration/Menu/Text/');
}
?>