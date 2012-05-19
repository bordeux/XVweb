<?php

class login_config extends xv_config {}

class login_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(	
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

	
		);
	}
	
}
$config = new login_config_editor(new login_config());


?>