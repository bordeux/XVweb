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
			"register_message" => array(
				"caption" => "Register message",
				"desc" => "Message showed while user creating the account",
				"type" => "textarea",
			),
			"register_success_message" => array(
				"caption" => "Register - Success message",
				"desc" => "Message showed after succesful registering, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),
		
			"mail_activation" => array(
				"caption" => "Mail activation",
				"desc" => "Is required mail activation?",
				"type" => "boolean",
			),		
			
			"mail_activation_topic" => array(
				"caption" => "Mail activation topic",
				"desc" => "Topic of mail",
				"type" => "text",
			),
			"mail_activation_message" => array(
				"caption" => "Mail activation message",
				"desc" => "Content of mail, HTML format",
				"type" => "textarea",
				"field_data" => array()
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
			
			"mail_activated_topic" => array(
				"caption" => "Mail activated topic",
				"desc" => "Topic of mail",
				"type" => "text",
			),
			"mail_activated_message" => array(
				"caption" => "Mail activated message",
				"desc" => "Content of mail, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),		

			"activate_success" => array(
				"caption" => "Actiavate success",
				"desc" => "Message after succesful activated",
				"type" => "textarea",
				"field_data" => array()
			),		
			"activate_failed" => array(
				"caption" => "Actiavate failed",
				"desc" => "Message after failed activated",
				"type" => "textarea",
				"field_data" => array()
			),
			
		);
	}
	
}
$config = new register_config_editor(new register_config());


?>