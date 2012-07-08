<?php
$admin_menu['main'] = array(
		"name" => "Main page",
		"href" => $URLS['Site']
	);
	
$admin_menu['system'] = array(
		"name" => "System"
	);
	




$admin_menu['options'] = array(
		"name" => "Options",
		"submenu" =>
			array(
				array ("name"=> "Change background", "href"=>'Administration/Options/Background/'),
				array ("name"=> "Widgets", "href"=>'Administration/Widgets/'),
			)
	);




?>