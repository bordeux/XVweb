<?php
class xv_ip_ban {

	var $XVweb;
	
	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function check_ip($ip){
			$ban_check = $this->XVweb->DataBase->prepare("SELECT {Bans:*} FROM {Bans} WHERE {Bans:Expire} > NOW() AND ({Bans:FilterType} = 1 AND :ip LIKE {Bans:IP}) OR ({Bans:FilterType} = 0 AND :ip NOT LIKE {Bans:IP}) LIMIT 1;");
			$ban_check->execute(array(
				":ip" => $ip
			));
			$ban_check = $ban_check->fetch(PDO::FETCH_OBJ);
		return $ban_check;
	}
	
}
?>