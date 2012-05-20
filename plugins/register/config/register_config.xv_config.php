<?php
class register_config extends  xv_config {
	public function init_fields(){
		return array(
			"register_enabled" => true,
			"mail_activation" => true,
			"captcha_protection" => true,
			"default_group" => "user",
			"mail_activated" => true,
		);
	}
}
?>