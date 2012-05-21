<?php
class xv_users_fields_email  extends xv_users_fields {
	var $plg_author = "Krzysztof Bednarczyk";
	var $plg_title = "EmailChanger";
	var $plg_webiste = "http://bordeux.net/";
	var $plg_description = "Email changer";
	
	public function field(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data, $user_class;
		
		if($user_data->User != $XVwebEngine->Session->Session('Logged_User') && !xv_perm("AdminPanel"))
			return '';
			
			
		xv_append_header("
		<style type='text/css' media='all'>
			.xv-user-email-content {
				margin-top: 10px;
				padding: 15px;
				background: #F2F7FA;
				border: 1px solid #AED0EA;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			.xv-user-email-content td {
				padding: 2px;
			}
		</style>");
	

		$result = '';
		$result .=
		'<div class="xv-user-email">
		<div class="xv-user-seperate"><span> Zmiana email </span></div>
		<div class="xv-user-email-content">
		<form action="?save=true&amp;email_change=true" method="post">';
		
		if(isset($_POST['xv_user_email'])){
			if($XVwebEngine->Session->get_sid() == $_POST['xv_sid']){
			$password_hashed = xvp()->hash_password($user_class, $_POST['xv_user_email']['password']);
			
			if($password_hashed == $user_data->Password){
				if (filter_var($_POST['xv_user_email']['email'], FILTER_VALIDATE_EMAIL)) {
				
					xvp()->user_edit($user_class, $user_data->User, array(
							"Mail" => $_POST['xv_user_email']['email']
						));
						
					$result .= "<div class='success'>".xv_lang("email_changed")."</div>";
				} else {
					$result .= "<div class='error'>".xv_lang("invalid_email")."</div>";
				}
			}else{
				$result .= "<div class='error'>".xv_lang("invalid_password")."</div>";
			}
			
			}else{
				$result .= "<div class='error'>".xv_lang("invalid_sid")."</div>";
			}
		}

		
		$result .='
		<input type="hidden" name="xv_sid" value="'.$XVwebEngine->Session->get_sid().'" />
			<table>
				<tr>
					<td>'.xv_lang("current_email").': </td>
					<td><a href="mailto:'.$user_data->Mail.'">'.$user_data->Mail.'</a></td>
				</tr>			
				<tr>
					<td>'.xv_lang("current_password").': </td>
					<td><input type="password" value="" name="xv_user_email[password]" autocomplete="off" /></td>
				</tr>			
				<tr>
					<td>'.xv_lang("new_email").': </td>
					<td><input type="email" value="" name="xv_user_email[email]" autocomplete="off" /></td>
					<td style="padding-left: 30px;"><input type="submit" value="'.xv_lang("Send").'" /></td>
				</tr>		
			</table>
		</form>
		</div>
			<div style="clear: both;" ></div>
		</div>';
		return $result;
	}
}