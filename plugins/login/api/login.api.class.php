<?php
include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
$users_class = new xv_users($XVwebEngine);

class xv_api_login{

     var $counter = 1;
	 
	/**
	 * Login API
	 * Usage : login("username", "api_key")
	 * Example : <a href='json/?login=["username", "api_key"]'>json/?login=["username", "api_key"]</a>
	 * Example : <a href='xml/?login=["username", "api_key"]'>xml/?login=["username", "api_key"]</a>
	 * Example : <a href='serialize/?login=["username", "api_key"]'>serialize/?login=["username", "api_key"]</a>
	 * 
	 * @param string $username
	 * @param string $api_key
	 * @return boolean
	 */	
	function login($username, $api_key){
		global $users_class;
		$login_user_result =  xvp()->user_login($users_class, $username, $password_hash);
		if($login_user_result){
			$this->XVweb->Session->Session('user_api', true);
		}
		
		return false;
	}	

	


	
}
