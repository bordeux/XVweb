<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/
if(!isset($admin_menu['media'])){
	$admin_menu['media'] = array(
			"name" => "Media"
		);
}
$admin_menu['media']['submenu'][] = array ("name"=> "xvAuctions", "href"=>'Administration/XVauctions/');

?>