<?php


class EditUserClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$this->Date['Log'] = true;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function Init($User, $IsID=false){
		$this->Date['Error']= false;
		if(!$this->Date['OffSecure']){
		if(    (!$this->Date['XVweb']->permissions('EditProfil')    &&     $User != ($this->Date['IsID'] ? $this->Date['XVweb']->Session->Session('Logged_ID') : $this->Date['XVweb']->Session->Session('Logged_User')))     or       (!$this->Date['XVweb']->permissions('EditOtherProfil'))) {
			$this->Date['Error']= true;
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(1);
		}
		}
		$this->Date['IsID'] = false;
		if($IsID)
		$this->Date['IsID'] = true;
		$this->Date['User'] = $User;
	}
	public function set($Key, $Value){

		if($this->Date['Error'])
		return false;
		if(!$this->Date['XVweb']->DataBase->isset_field('Users', $Key))
		return false;		
		$this->Date['UpdateSQL'][] = "{Users:".$Key."} = :".$Key.'Exec';
		$this->Date['ExecPDO'][':'.$Key.'Exec'] = $Value;
	}
	
	public function execute(){
		if(!is_array($this->Date['UpdateSQL']))
		return false;
		if($this->Date['Error']==true)
		return false;
		
		$this->Date['ExecPDO'][':UpdateIDExec'] = $this->Date['User'];
		$SaveUpdate = $this->Date['XVweb']->DataBase->prepare('UPDATE {Users} SET '.$this->ToSQL().' WHERE '.($this->Date['IsID']? '{Users:ID}' : '{Users:User}' ).' = :UpdateIDExec ;');
		$SaveUpdate->execute($this->Date['ExecPDO']);
		if($this->Date['Log'])
		$this->Date['XVweb']->Log("EditProfile", array("User"=>$this->Date['User'], "By"=>$this->Date['XVweb']->Session->Session('Logged_User')));
		 $this->Date['XVweb']->Cache->clear("Users", $this->Date['User']); // Cache->clear -> convert to id->UserName
		return true;
	}
	
	function ToSQL()
	{
		return  implode(", ", $this->Date['UpdateSQL']);
		return "";
	}
	
	public function validate_url($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}  
	
}

?>