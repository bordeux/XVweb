<?php
class register_config extends  xv_config {
	public function init_fields(){
		return array(
			"register_enabled" => true,
			"register_message" => "Hello.",
			
			"register_success_message" => 
			"Thank you for registering!<br />
			Please check your email and follow the link provided.",
			
			"mail_activation" => true,
			
			"mail_activation_topic" => "Activation --xv-user-user--",
			"mail_activation_message" => "<h1>Hello --xv-user-user--</h1>
				<p>To activate your account, please visit this link:</p>
				<p><a href='--xv-activate-link--'>--xv-activate-link--</a></p>
				<hr />
				Thanks<br />
				XYZ
			",
			"captcha_protection" => true,
			"default_group" => "user",
			
			"mail_activated" => true,
			"mail_activated_topic" => "User --xv-user-user-- activated",
			"mail_activated_message" => "<h1>Hello --xv-user-user--</h1>
				<p>Your account was activated. </p>
				<hr />
				Thanks<br />
				XYZ
			",
			"activate_success" => "Your account was activated. Now you can log in",
			"activate_failed" => "Your account was not activated. Something wrong?",
		);
	}
}
?>