<?php
class forgot_config extends  xv_config {
	public function init_fields(){
		return array(
			"captcha_protection" => true,
			"forgot_enabled" => true,
		);
	}
}
?>