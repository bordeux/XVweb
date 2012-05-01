<?php

class SessionClass
{
	var $CookieName = "xv_session";
	var $Cookie = array();
	var $Server = array();
	var $Session = array();
	var $SaveSession = array();
	var $SID;
	var $Date;
	var $expire = 1800;


	function __construct(&$XVweb) {
		$this->Date['SessionIsset'] = false;
		$this->Date['XVweb'] =& $XVweb;

		if(isset($_COOKIE[$this->CookieName])){
			$this->SID =& $_COOKIE[($this->CookieName)];
			$GetSession = $this->Date['XVweb']->DataBase->prepare('SELECT {Sessions:Value} AS `Serialized` FROM {Sessions} WHERE {Sessions:SID} = :SIDExecute AND  {Sessions:IP} = :IPExecute; ');
			$GetSession->execute(
			array(
				":SIDExecute" => $this->SID,
				":IPExecute" => $_SERVER['REMOTE_ADDR']
			)
			);

			if ($this->Session = unserialize($GetSession->fetch(PDO::FETCH_OBJ)->Serialized)) {
				$this->Date['SessionIsset'] = true;
			}
		}else{
			$SidRandomCookie = md5(MD5Key.mt_rand(0, mt_getrandmax()));
			setcookie(($this->CookieName), $SidRandomCookie, 0, "/");
			$this->SID = $SidRandomCookie;
			$this->Date['Mod'] = true;
		}

		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function Session($Name = null, $value = null){
		
		if(is_null($Name)){
			return $this->Session;
		}
		if(is_null($value)){
			if(isset($this->Session[$Name]))
			return $this->Session[$Name];
			return null;
			
		}else{
			$this->Date['Mod'] = true;
			$this->Session[$Name] = ($value);
			$this->Session['LastUpdate'] = time();
			return true;
		}
		return null;
		
	}
	public function delete($name){
		unset($this->Session[$name]);
		$this->Date['Mod'] = true;
		return true;
	}

	public function Clear(){
		$SQLQuerySession = 'DELETE FROM {Sessions} WHERE {Sessions:SID} = :SIDExecute AND {Sessions:IP} = :IPExecute ;';
		$SQLPDOPrepare[':SIDExecute'] = ($this->SID);
		$SQLPDOPrepare[':IPExecute'] = ($_SERVER['REMOTE_ADDR']);
		$SQLQuerySessionPDO = $this->Date['XVweb']->DataBase->prepare($SQLQuerySession);
		$SQLQuerySessionPDO->execute($SQLPDOPrepare);
		__construct;
	}
	public function __destruct()
	{
		try {

			if(isset($this->Session['LastUpdate']) && ($this->Session['LastUpdate']+($this->expire/3)) < time()){
				$this->Date['XVweb']->DataBase->prepare('UPDATE {Sessions} SET {Sessions:Time} = :Time WHERE {Sessions:SID} = "'.$this->SID.'";')->execute(array(":Time"=>time())); 
			}
			$SQLQuerySession  =null;
			$SQLPDOPrepare  =null;
			$Time = time();
			$SQLParms = array();
			if($this->Date['Mod']){
				$SQLParms[":ExecSession"] = &serialize($this->Session);
				$SQLParms[":IPExecute"] = $_SERVER['REMOTE_ADDR'];
				$SQLParms[":SIDExecute"] = $this->SID;
				$SQLParms[":Time"] = $Time;
				if($this->Date['SessionIsset']){
					$SQLSaveSession = 'UPDATE {Sessions} SET {Sessions:Time} = :Time , {Sessions:Value} = :ExecSession WHERE {Sessions:SID} = :SIDExecute AND {Sessions:IP} = :IPExecute;'.PHP_EOL;
				} else{
					$SQLSaveSession = 'INSERT INTO {Sessions} ( {Sessions:SID} , {Sessions:IP} , {Sessions:Value} , {Sessions:Time}) VALUES ( :SIDExecute , :IPExecute, :ExecSession , :Time)  ON DUPLICATE KEY UPDATE  {Sessions:IP} = :IPExecute ,  {Sessions:Value} = :ExecSession  ,  {Sessions:Time} = :Time;'.PHP_EOL;
				}
			}
			$SQLSaveSession .= 'DELETE FROM {Sessions} WHERE {Sessions:Time} < '.(time() - $this->expire).';'.PHP_EOL;
			$SQLQuery = $this->Date['XVweb']->DataBase->prepare($SQLSaveSession);
			$SQLQuery->execute($SQLParms);
			$SQLQuery->closeCursor();
			

		} catch (Exception $e) {
			$this->Date['XVweb']->ErrorClass($e);
			return false;
		}

	}
	public function GetSID(){
		return $this->SID;
	}	
	
	public function update_user_session($user, $field, $val){
		$string_to_search = '"Logged_User";'.serialize($user);
		$select_sessions = $this->Date['XVweb']->DataBase->prepare('
			SELECT {Sessions:*} FROM {Sessions} WHERE {Sessions:Value} LIKE :like
		');
		$select_sessions->execute(array(
				":like" => '%'.$string_to_search.'%',
			));
		$select_sessions = $select_sessions->fetchAll();
		
		$update_session = $this->Date['XVweb']->DataBase->prepare('
			UPDATE {Sessions} SET {Sessions:Value} = :val WHERE  {Sessions:SID}  = :sid LIMIT 1;
		');	
		foreach($select_sessions as $session){
		$updated_count = 0;
			$session_val = unserialize($session['Value']);
			if($session_val['Logged_User'] == $user){
				$session_val[$field] = $val;
				$update_session->execute(array(
					":val" => serialize($session_val),
					":sid" => $session['SID']
				));
				++$updated_count;
			}
		return $updated_count;
		}
		
	}

}

?>