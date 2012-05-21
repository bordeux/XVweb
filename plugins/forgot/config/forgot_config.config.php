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

		);
	}
	
}
$config = new forgot_config_editor(new forgot_config());


?>