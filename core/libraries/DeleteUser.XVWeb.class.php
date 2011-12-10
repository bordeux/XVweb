<?php


class DeletUserClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		
		
		if(!$this->Date['XVweb']->permissions('DeleteUser')){
			$this->Date['Error']= true;
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(1);
		}
	}

	public function DeletUserByID(&$Xvweb) {
		return $this->_deletUser($UserName, true);
	}
	public function DeletUserByNick($UserName) {
		return $this->_deletUser($UserName);
	}
	public function DeletUserByMail($UserMail) {
		$DeleteSQLUser = $this->Date['XVweb']->DataBase->prepare('DELETE FROM  {Users} WHERE  {Users:Mail} = :MailExecute LIMIT 1 ;');
		$DeleteSQLUser->execute(array(':MailExecute' => $UserMail));
		$this->Date['XVweb']->Log("DeleteUser", array("ByMail"=>$UserMail));
		return true;
	}

	public function DeletUserByLikeNick($UserLike) {
		$DeleteSQLUser = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Users} WHERE  {Users:User} LIKE :UserLikeExecute LIMIT 1 ;');
		$DeleteSQLUser->execute(array(':UserLikeExecute' => $UserLike));
		$this->Date['XVweb']->Log("DeleteUser", array("ByLikeNick:"=>$UserLike));
		return true;
	}
	public function DeletUserByLikeMail($UserMail) {
		$DeleteSQLUser = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Users} WHERE  {Users:Mail} LIKE :MailExecute LIMIT 1 ;');
		$DeleteSQLUser->execute(array(':MailExecute' => $UserMail));
		$this->Date['XVweb']->Log("DeleteUser", "ByLikeMail:".$UserMail);
		return true;
	}
	public function _deletUser($User, $ByID=false) { // ToDo
			if($ByID){
				if(!is_numeric($ByID))
				return false;
				$DeleteSQLUser = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Users} WHERE  {Users:ID} = '.$ByID.' LIMIT 1 ;');
				$DeleteSQLUser->execute();
				$this->Date['XVweb']->Log("DeleteUser", array("ByID:"=>$ByID));
				return true;
			}
			
			$DeleteSQLUser = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Users} WHERE  {Users:User} = :UserExecute LIMIT 1 ;');
			$DeleteSQLUser->execute(array(':UserExecute' => $User));
			$this->Date['XVweb']->Log("DeleteUser", array("ByNick:"=>$User));
			return true;
	}
	
}

?>