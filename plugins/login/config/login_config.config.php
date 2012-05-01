<?php

class login_config extends xv_config {}

class login_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"login_message" => array(
				"caption" => "Login message",
				"desc" => "Message showed while user creating the account",
				"type" => "textarea",
			),
			"login_success_message" => array(
				"caption" => "Login - Success message",
				"desc" => "Message showed after succesful login, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),			
			"login_cookie_name" => array(
				"caption" => "Cookie name",
				"desc" => "Cookie name",
				"type" => "text",
				"field_data" => array()
			),		
			"login_cookie_time" => array(
				"caption" => "Cookie time",
				"desc" => "Cookie time",
				"type" => "text",
				"field_data" => array(
					"type" => "number"
				)
			),
		

			"captcha_protection" => array(
				"caption" => "Captcha protection",
				"desc" => "Enable captcha protection",
				"type" => "boolean",
			),

			"logout_success_message" => array(
				"caption" => "Logout - Success message",
				"desc" => "Message showed after succesful logout, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),	
			"logout_failed_message" => array(
				"caption" => "Logout - failed message",
				"desc" => "Message showed after failed logout, HTML format",
				"type" => "textarea",
				"field_data" => array()
			),	
	
		);
	}
	
}
$config = new login_config_editor(new login_config());


?>