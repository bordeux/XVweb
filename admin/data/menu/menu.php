<?php
$admin_menu['main'] = array(
		"name" => "Strona główna",
		"href" => $URLS['Site']
	);
	
$admin_menu['system'] = array(
		"name" => "System",
		"submenu" =>
			array(
				array ("name"=> "Language", "href"=>'Administration/Lang/'),
				array ("name"=> "Cache", "href"=>'Administration/Cache/'),
				array ("name"=> "Plugins", "href"=>'Administration/Plugins/'),
			)
	);
	
$admin_menu['articles'] = array(
		"name" => "Articles",
		"submenu" =>
			array(
				array ("name"=> "List articles", "href"=>'Administration/Articles/'),
				array ("name"=> "Comments", "href"=>'Administration/Articles/Comments/'),
			)
	);

$admin_menu['menu'] = array(
		"name" => "Menu",
		"submenu" =>
			array(
				array ("name"=> "Visual editor", "href"=>'Administration/Menu/Visual/'),
				array ("name"=> "Text editor", "href"=>'Administration/Menu/Text/'),
			)
	);

$admin_menu['options'] = array(
		"name" => "Options",
		"submenu" =>
			array(
				array ("name"=> "Change background", "href"=>'Administration/Options/Background/'),
				array ("name"=> "Widgets", "href"=>'Administration/Widgets/'),
			)
	);
$admin_menu['logs'] = array(
		"name" => "Logs",
		"submenu" =>
			array(
				array ("name"=> "System Logs", "href"=>'Administration/Logs/'),
			)
	);
?>