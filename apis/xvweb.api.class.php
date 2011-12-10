<?php
class api_xvweb {

     var $counter = 1;
	 
	/**
	 * Sample hello world
	 * Usage : hello("world")
	 * Example : <a href='json/?hello=["world"]'>json/?hello=["world"]</a>
	 * 
	 * @param string $user
	 * @return string
	 */	
	function hello($user){
		return "Hello ".$user;
	}	
	
	/**
	 * 
	 * If you want to use API, you must frist login via:
	 * - ApiKey - login("username", "ApiKEY", true)
	 * - Password - login("username", "password", false)
	 *
	 * @param string $username
	 * @param string $key
	 * @param boolean $type true
	 * @return boolean
	 */	
	function login($username, $key, $type){
		
		return array("test", "costam");
	}
	
	public function __sleep(){
        return array('counter');
    }
    
    public function __wakeup(){
       
    }

	
}
