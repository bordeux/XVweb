<?php
class login_config extends  xv_config {
	public function init_fields(){
		global $URLS;
		return array(
			"captcha_protection" => false,
			"login_cookie_name" => "login_remember",
			"login_cookie_time" => 1209600,
			
			
		);
	}
}
?>