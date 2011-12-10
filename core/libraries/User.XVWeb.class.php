<?php
/*
CREATE TABLE `session` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`sid` VARCHAR( 33 ) NOT NULL ,
`ip` VARCHAR( 50 ) NOT NULL ,
`Name` VARCHAR( 200 ) NOT NULL ,
`Value` TEXT NOT NULL ,
`Time` VARCHAR( 15 ) NOT NULL ,
INDEX ( `id` )
) */

class UsersClass
{
	var $Date;

	public function __construct(&$XVweb) {
		$this->Date['XVweb'] = &$XVweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function set($var, $value){
		$this->Date[$var] = $value;
		return true;
	}

	public function get($var){
		return (empty($this->Date[$var])?null :$this->Date[$var]) ;
	}


	public function ReadUser($User = null){
			if(!is_null($User))
				$this->Date['ReadUser']['User'] = $User;
			
			if($this->Date['XVweb']->Cache->exist("Users", $this->Date['ReadUser']['User'])){
			$this->Date['ReadUser'] =  $this->Date['XVweb']->Cache->get();
			return true;
			}
			
			$ReadSQLUser = $this->Date['XVweb']->DataBase->prepare('SELECT {Users:*} FROM {Users} WHERE  {Users:User} = :UserExecute LIMIT 1');
			$ReadSQLUser->execute(array(':UserExecute' => $this->Date['ReadUser']['User']));
			if(!($ReadSQLUser->rowCount())){
				return false;
			}
			$this->Date['ReadUser'] = $ReadSQLUser->fetch();
			$this->Date['ReadUser']['Nick'] = $this->Date['ReadUser']['User'];
			$this->Date['ReadUser']['GG'] =$this->Date['ReadUser']['GaduGadu'];
			
			$this->Date['XVweb']->Cache->put("Users", $this->Date['ReadUser']['User'], $this->Date['ReadUser']); //!Cache
			return true;
	}



	public function ActivateUser($User, $temppass){

		if(!$this->ReadUser($User))
			return false;
		if($this->Date['ReadUser']['RegisterCode'] != $temppass)
			return false;
		$ActivateUserSQL = $this->Date['XVweb']->DataBase->prepare('UPDATE {Users}  SET  {Users:RegisterCode} = 1  WHERE {Users:ID} = :IDExecute');
		$ActivateUserSQL->execute(array(':IDExecute' => $this->Date['ReadUser']['ID']));
		return true;
	}
	public function ModificationCount($User=null){
			$UserEx = (is_null($User) ? $this->Date['ReadUser']['Nick']  : $User);
			if($this->Date['XVweb']->Cache->exist("ModCount", $User))
				return $this->Date['XVweb']->Cache->get();
			
			$CountMod = $this->Date['XVweb']->DataBase->prepare('SELECT count(*) AS `CountMod` FROM {Articles} WHERE  {Articles:Author} = :UserExecute ;');
			$CountMod->execute(array(':UserExecute' => $UserEx));
			$Count = $CountMod->fetch();
			return $this->Date['XVweb']->Cache->put("ModCount", $User, $Count['CountMod']); //!Cache
	}



}

?>