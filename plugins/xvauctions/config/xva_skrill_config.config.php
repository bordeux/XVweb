<?php

class xva_skrill_config extends xv_config {}

class xva_skrill_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"enabled" => array(
				"caption" => "Enabled",
				"desc" => "Enable this method?",
				"type" => "boolean",
			),	
		"email" => array(
				"caption" => "Email",
				"desc" => "Your email",
				"field_data" => array(
					"type" => "email"
				)
			),			
		"secret_word" => array(
				"caption" => "Secret word",
				"desc" => "Your secred word",
				"field_data" => array(
					"type" => "email"
				)
			),		
			"lang" => array(
				"caption" => "Lang",
				"desc" => "Language, PL, EN",
				"type" => "text",
				"field_data" => array()
			),
			"logo" => array(
				"caption" => "Logo",
				"desc" => "Your url to logo image",
				"type" => "text",
				"save" => array(

				),
				"field_data" => array(
					"type" => "text"
				)
			),	
			
		
			"provision" => array(
				"caption" => "Provision",
				"desc" => "Provision - amount*provision",
				"type" => "text",
				
			),		
			"currency" => array(
				"caption" => "Currency",
				"desc" => "Currency: PLN, USD",
				"type" => "text",
				
			),
		);
	}
	
}
$config = new xva_skrill_config_editor(new xva_skrill_config());


?>