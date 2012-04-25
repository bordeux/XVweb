<?php
class login_config extends  xv_config {
	public function init_fields(){
		global $URLS;
		return array(
			"login_message" => "Hello. This is login!!",
			
			"login_success_message" => 
			"Thank you for login.<br />
			Now you are logged.
			<script>
				setTimeout(function(){
					location.href = '".$URLS['Script']."';
				},2000);
			</script>
			",
			"captcha_protection" => false,
		);
	}
}
?>