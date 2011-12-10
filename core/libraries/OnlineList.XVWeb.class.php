<?php

class OnlineListClass
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		if(!isset($this->Date['XVweb']->Date['DataBaseOnline'])){
			$this->Date['XVweb']->Date['DataBaseOnline'] = array(
			"DataBaseOnline" => "online",
			"IP" => "ip",
			"UrlLocation" => "location",
			"DateTime" => "time",
			"UserLoged" => "userloged",
			"Browser" => "browser",
			"SID" => "sid"
			);
		}
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function OnlineUserList($Date = array()){
			$Date = array_merge(array("ActualPage"=>0, "EveryPage"=>30), $Date);
			$DateExecute = array(
			);

			if(!is_numeric($Date["ActualPage"]) or !is_numeric($Date["EveryPage"])){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(100);
			}
				$Count = $this->Date['XVweb']->DataBase->pquery('SELECT count(*) AS `count` FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'`');
				$CountSQL = $Count->fetch();
$this->Date['XVweb']->Date['UserSortBy'] = "UserLoged";
			$UserOnlineList = $this->Date['XVweb']->DataBase->prepare('SELECT 
`'.$this->Date['XVweb']->Date['DataBaseOnline']["IP"].'` AS `IP` ,  
`'.$this->Date['XVweb']->Date['DataBaseOnline']["UrlLocation"].'` AS `UrlLocation` , 
`'.$this->Date['XVweb']->Date['DataBaseOnline']["DateTime"].'` AS `DateTime` , 
`'.$this->Date['XVweb']->Date['DataBaseOnline']["UserLoged"].'` AS `UserLoged` , 
`'.$this->Date['XVweb']->Date['DataBaseOnline']["Browser"].'` AS `Browser`,
`'.$this->Date['XVweb']->Date['DataBaseOnline']["SID"].'` AS `SID` 
FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'` '.(isset($this->Date['XVweb']->DataBaseOnline[$this->Date['XVweb']->Date['UserSortBy']])?'ORDER BY `'.$this->Date['XVweb']->DataBaseOnline[$this->Date['XVweb']->Date['UserSortBy']].'` '.($this->Date['XVweb']->Date['UserSort']=="asc"?"DESC":"ASC") : "" ).' LIMIT '.($Date["ActualPage"]*$Date["EveryPage"]).', '.(($Date["ActualPage"]*$Date["EveryPage"])+$Date["EveryPage"]).' ;');

			$UserOnlineList->execute($DateExecute);
			return array($UserOnlineList->fetchAll(), $CountSQL);

	}

}

?>