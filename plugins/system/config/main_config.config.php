<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

//class main_config extends xv_config {}

class main_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(	
			"site_name" => array(
				"caption" => "Site name",
				"desc" => "Site name",
				"type" => "text",
				"field_data" => array()
			),		
			"index_page" => array(
				"caption" => "Index page",
				"desc" => "URL (path) to index page",
				"type" => "text",
				"field_data" => array()
			),
			"mod_rewrite" => array(
				"caption" => "Mod rewrite",
				"desc" => "Enable mod rewrite?",
				"type" => "boolean",
				"save" => array(

				),
				"field_data" => array(
					"type" => "number"
				)
			),	
			
		);
	}
	
}
$config = new main_config_editor(new main_config());


?>