<?php

class register_config extends xv_config {}

class register_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"register_enabled" => array(
				"caption" => "Captcha protection",
				"desc" => "Enable captcha protection",
				"type" => "boolean",
			),
			"mail_activation" => array(
				"caption" => "Mail activation",
				"desc" => "Is required mail activation?",
				"type" => "boolean",
			),		
			

			
			"captcha_protection" => array(
				"caption" => "Captcha protection",
				"desc" => "Enable captcha protection",
				"type" => "boolean",
			),

			"default_group" => array(
				"caption" => "Default user group",
				"type" => "text",
			),			

			"mail_activated" => array(
				"caption" => "Mail activation",
				"desc" => "Is required mail activation?",
				"type" => "boolean",
			),		
			
		);
	}
	
}
$config = new register_config_editor(new register_config());


?>