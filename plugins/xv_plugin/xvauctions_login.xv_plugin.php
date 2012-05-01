<?php
class xv_plugin_xvauctions_login {
	public function after_xv_users__user_login($result, $args){
		global $XVwebEngine;
		
		if($result == true){
			include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
			$XVwebEngine->Session->Session('xv_payments_amount', $XVwebEngine->InitClass("xvpayments")->get_user_amount($XVwebEngine->Session->Session('Logged_User')));	
		}
		return $result;
	}
}
	

?>