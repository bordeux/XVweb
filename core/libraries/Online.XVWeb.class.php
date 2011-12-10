<?php

/************************************************************************************************/
class OnlineClass
/************************************************************************************************/
{	var $Date;
	/************************************************************************************************/
	public function __construct(&$Xvweb, $UrlLocation=null) {
		$this->Date['XVweb'] = &$Xvweb;
		$this->Date['Time'] = 60;
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

		if(!is_null($UrlLocation) &&  parse_url($UrlLocation, PHP_URL_HOST) ==  $_SERVER['HTTP_HOST'])
			$this->Date['UrlLocation'] = parse_url($UrlLocation, PHP_URL_PATH); else //XSS e
			$this->Date['UrlLocation'] = '/'; 
		$this->OnlineInit();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	/************************************************************************************************/
	public function OnlineInit(){
		$Online = $this->Date['XVweb']->DataBase->prepare('
	DELETE FROM 
		`'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'` 
		WHERE 
		`'.($this->Date['XVweb']->Date['DataBaseOnline']['IP']).'` = :IPExec 
		OR
		
		'.time().' - `'.($this->Date['XVweb']->Date['DataBaseOnline']['DateTime']).'` > '.$this->Date['Time'].' ;
');

		$Online->execute(array(
		":IPExec" => $_SERVER['REMOTE_ADDR'],
		));
		
		$Online = $this->Date['XVweb']->DataBase->prepare('
	INSERT INTO `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'`  (
`'.($this->Date['XVweb']->Date['DataBaseOnline']['IP']).'` ,
`'.($this->Date['XVweb']->Date['DataBaseOnline']['UrlLocation']).'` ,
`'.($this->Date['XVweb']->Date['DataBaseOnline']['DateTime']).'` ,
`'.($this->Date['XVweb']->Date['DataBaseOnline']['Browser']).'`  ,
`'.($this->Date['XVweb']->Date['DataBaseOnline']['UserLoged']).'`,
`'.($this->Date['XVweb']->Date['DataBaseOnline']['SID']).'` 
)
VALUES (
:IPExec , :UrlExec, '.time().', :BrowserExec, :UserLoged, :SIDExec
);
');
	$Online->execute(array(
		":IPExec" => $_SERVER['REMOTE_ADDR'],
		":UrlExec" => $this->Date['UrlLocation'],
		":BrowserExec" => $_SERVER['HTTP_USER_AGENT'],
		":UserLoged" => $this->Date['XVweb']->Session->Session('Logged_User'),
		":SIDExec" => $this->Date['XVweb']->Session->GetSID()
		));
		
 unset($Online);  

	}
	/************************************************************************************************/
	public function GetLogedCount(){
	//SELECT COUNT(*) AS `UserCount`, SUM(CASE WHEN `userloged` IS NOT NULL THEN 1 ELSE NULL END) AS `LogedUser` FROM `online`
		$OnlineCount = $this->Date['XVweb']->DataBase->prepare('SELECT COUNT(*) AS `OnlineCount`, (SELECT COUNT(*) FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'` WHERE `'.($this->Date['XVweb']->Date['DataBaseOnline']['UserLoged']).'` IS NOT NULL) AS `UserLoged` FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseOnline']['DataBaseOnline']).'`;');
		$OnlineCount->execute();
		$OnlineCount = $OnlineCount->fetchAll();
		return array("OnlineUsers"=>$OnlineCount[0]["OnlineCount"], "LogedUser"=>$OnlineCount[0]["UserLoged"]);
	}
	/************************************************************************************************/
}

?>