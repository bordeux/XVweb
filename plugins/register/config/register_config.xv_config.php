<?php
class register_config extends  xv_config {
	public function init_fields(){
		return array(
			"register_message" => "Hello.",
			
			"register_success_message" => 
			"Thank you for registering!<br />
			Please check your email and follow the link provided.",
			
			"mail_activation" => true,
			
			"mail_activation_message" => "<h1>Hello --xv-user--</h1>
				<p>To activate your account, please visit this link:</p>
				<p><a href='--xv-activate-link--'>--xv-activate-link--</a></p>
				<hr />
				Thanks<br />
				XYZ
			",
			
		);
	}
}
?>