<?php



class xv_messages {
	var $XVweb;
	public function __construct(&$XVweb) {
		$this->XVweb = &$XVweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function send_message($user, $receiver, $message){
		$message_add = $this->XVweb->DataBase->prepare("INSERT INTO {Messages} ({Messages:User}, {Messages:Receiver}, {Messages:Text}, {Messages:Date} ) VALUES (:user, :receiver, :message,  NOW());");
		$message_add->execute(array(
			":user"=> 		$user,
			":receiver"=>  	$receiver, 
			":message"=>	$this->parse_message($message),
		));
		return true;
	
	}
	public function get_message($id){
		
	}
	
	public function get_messages_history($user, $receiver, $page = 0, $limit = 20){
			$message_history = $this->XVweb->DataBase->prepare('SELECT {Messages:*}, (CASE {Messages:User} WHEN :user THEN 1 ELSE 0 END) AS Me FROM {Messages} WHERE ({Messages:User} = :user AND {Messages:Receiver} = :receiver) OR ({Messages:User} = :receiver AND {Messages:Receiver} = :user)  ORDER BY {Messages:Date} DESC LIMIT '.$page*$limit.' , '.$limit.';');
			$message_history->execute(array(
				":user"=>$user,
				":receiver" => $receiver
			));
			$result = $message_history->fetchAll(PDO::FETCH_ASSOC);
			krsort($result);
		return $result;
	
	}	
	
	public function get_messages_history_from_date($user, $receiver, $date, $page = 0, $limit = 20){
			$message_history = $this->XVweb->DataBase->prepare('SELECT {Messages:Date} as Date, {Messages:Text} as Message, {Messages:User} AS User, {Messages:Receiver} AS Receiver  , (CASE {Messages:User} WHEN :user THEN 1 ELSE 0 END) AS Me FROM {Messages} WHERE (({Messages:User} = :user AND {Messages:Receiver} = :receiver) OR ({Messages:User} = :receiver AND {Messages:Receiver} = :user)) AND  {Messages:Date} > :date  ORDER BY {Messages:Date} DESC LIMIT '.$page*$limit.' , '.$limit.';');
			
			$message_history->execute(array(
				":user"=>$user,
				":receiver" => $receiver,
				":date" => $date
			));
			
			$result = $message_history->fetchAll(PDO::FETCH_ASSOC);
			krsort($result);
		return $result;
	
	}
	public function get_address_book($user, $page = 0, $limit=30){
		$address_book = $this->XVweb->DataBase->prepare('SELECT (CASE {Messages:User} WHEN :user THEN {Messages:Receiver} ELSE {Messages:User} END) AS user,  SUM({Messages:Unread}) as unread, MAX({Messages:Date}) AS date FROM {Messages} WHERE ({Messages:User} = :user OR {Messages:Receiver} = :user) AND {Messages:Deleted} = 0 GROUP BY user ORDER BY date DESC LIMIT '.$page*$limit.' , '.$limit.';');
		$address_book->execute(array(
			":user"=>$user
		));

		return $address_book->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function parse_message($text){
			$text= htmlspecialchars($text);
			$reg = '~((?:https?://|www\d*\.)\S+[-\w+&@#/%=\~|])~';
			$text =  preg_replace_callback( $reg, array($this,'prase_links'), $text );
			$text= nl2br($text);
		return $text;
	}
	public function prase_links  ( $m ){
		$link_limit = 30;
		$link_format = '<a href="%s" rel="ext" target="_blank">%s</a>';
		$href = $name = html_entity_decode($m[0]);

		if ( strpos( $href, '://' ) === false ) {
			$href = 'http://' . $href;
		}

		if( strlen($name) > LINK_LIMIT ) {
			$k = ( LINK_LIMIT - 3 ) >> 1;
			$name = substr( $name, 0, $k ) . '...' . substr( $name, -$k );
		}

		return sprintf($link_format, htmlentities($href), htmlentities($name) );
	}

}




?>