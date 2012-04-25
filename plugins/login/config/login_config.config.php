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
		

			"captcha_protection" => array(
				"caption" => "Captcha protection",
				"desc" => "Enable captcha protection",
				"type" => "boolean",
			),

	
		);
	}
	
}
$config = new login_config_editor(new login_config());


?>