<?php
class xv_api_xvweb {

     var $counter = 1;
	 
	/**
	 * Sample hello world
	 * Usage : hello("world")
	 * Example : <a href='json/?hello=["world"]'>json/?hello=["world"]</a>
	 * Example : <a href='xml/?hello=["world"]'>xml/?hello=["world"]</a>
	 * Example : <a href='serialize/?hello=["world"]'>serialize/?hello=["world"]</a>
	 * Example : <a href='yaml/?hello=["world"]'>yaml/?hello=["world"]</a>
	 * 
	 * @param string $user
	 * @return string
	 */	
	function hello($user){
		return "Hello ".$user;
	}	
	

	
	public function __sleep(){
        return array('counter');
    }
    
    public function __wakeup(){
       
    }

	
}
