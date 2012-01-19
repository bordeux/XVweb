<?php
class xv_plugin_email_notification {
	public function send_mail($user, $url, $vars){
		if(!($GLOBALS['XVwebEngine']->ReadArticle($url, "","notification"))){
			return false;
		}
		$user_mail = $GLOBALS['XVwebEngine']->DataBase->prepare('SELECT {Users:*} FROM {Users} WHERE {Users:User} = :user LIMIT 1; ');
		$user_mail->execute(array(
			":user" => $user
		)); 
		$user_mail = $user_mail->fetch(PDO::FETCH_ASSOC);
		if(empty($user_mail['Mail']))
			return false;
		
		$email_content = $GLOBALS['XVwebEngine']->Date['notification']['ReadArticleOut']['Contents'];
		$email_topic = $GLOBALS['XVwebEngine']->Date['notification']['ReadArticleOut']['Topic'];
		$vars['--title--'] = $email_topic;
		if(is_array($GLOBALS['URLS'])){
			foreach($GLOBALS['URLS'] as $key=>$val){
				$vars['--urls_'.strtolower($key).'--'] = $val;
			}
		}
		if(is_array($user_mail)){
			foreach($user_mail as $key=>$val){
				$vars['--user_'.strtolower($key).'--'] = $val;
			}
		}
		$email_content = strtr($email_content, $vars);
		$email_topic = strtr($email_topic, $vars);
		
	//$user_mail['mail']
		$GLOBALS['XVwebEngine']->MailClass()->mail($user_mail['Mail'], $email_topic, $email_content);
		return true;
	}
	
	public function after_xvauctions__end_auction($result, $args){
			$auction_info = $GLOBALS['XVauctions']->get_auction($args[0], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction_'.strtolower($key).'--'] = $val;
		}
		$data_email['--auction_link--'] = $GLOBALS['URLS']['Auction'].'/'.$auction_info['ID'].'/';

		xv_plugin_email_notification::send_mail($auction_info['Seller'], '/System/Auctions/Notifications/Emails/End_of_auction/', $data_email);
		return $result;
	}	
	public function after_xvauctions__create_bought($result, $args){
			$auction_info = $GLOBALS['XVauctions']->get_auction($args[0], false, false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction_'.strtolower($key).'--'] = $val;
		}
		$data_email['--auction_link--'] = $GLOBALS['URLS']['Auction'].'/'.$auction_info['ID'].'/';
		$data_email['--to_pay--'] = $args[4];
		$data_email['--pieces--'] = $args[5];
		$data_email['--pay_link--'] = $GLOBALS['URLS']['AuctionPanel'].'/payment_pay/'.$result.'/';
		$data_email['--pay_id--'] = $result;
		$data_email['--seller_message--'] = $GLOBALS['XVauctions']->get_auction_description($args[0], "message");
		

		xv_plugin_email_notification::send_mail($args[1], '/System/Auctions/Notifications/Emails/You_won_the_auction/', $data_email);
		
		return $result;
	}	
	public function after_xvauctions__create_offer($result, $args){
		if($args[2] != "auction"){
			return $result;
		}
		$auction_info = $GLOBALS['XVauctions']->get_auction($args[0], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction_'.strtolower($key).'--'] = $val;
		}
		$data_email['--to_pay--'] = $args[3];
		$data_email['--pieces--'] = $args[4];
		$data_email['--auction_link--'] = $GLOBALS['URLS']['Auction'].'/'.$args[0].'/';
		

		xv_plugin_email_notification::send_mail($args[1], '/System/Auctions/Notifications/Emails/Offer_created/', $data_email);
		
		return $result;
	}	
	
	public function after_xvauctions__create_opinion($result, $args){

		$auction_info = $GLOBALS['XVauctions']->get_auction($args[1], false);
		if(empty($auction_info))
			return $result;
			
		$data_email = array();
		foreach($auction_info as $key=>$val){
			$data_email['--auction_'.strtolower($key).'--'] = $val;
		}

		$data_email['--seller--'] = $args[8];
		$data_email['--buyer--'] = $args[9];
		$data_email['--auction_link--'] = $GLOBALS['URLS']['Auction'].'/'.$args[1].'/';

		xv_plugin_email_notification::send_mail($args[0], '/System/Auctions/Notifications/Emails/New_opinion/', $data_email);
		
		return $result;
	}	
	
	public function after_xvauctions__create_auction($result, $args){
		$data_email = array();
		if(isset($args[0][":id"]))
			return $result;
			
		$data_email['--auction_id--'] = $result;
		$data_email['--auction_link--'] = $result;
		$data_email['--auction_title--'] = $args[0][":title"];
		$data_email['--auction_start--'] = $args[0][":start"];
		$data_email['--auction_end--'] = $args[0][":end"];
		$data_email['--auction_link--'] = $GLOBALS['URLS']['Auction'].'/'.$result.'/';

		xv_plugin_email_notification::send_mail(ifsetor($args[0][":seller"], ""), '/System/Auctions/Notifications/Emails/New_auction/', $data_email);
		return $result;
	}
	
	public function after_xvpayments__add_transaction($result, $args){
		$data_email = array();
		if($args[1] <= 0)
			return $result;
		$amount = (int) preg_replace('/[^0-9\-]/i', '', $args[1]);
		$amount = number_format(($amount/100), 2, '.', ' '); ;

		
		$amount_status = xvp()->get_user_amount(xvp()->InitClass($GLOBALS['XVwebEngine'], "xvpayments"), $args[0]);
		$amount_status = number_format(($amount_status/100), 2, '.', ' '); 
		
		$data_email = array();
		$data_email['--amount--'] = $amount;
		$data_email['--amount_status--'] = $amount_status.'';
		$data_email['--amount_id--'] = $result;
		$data_email['--amount_title--'] =  $args[3];
		$data_email['--amount_link--'] =   $GLOBALS['URLS']['AuctionPanel'].'/payment_details/'.$result.'/';
		
		xv_plugin_email_notification::send_mail(ifsetor($args[0], ""), '/System/Auctions/Notifications/Emails/New_payment/', $data_email);
		return $result;
	}

	
}

?>