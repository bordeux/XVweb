<?php

class xv_plugin_email_notification {

	public function send_message($user, $lang_name, $vars = array()){
		global $XVwebEngine, $sm_lang_loaded ;
			xv_load_lang($lang_name.".mails.xvauctions");
			include_once(ROOT_DIR.'plugins/users/libs/users.class.php');
			$sm_lang_loaded = true;
		
			$users_class = new xv_users($XVwebEngine);
		return xvp()->user_send_email($users_class, $user, xv_lang("xca_".$lang_name."_topic"), xv_lang("xca_".$lang_name."_content"), $vars);
	}
	
	public function after_xvauctions__end_auction($result, $args){ // UKOÑCZONE!
		global $XVauctions, $URLS;
			$auction_info = $XVauctions->get_auction($args[0], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction-'.strtolower($key).'--'] = $val;
		}
		$data_email['--auction-link--'] = $URLS['Auction'].'/'.$auction_info['ID'].'/';
			xv_plugin_email_notification::send_message($auction_info['Seller'], "end_auction", $data_email);
		return $result;
	}	
	
	public function after_xvauctions__create_bought($result, $args){
		global $XVauctions, $URLS;
			$auction_info = $XVauctions->get_auction($args[0], false, false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction-'.strtolower($key).'--'] = $val;
		}
		$data_email['--auction-link--'] = $URLS['Auction'].'/'.$auction_info['ID'].'/';
		$data_email['--to-pay--'] = $args[4];
		$data_email['--pieces--'] = $args[5];
		$data_email['--pay-link--'] = $URLS['AuctionPanel'].'/payment_pay/'.$result.'/';
		$data_email['--pay-id--'] = $result;
		$data_email['--seller-message--'] = $XVauctions->get_auction_description($args[0], "message");
		
		xv_plugin_email_notification::send_message($args[1], "create_bought", $data_email);
		
		return $result;
	}	
	public function after_xvauctions__create_offer($result, $args){
		global $XVauctions, $URLS;
		if($args[2] != "auction"){
			return $result;
		}
		$auction_info = $XVauctions->get_auction($args[0], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction-'.strtolower($key).'--'] = $val;
		}
		$data_email['--to-pay--'] = $args[3];
		$data_email['--pieces--'] = $args[4];
		$data_email['--auction-link--'] = $URLS['Auction'].'/'.$args[0].'/';
		
		xv_plugin_email_notification::send_message($args[1], "create_offer", $data_email);
		
		return $result;
	}	
	
	public function after_xvauctions__create_opinion($result, $args){ //UKONCZONE!
		global $XVauctions, $URLS;
		$auction_info = $XVauctions->get_auction($args[1], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction-'.strtolower($key).'--'] = $val;
		}
		$data_email['--seller--'] = $args[8];
		$data_email['--buyer--'] = $args[9];
		$data_email['--auction-link--'] = $URLS['Auction'].'/'.$args[1].'/';
		
			xv_plugin_email_notification::send_message($args[0], "new_opinion", $data_email);
		return $result;
	}	
	
	public function after_xvauctions__create_auction($result, $args){
		global $URLS;
		$data_email = array();
		if(isset($args[0][":id"]))
			return $result;
			
		$data_email['--auction-id--'] = $result;
		$data_email['--auction-link--'] = $result;
		$data_email['--auction-title--'] = $args[0][":title"];
		$data_email['--auction-start--'] = $args[0][":start"];
		$data_email['--auction-end--'] = $args[0][":end"];
		$data_email['--auction-link--'] = $URLS['Auction'].'/'.$result.'/';
			xv_plugin_email_notification::send_message(ifsetor($args[0][":seller"], ""), "new_auction", $data_email);
			
		return $result;
	}
	
	public function after_xvpayments__add_transaction($result, $args){
			global $XVwebEngine, $URLS;
			$data_email = array();
			if($args[1] <= 0)
				return $result;
			$amount = (int) preg_replace('/[^0-9\-]/i', '', $args[1]);
			$amount = number_format(($amount/100), 2, '.', ' '); ;

			
			$amount_status = xvp()->get_user_amount(xvp()->load_class($XVwebEngine, "xvpayments"), $args[0]);
			$amount_status = number_format(($amount_status/100), 2, '.', ' '); 
			
			$data_email = array();
			$data_email['--amount--'] = $amount;
			$data_email['--amount-status--'] = $amount_status.'';
			$data_email['--amount-id--'] = $result;
			$data_email['--amount-title--'] =  $args[3];
			$data_email['--amount-link--'] =   $URLS['AuctionPanel'].'/payment_details/'.$result.'/';
			xv_plugin_email_notification::send_message(ifsetor($args[0], ""), "add_transaction", $data_email);
		return $result;
	}

	
}

?>