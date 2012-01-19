<?php

class xvDB extends PDO
{
	public $query = array();
	public $Data = array();
	public $dbPrefix = '';
	public $Tables = array();
	public $TablesOrgName = array();
	public function __construct(&$XVWeb){
		$this->Data['XVWeb'] = &$XVWeb;
		$this->dbPrefix = $this->Data['XVWeb']->Config('db')->find('config dbprefix')->text();
		return @parent::__construct('mysql:host='.($this->Data['XVWeb']->Config('db')->find('config host')->text()).';dbname='.(($this->Data['XVWeb']->Config('db')->find('config dbname')->text())), ($this->Data['XVWeb']->Config('db')->find('config user')->text()), ($this->Data['XVWeb']->Config('db')->find('config password')->text()), 
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
		);
	}
	public function loadTable($table){
	if(isset($this->Tables[$table]))
		return true;
		
		
		$tablePQ = $this->Data['XVWeb']->Config('db')->find('tables table#'.$table);
		$this->TablesOrgName[$table] = $tablePQ->attr("name");
		
		foreach($tablePQ->find("field") as $field)
			$this->Tables[$table][$field->getAttribute("id")] = $field->getAttribute("name");
			
		//var_dump($this->TablesOrgName);
		//exit;
	}
	public function ReplaceKeys($matched){
		$matched = explode(":", $matched[1]);

		$this->loadTable($matched[0]);
		
		if(!isset($matched[1])){
			return '`'.$this->dbPrefix.ifsetor($this->TablesOrgName[$matched[0]], "|NO EXSIST TABLE ".$matched[0]."|").'`';
		}
		$Prepend = (ifsetor($matched[2], "") == "prepend" ?  $matched[3] : '');

		if($matched[1] == "*"){
			$Result = array();
			$ToRemove = array();
			if(ifsetor($matched[2], "") == "remove"){
				$ToRemove = array_flip(explode("|", $matched[3]));
				$Prepend = (ifsetor($matched[4], "") == "prepend" ?  $matched[5] : '');
			}

			foreach($this->Tables[$matched[0]] as $tbname=>$dbfield){
				$Result[] =  $Prepend.'`'.$dbfield.'` AS `'.$tbname.'`';
			}
			return implode(", \n", $Result);
		}
		
		$field = ifsetor($this->Tables[$matched[0]][$matched[1]] , "|NOT FOUND FIELD ".$matched[1]."|"); //$this->Data['XVWeb']->Config('db')->find('tables table#'.$matched[0].'  field#'.$matched[1])->attr("name");
		return '`'.$field.'`';
	}
	public function isset_field($table, $key){
		return $this->Data['XVWeb']->Config('db')->find('tables table#'.$table.'  field#'.$key)->length;
	}
	public function get_fields($table){
		$Fields = array();
		foreach($this->Data['XVWeb']->Config('db')->find('tables table#'.$table.'  field') as $field){
			$fieldTMP = pq($field);
			$Fields[$fieldTMP->attr("id")] = $fieldTMP->attr("name");
		}
		return $Fields;
	}
	
	public function PrepareQuery($query){
		return preg_replace_callback(
		"/{(.*?)}/si",
		array($this, "ReplaceKeys"),
		$query);
	}
	public function prepare( $statement, $driver_options = array() )
	{
		$statement = $this->PrepareQuery($statement);
		$this->query[] = $statement;
		return parent::prepare( $statement, $driver_options = array() );
	}
	public function pquery( $statement){
		$statement = $this->PrepareQuery($statement);
		$this->query[] = $statement;
		$FuncArgs = func_get_args();
		$FuncArgs[0] = $statement;
		try {
			$Result =  call_user_func_array(array('parent', 'query'), $FuncArgs); 
		}catch (PDOException $objException) {
		$BackTrack = debug_backtrace();
		$BackTrack = ($BackTrack[0]);
		
		$ErrorInfo[] = array("Message"=>"ErrorMessage", "value"=> $objException->getMessage());
		$ErrorInfo[] = array("Message"=>"ErrorCode", "value"=> $objException->getCode());
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
		$ErrorInfo[] = array("Message"=>"ErrorLine", "value"=> $BackTrack['line']);
		$ErrorInfo[] = array("Message"=>"ErrorTime", "value"=> date("y.m.Y H:i:s:u"));
		$ErrorInfo[] = array("Message"=>"ClientIP", "value"=> $_SERVER['REMOTE_ADDR']);
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
		$this->Data['XVWeb']->ErrorClass($ErrorInfo);
		
		return false;
		}
		
	return $Result;
	}
	public function last_query()
	{
		return end($this->query);
	}
	
}


class xvDB_statement extends PDOStatement
{
   protected $pdo;
   var $Data = array();
   protected function __construct(&$pdo, $XVWeb){
     $this->pdo = &$pdo;
	 $this->Data['XVWeb'] = &$XVWeb;
	 $this->Data['PDOException'] = false;
   }
   
  public function execute()
  {
		$FuncArgs = func_get_args();
		try {
		$ExecTimeStart = microtime_float();
			$Result =  call_user_func_array(array('parent', 'execute'), $FuncArgs); 
		$this->pdo->query[sizeof($this->pdo->query)-1] .= " {xv{TimeExecute: ".(microtime_float()-$ExecTimeStart) ."}xv}";
		}catch (PDOException $objException) {
		if($this->Data['PDOException']){
			$this->Data['PDOException'] = false;
			throw $objException;
			return $Result;
		}
		$BackTrack = debug_backtrace();
		$BackTrack = ($BackTrack[0]);
		$ErrorInfo[] = array("Message"=>"ErrorMessage", "value"=> $objException->getMessage());
		$ErrorInfo[] = array("Message"=>"ErrorCode", "value"=> $objException->getCode());
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
		$ErrorInfo[] = array("Message"=>"ErrorLine", "value"=> $BackTrack['line']);
		$ErrorInfo[] = array("Message"=>"ErrorTime", "value"=> date("y.m.Y H:i:s:u"));
		$ErrorInfo[] = array("Message"=>"ClientIP", "value"=> $_SERVER['REMOTE_ADDR']);
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
		$this->Data['XVWeb']->ErrorClass($ErrorInfo);
		return false;
		}
	return $Result;

  }
  public function PDOException(){
	$this->Data['PDOException'] = true;
  }

}



?>