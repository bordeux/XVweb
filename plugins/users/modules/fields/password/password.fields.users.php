<?php
class xv_users_fields_password  extends xv_users_fields {
	var $plg_author = "Krzysztof Bednarczyk";
	var $plg_title = "PasswordChanger";
	var $plg_webiste = "http://bordeux.net/";
	var $plg_description = "Password changer";
	
	public function field(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data, $user_class;
		
		if($user_data->User != $XVwebEngine->Session->Session('Logged_User') || !xvPerm("AdminPanel"))
			return '';
			
			
		xv_append_header("
		<style type='text/css' media='all'>
			.xv-user-password-content {
				margin-top: 10px;
				padding: 15px;
				background: #F2F7FA;
				border: 1px solid #AED0EA;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			.xv-user-password-content td {
				padding: 2px;
			}
		</style>");
	

		$result = '';
		$result .=
		'<div class="xv-user-password">
		<div class="xv-user-seperate"><span> Zmiana hasła </span></div>
		<div class="xv-user-password-content">
		<form action="?save=true&amp;password_change=true" method="post">';
		
		if(isset($_POST['xv_user_password'])){
			if($XVwebEngine->Session->GetSID() == $_POST['xv_sid']){
			
			$password_hashed = xvp()->hash_password($user_class, $_POST['xv_user_password']['old']);
			
			if($password_hashed == $user_data->Password){
				if($_POST['xv_user_password']['password'] === $_POST['xv_user_password']['rpassword']){
					if(strlen($_POST['xv_user_password']['password']) > 4){
						$new_password_hashed = xvp()->hash_password($user_class, $_POST['xv_user_password']['password']);
						
						xvp()->user_edit($user_class, $user_data->User, array(
							"Password" => $new_password_hashed
						));
					
						$result .= "<div class='success'>".xvLang("password_changed")."</div>";
					}else{
						$result .= "<div class='error'>".xvLang("password_too_short")."</div>";
					}
					
				}else{
					$result .= "<div class='error'>".xvLang("password_not_equal")."</div>";
				}
			
			}else{
				$result .= "<div class='error'>".xvLang("invalid_password")."</div>";
			}
			
			}else{
				$result .= "<div class='error'>".xvLang("invalid_sid")."</div>";
			}
		
		}

		
		$result .='
		<input type="hidden" name="xv_sid" value="'.$XVwebEngine->Session->GetSID().'" />
			<table>
				<tr>
					<td>'.xvLang("current_password").': </td>
					<td><input type="password" value="" name="xv_user_password[old]" autocomplete="off" /></td>
				</tr>			
				<tr>
					<td>'.xvLang("new_password").': </td>
					<td><input type="password" value="" name="xv_user_password[password]" autocomplete="off" /></td>
					<td style="padding-left: 30px;"><input type="submit" value="'.xvLang("Send").'" /></td>
				</tr>		
				<tr>
					<td>'.xvLang("repeat_password").': </td>
					<td><input type="password" value="" name="xv_user_password[rpassword]" autocomplete="off" /></td>
				</tr>
			</table>
		</form>
		</div>
			<div style="clear: both;" ></div>
		</div>';
		return $result;
	}
}