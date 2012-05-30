<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/
include_once(dirname(__FILE__).'/../libs/class.messages.php');
$xv_message = &$XVwebEngine->load_class("xv_messages");

class xv_api_messages {
	/**
	 * toDo
	 * 
	 * @param string $to
	 * @param string $message
	 * @return boolean
	 */	
	function send_message($to, $message){
		global $XVwebEngine, $xv_message;

		if(!xv_perm("xv_msg_access"))
			return false;
			
		return	xvp()->send_message($xv_message, $XVwebEngine->Session->Session('user_name'), $to, $message);
	}
	/**
	 * toDo
	 * 
	 * @param string $reciver
	 * @param string $date
	 * @return array
	 */
	function get_messages($reciver, $date){
		global $XVwebEngine, $xv_message;

		if(!xv_perm("xv_msg_access"))
			return false;
			
		return	xvp()->get_messages_history_from_date($xv_message, $XVwebEngine->Session->Session('user_name'), $reciver, $date);
	}
	
}
