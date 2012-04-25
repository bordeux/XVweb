<?php
class forgot_config extends  xv_config {
	public function init_fields(){
		return array(
			"captcha_protection" => true,
			"forgot_enabled" => true,
			"forgot_enabled" => true,
			"forgot_message" => "Hello.",
			
			"forgot_success_message" => 
			"Thank you for forgoting!<br />
			Please check your email and follow the link provided.",
			
			"mail_reset_topic" => "Password reset for --xv-user-user--",
			"mail_reset_message" => "<h1>Hello --xv-user-user--</h1>
				<p>If you want reset the password, please visit this link: </p>
				<p><a href='--xv-forgot-link--'>--xv-forgot-link--</a></p>
				<hr />
				Thanks<br />
				XYZ
			",
			"forgot_new_password_send_message" => "Your new password was sent to your mail",
			"forgot_failed" => "Error: This is url is expired.",
			
			"mail_new_password_topic" => "New password --xv-user-user-- ",
			"mail_new_password_message" => "<h1>Hello --xv-user-user--</h1>
				<p>Your new password is <b> --xv-forgot-new-password-- </b>. Please change it, after login. </p>
				<hr />
				Thanks<br />
				XYZ
			",
		);
	}
}
?>