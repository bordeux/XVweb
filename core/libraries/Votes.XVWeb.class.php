<?php


class VotesClass
{
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function set($type, $SID, $vote, $user = null, $ip=null){
			if(is_null($user))
				$user = $this->Date['XVweb']->Session->Session('Logged_User');
			if(is_null($ip))
				$ip = $_SERVER['REMOTE_ADDR'];
				
				if($this->Date['XVweb']->Session->Session('Logged_Logged') != true)
					$user = 'NoLoged|'.$_SERVER['REMOTE_ADDR'];
					
			$AddVote = $this->Date['XVweb']->DataBase->prepare('INSERT INTO 
			{Votes}
			({Votes:Uniq}, {Votes:SID}, {Votes:Type}, {Votes:IP}, {Votes:User}, {Votes:Vote})
			VALUES (MD5(CONCAT(:SID,:Type,:User)), :SID, :Type, :IP, :User, :Vote) 
			ON DUPLICATE KEY UPDATE `vote`= :Vote');
			$AddVote->execute(array(
				":SID"=>$SID,
				":Type"=>$type,
				":IP"=>$ip,
				":User"=>$user,
				":Vote"=>$vote
			));

			return $AddVote->rowCount();
	}

}

?>