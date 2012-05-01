<?php

class xva_dotpay_config extends xv_config {}

class xva_dotpay_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"enabled" => array(
				"caption" => "Enabled",
				"desc" => "Enable this method?",
				"type" => "boolean",
				"save" => array(

				),
				"field_data" => array(
					"type" => "number"
				)
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
			"ips" => array(
				"caption" => "IPs",
				"desc" => "Allowed IPs to execute script",
				"type" => "textarea",
				"field_data" => array()
			),
			"provision" => array(
				"caption" => "Provision",
				"desc" => "Provision - amount*provision",
				"type" => "text",
				
			),
		);
	}
	
}
$config = new xva_dotpay_config_editor(new xva_dotpay_config());


?>