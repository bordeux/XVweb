<?php

class forgot_config extends xv_config {}

class forgot_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"captcha_protection" => array(
				"caption" => "Captcha protection",
				"desc" => "Enable captcha protection",
				"type" => "boolean",
			),
			"forgot_enabled" => array(
				"caption" => "Function enabled",
				"desc" => "Enable this function",
				"type" => "boolean",
			),
			"forgot_message" => array(
				"caption" => "Forgot message",
				"desc" => "Message showed while user use this function",
				"type" => "textarea",
			),
			"forgot_success_message" => array(
				"caption" => "Forgot - Success message",
				"desc" => "Message showed after succesful use this function, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),
		
	
			
			"mail_reset_topic" => array(
				"caption" => "Mail reset topic",
				"desc" => "Topic of mail",
				"type" => "text",
			),
			"mail_reset_message" => array(
				"caption" => "Mail reset message",
				"desc" => "Content of mail, HTML format. You can use --xv-forgot-link-- to reset link",
				"type" => "textarea",
				"field_data" => array()
			),

	
			
			"forgot_new_password_send_message" => array(
				"caption" => "Reset success",
				"desc" => "Message after clicked on reset link",
				"type" => "textarea",
			),				
			"forgot_failed" => array(
				"caption" => "Reset failed",
				"desc" => "Message after clicked on reset link",
				"type" => "textarea",
			),	
			
			"mail_new_password_topic" => array(
				"caption" => "Mail after reset topic",
				"desc" => "Topic of mail",
				"type" => "text",
			),
			"mail_new_password_message" => array(
				"caption" => "Mail after reset message",
				"desc" => "Content of mail, HTML format. You can use --xv-forgot-new-password--",
				"type" => "textarea",
				"field_data" => array()
			),		

	
			
		);
	}
	
}
$config = new forgot_config_editor(new forgot_config());


?>