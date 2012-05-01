<?php
class xv_users_fields_avatar  extends xv_users_fields {
	var $plg_author = "Krzysztof Bednarczyk";
	var $plg_title = "Avatar";
	var $plg_webiste = "http://bordeux.net/";
	var $plg_description = "Avatar changer";
	
	public function field(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data, $user_class;
		
		if($user_data->User != $XVwebEngine->Session->Session('Logged_User') && !xv_perm("AdminPanel"))
			return '';
			
			
		xv_append_header("
		<style type='text/css' media='all'>
			.xv-user-avatar-content {
				margin-top: 10px;
				padding: 15px;
				background: #F2F7FA;
				border: 1px solid #AED0EA;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			.xv-user-avatar-worker img {
				background: #FFF;
			}
			.xv-user-avatar-worker td {
				vertical-align:middle;
			}
			.xv-user-avatar-worker td canvas {
				width:150px;
				height:150px;
				overflow:hidden; 
				background: #FFF;
				margin-left: 20px;
			}
			.xv-user-avatar-worker td input {
				margin-left: 10px;
			}
		</style>
		<script src='{$URLS['Script']}plugins/users/modules/fields/avatar/jcrop/js/jquery.Jcrop.min.js' type='text/javascript'></script>
		<link rel='stylesheet' href='{$URLS['Script']}plugins/users/modules/fields/avatar/jcrop/css/jquery.Jcrop.css' type='text/css' />
		<script src='{$URLS['Script']}plugins/users/modules/fields/avatar/js.js'></script>
		");
	

		
		$result =
		'<div class="xv-user-avatar">
		<div class="xv-user-seperate"><span> Zmiana avatara </span></div><form action="?save=true&amp;avatar_change=true" method="post" class="xv-user-avatar-form">
			<div class="xv-user-avatar-content">
			';
			
		if(isset($_POST['xv_user_avatar_data'])){	
			if($XVwebEngine->Session->GetSID() == $_POST['xv_sid']){
			
			
			$image_b64 = substr($_POST['xv_user_avatar_data'], strlen('data:image/png;base64,'));
			include_once(ROOT_DIR.'core/libraries/ResizeImage.class.php');
			$avants_dir = dirname(__FILE__).'/f/';
			$resize_image = new SimpleImage();
			$resize_image->load('data:image/png;base64,'.$image_b64);
			$resize_image->resize(150,150);
			$resize_image->save($avants_dir.$user_data->User.'_150.jpg', IMAGETYPE_JPEG);
			$resize_image->resize(64,64);
			$resize_image->save($avants_dir.$user_data->User.'_64.jpg', IMAGETYPE_JPEG);
			$resize_image->resize(32,32);
			$resize_image->save($avants_dir.$user_data->User.'_32.jpg', IMAGETYPE_JPEG);
			$resize_image->resize(16,16);
			$resize_image->save($avants_dir.$user_data->User.'_16.jpg', IMAGETYPE_JPEG);
			
				$result .=  "<div class='success'>".xv_lang("avatar_saved")."</div>";
			}else{
				$result .= "<div class='error'>".xv_lang("invalid_sid")."</div>";
			}
		}
		
		$result .='
			
			<input type="hidden" name="xv_sid" value="'.$XVwebEngine->Session->GetSID().'" />
				<div class="xv-user-avatar-worker">
					<table>
						<tr>
							<td>Select your image : <input type="file" id="xv-users-avatar" name="xv_users_avatar[]" accept="image/*" /></td>
							<td><img style="margin-left: 30px;" src="'.$URLS['Avats']	.($user_data->Avant ? $user_data->User : '' ).'_150.jpg'.(isset($_POST['xv_user_avatar_data']) ? '?refresh='.uniqid() : '').'" alt="'.$user_data->User.'" /></td>
						</tr>
					</table>
				</div>
			
			</div>
		</form>
			<div style="clear: both;" ></div>
		</div>';
		return $result;
	}
}