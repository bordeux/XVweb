<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_platnosci_online_config extends xv_config {}

class xva_platnosci_online_config_editor extends  xv_config_editor {
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
			"key" => array(
				"caption" => "Key",
				"desc" => "Your key",
				"type" => "text",
				"save" => array(

				),
				"field_data" => array(
					"type" => "text"
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
$config = new xva_platnosci_online_config_editor(new xva_platnosci_online_config());


?>