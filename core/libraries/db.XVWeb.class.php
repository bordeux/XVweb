<?php
if (!class_exists('db_config')) {
	class db_config extends  xv_config {};
}

class xvDB extends PDO
{
	public $query = array();
	public $Data = array();
	public $dbPrefix = '';
	public $Tables = array();
	public $TablesOrgName = array();
	public $db_config = array();
	public function __construct(&$XVWeb){
		$this->Data['XVWeb'] = &$XVWeb;
		$this->db_config = new db_config();
		$this->dbPrefix = $this->db_config->db_prefix;
		return @parent::__construct('mysql:host='.($this->db_config->db_host).';dbname='.($this->db_config->db_name), ($this->db_config->db_user), ($this->db_config->db_password), 
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
		);
	}
	public function replace_keys($matched){
		$matched = explode(":", $matched[1]);
		if(!is_array($this->db_config->db_tables[$matched[0]])){
			return "|NO EXSIST TABLE ".$matched[0]."|";
		}
		if(!isset($matched[1])){
				return '`'.$this->dbPrefix.$this->db_config->db_tables[$matched[0]]['name'].'`';
		}
		
		$prepend = (ifsetor($matched[2], "") == "prepend" ?  $matched[3] : '');

		if($matched[1] == "*"){
			$Result = array();
			$to_remove = array();
			if(ifsetor($matched[2], "") == "remove"){
				$to_remove = array_flip(explode("|", $matched[3]));
				$prepend = (ifsetor($matched[4], "") == "prepend" ?  $matched[5] : '');
			}
			foreach($this->db_config->db_tables[$matched[0]]['fields'] as $tb_name=>$tb_field){
				$Result[] =  $prepend.'`'.$tb_field.'` AS `'.$tb_name.'`';
			}
			return implode(", \n", $Result);
		}
		
			$field = ifsetor($this->db_config->db_tables[$matched[0]]['fields'][$matched[1]] , "|NOT FOUND FIELD ".$matched[1]."|"); 
		return '`'.$field.'`';
	}
	public function isset_field($table, $key){
		return isset($this->db_config->db_tables[$table]['fields'][$key]);
	}
	public function get_fields($table){
		return $this->db_config->db_tables[$table]['fields'];
	}
	
	public function PrepareQuery($query){
		return preg_replace_callback(
		"/{(.*?)}/si",
		array($this, "replace_keys"),
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