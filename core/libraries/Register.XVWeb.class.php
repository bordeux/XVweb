<?php


class Register
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function set($Informations=array()){
	if(!preg_match("/^([a-zA-Z0-9 _-])+$/i",  $Informations['User'])){
		$this->Date['Error'] = "IllegalCharacters";
	return false; 
	}
	
	if (!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/", $Informations['Mail'])){
				$this->Date['Error'] = "BadMail";
				return false;
	}

				$CheckUser = $this->Date['XVweb']->DataBase->prepare('SELECT * FROM {Users} WHERE  {Users:User} = :UserExecute');
			$CheckUser->execute(array(':UserExecute' => $Informations['User']));
			if($CheckUser->rowCount()){
				$this->Date['Error'] = "IssetUser";
				return false;
			}
	
	$this->Date['XVweb']->InitClass("BanClass")->CheckBanned();
	$CheckBan = $this->Date['XVweb']->InitClass("BanClass")->CheckBanned($Informations['Mail']);
			if($CheckBan){
				$this->Date['BanTimeOut'] = $CheckBan;
				$this->Date['Error'] = "UserIsBanned";
				return false; 
			}

			$CheckMail = $this->Date['XVweb']->DataBase->prepare('SELECT {Users:User} AS `User` FROM {Users} WHERE  {Users:Mail} = :MailExecute LIMIT 1');
			$CheckMail->execute(array(':MailExecute' => ($Informations['Mail'])));
			if($CheckMail->rowCount()){
				$User= $CheckMail->fetch();
				$User = $User['User'];
				$this->Date['MailUsedBy'] = $User;
				$this->Date['Error'] = "MailUsed";
				return false; 
			}
			
			$SQLQuery = array("VALUES"=>array(), "KEYS"=>array(), "EXECUTE"=>array());
			foreach($Informations as $key=>$value){
				if($this->Date['XVweb']->DataBase->isset_field("Users", $key)){
				$SQLQuery['KEYS'][] =  '{Users:'.$key.'}';
				$SQLQuery['VALUES'][] =  '{{'.$key.'}}';
				$SQLQuery['EXECUTE']['{{'.$key.'}}'] =  $this->Date['XVweb']->DataBase->quote($value);
				}
			}
			
			$Query = 'INSERT INTO {Users}
				( '.implode(' , ', $SQLQuery['KEYS'] ).' )
			VALUES( '.implode(' , ', $SQLQuery['VALUES'] ).' ) ;';
			$Query =  strtr($Query,$SQLQuery['EXECUTE']);
			$FinnalRegister = $this->Date['XVweb']->DataBase->pquery($Query);
			if(!$FinnalRegister){
				$this->Date['Error'] = "Error";
				return false; 
			}
			$Informations['ID'] = $this->Date['XVweb']->DataBase->lastInsertId();
			$SQLQuery['EXECUTE']['{{ID}}'] = $Informations['ID'];
			
		$SQLQuery['EXECUTE']['{{user}}'] = $Informations['User'];
		$SQLQuery['EXECUTE']['{{sitename}}'] = $this->Date['XVweb']->SrvName;
		$SQLQuery['EXECUTE']['{{link}}'] = ($GLOBALS['URLS']['Script'])."Register/?activate&amp;login=".($this->Date['XVweb']->URLRepair($Informations['User']))."&amp;temppass=".$Informations['RegisterCode'];
		if( $Informations['RegisterCode'] != 1)
		$this->Date['XVweb']->SendMail($Informations['Mail'], '/System/Register/', $SQLQuery['EXECUTE']);
		
		
		$this->Date['XVweb']->Log("NewUser", $Informations);
	return true;
	}

}

?>