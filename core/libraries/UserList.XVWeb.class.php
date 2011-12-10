<?php
class UserListClass
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function UserList($Date = array()){
			$Date = array_merge(array("ActualPage"=>0, "EveryPage"=>30), $Date);
			$DateExecute = array(
			);
			if(!is_numeric($Date["ActualPage"]) or !is_numeric($Date["EveryPage"])){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(100);
			}
			
$this->Date['XVweb']->Date['UserSortBy'] = "User";
			$UserList = $this->Date['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
{Users:ID} AS `ID` ,  
{Users:User} AS `User` , 
{Users:OpenID} AS `OpenID` , 
{Users:GaduGadu} AS `GaduGadu` , 
{Users:Skype} AS `Skype` , 
{Users:Creation} AS `Creation` , 
{Users:WhereFrom} AS `WhereFrom` , 
{Users:Languages} AS `Language`,
{Users:Avant} AS `Avant`
FROM {Users} '.($this->Date['XVweb']->DataBase->isset_field("Users", $this->Date['XVweb']->Date['UserSortBy']) > 0 ? 'ORDER BY {Users:'.$this->Date['XVweb']->Date['UserSortBy'].'}  '.($this->Date['XVweb']->Date['UserSort']=="asc"?"DESC":"ASC") : "" ).' LIMIT '.($Date["ActualPage"]*$Date["EveryPage"]).', '.($Date["EveryPage"]).' ;');

			$UserList->execute($DateExecute);
			return array($UserList->fetchAll(), $this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `SearchCount`;')->fetch(PDO::FETCH_OBJ)->SearchCount); 

	}

}

?>