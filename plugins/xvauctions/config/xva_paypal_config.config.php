<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_paypal_config extends xv_config {}

class xva_paypal_config_editor extends  xv_config_editor {
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
			"email" => array(
				"caption" => "Email",
				"desc" => "Insert your paypal email",
				"type" => "text",
				"field_data" => array(
					"type" => "email"
				)
			),
			"test_mode" => array(
				"caption" => "Test mode",
				"desc" => "Enable test mode",
				"type" => "boolean",
			),
			"currency" => array(
				"caption" => "Currency",
				"desc" => "Select: USD, PLN, EUR... more on paypal.com",
				"type" => "text",
			),
			"provision" => array(
				"caption" => "Provision",
				"desc" => "Provision - amount*provision",
				"type" => "text",
				
			),
		);
	}
	
}
$config = new xva_paypal_config_editor(new xva_paypal_config());


?>