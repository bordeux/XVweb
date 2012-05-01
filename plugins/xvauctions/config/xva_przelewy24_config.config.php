<?php

class xva_przelewy24_config extends xv_config {}

class xva_przelewy24_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"enabled" => array(
				"caption" => "Enabled",
				"desc" => "Enable this method?",
				"type" => "boolean",
			),			
			"test_mode" => array(
				"caption" => "Test mode",
				"desc" => "Enable test mode",
				"type" => "boolean",
			),			
			"seller_id" => array(
				"caption" => "Seller ID",
				"desc" => "Insert your number sellerd id.",
				"type" => "text",
				"save" => array(

				),
				"field_data" => array(
					"type" => "number"
				)
			),		
			"payment_key" => array(
				"caption" => "Your KEY",
				"desc" => "Your payment key",
				"type" => "text",
				"save" => array(

				),
				"field_data" => array(
					"type" => "number"
				)
			),
			"lang" => array(
				"caption" => "Lang",
				"desc" => "Language, PL, EN",
				"type" => "text",
				"field_data" => array()
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
$config = new xva_przelewy24_config_editor(new xva_przelewy24_config());


?>