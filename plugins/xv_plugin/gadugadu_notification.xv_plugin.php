<?php
class xv_plugin_gadugadu_notification {
	public function send_mail($user, $url, $vars){
		if(!($GLOBALS['XVwebEngine']->ReadArticle($url, "","notification"))){
			return false;
		}
		$user_mail = $GLOBALS['XVwebEngine']->DataBase->prepare('SELECT {Users:Mail} AS mail FROM {Users} WHERE {Users:User} = :user LIMIT 1; ');
		$user_mail->execute(array(
			":user" => $user
		)); 
		$user_mail = $user_mail->fetch(PDO::FETCH_ASSOC);
		if(empty($user_mail['mail']))
			return false;
		
		$email_content = $GLOBALS['XVwebEngine']->Date['notification']['ReadArticleOut']['Contents'];
		$email_topic = $GLOBALS['XVwebEngine']->Date['notification']['ReadArticleOut']['Topic'];
		$vars['--title--'] = $email_topic;
		
		$email_content = strtr($email_content, $vars);
		$email_topic = strtr($email_topic, $vars);
		
	//$user_mail['mail']
		$GLOBALS['XVwebEngine']->MailClass()->mail("bordeux@wp.pl", $email_topic, $email_content);
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
		
		foreach($GLOBALS['URLS'] as $key=>$val){
			$data_email['--urls_'.strtolower($key).'--'] = $val;
		}
		xv_plugin_email_notification::send_mail($auction_info['Seller'], '/System/Auctions/Notifications/Emails/End_of_auction/', $data_email);
		return $result;
	}	

	
}

?>