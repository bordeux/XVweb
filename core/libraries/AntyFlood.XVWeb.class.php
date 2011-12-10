<?php


class AntyFlood
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		if(!isset($this->Date['XVweb']->Date['DataBaseAntyFlood'])){
			$this->Date['XVweb']->Date['DataBaseAntyFlood']  = array(
				"DataBaseAntyFlood" => 'antyflood',
				"IP" => 'ip',
				"TimeOut" => 'timeout',
				"Type" => 'type'
				);
			}
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
public function check($type, $ip=null){
$IPSQL = (is_null($ip) ? $_SERVER['REMOTE_ADDR'] : $ip);
		if($this->Date['XVweb']->permissions('AntyFloodImmunitet'))
			return 0;
		
				$AntyFloodSql = $this->Date['XVweb']->DataBase->prepare('SELECT `'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['TimeOut']).'` FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseAntyFlood']['DataBaseAntyFlood']).'` WHERE `'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['IP']).'` = :IPExecute AND `'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['TimeOut']).'` > :TimeExecute AND `'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['Type']).'` = :TypeExecute LIMIT 1');

				$AntyFloodSql->execute(
				array(
				':IPExecute' => ($IPSQL),
				':TypeExecute' => ($type),
				':TimeExecute' => date('dmyhis')
				)
				);
		if(($AntyFloodSql->rowCount())){
				$AntyFloodTimeOut = $AntyFloodSql->fetchAll();
				$AntyFloodTimeOut = $AntyFloodTimeOut[0];
				$AntyFloodTimeOut = $AntyFloodTimeOut[($this->Date['XVweb']->Date['DataBaseAntyFlood']['TimeOut'])];
				$this->Date['TimeOut'] = $AntyFloodTimeOut-(date('dmyhis'));
				return $this->Date['TimeOut'];
			} else 
				return false;
				
}

public function add($type, $time=300, $ip=null){
$IPSQL = (is_null($ip) ? $_SERVER['REMOTE_ADDR'] : $ip);
		if($this->Date['XVweb']->permissions('AntyFloodImmunitet'))
			return true;
			
			return true;//bug
			
				$AntyFloodAddSql = $this->Date['XVweb']->DataBase->prepare(' DELETE FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseAntyFlood']['DataBaseAntyFlood']).'` WHERE (`'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['TimeOut']).'` < :PresentTimeExecute) or (`'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['Type']).'` = :TypeExecute AND `'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['IP']).'` = :IPExecute); INSERT INTO `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Date['DataBaseAntyFlood']['DataBaseAntyFlood']).'` (`'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['IP']).'`,`'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['TimeOut']).'`,`'.($this->Date['XVweb']->Date['DataBaseAntyFlood']['Type']).'`) VALUES (:IPExecute, :TimeExecute, :TypeExecute);');
				$AntyFloodAddSql->execute(
				array(
				':IPExecute' => ($IPSQL),
				':TimeExecute' => ((date('dmyhis'))+$time),
				':TypeExecute' => ($type),
				':PresentTimeExecute' => (date('dmyhis'))
				)
				);
				$AntyFloodAddSql->closeCursor();
return true;
}



}

?>