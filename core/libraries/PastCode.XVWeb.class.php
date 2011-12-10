<?php
class PastCode
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		
		$this->Date['XVweb']->Date['DataBasePastCode'] = array(
		"DataBasePastCode" => 'pastcode',
		"ID" => 'id',
		"Date" => 'date',
		"Expired" => 'expired',
		"User" => 'user',
		"Type" => 'type',
		"IP" => 'ip',
		"Code" => 'code',
		"Counter" => 'counter'
		);
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function add(){
	
	}
	
	public function get(){
	
	}
	
	public function delete(){
	
	}

}

?>