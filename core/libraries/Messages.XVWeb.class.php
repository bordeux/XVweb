<?php


class Messages
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function GetList($Date){
			$Date = array_merge(array(
			"ActualPage"=>0, 
			"EveryPage"=>30,
			"SortBy" => 'ID',
			"Desc"=>'desc',
			"User"=>null,
			"AvantFrom"=>"From",
			"Where"=> array(
				"To"=> $this->Date['XVweb']->Session->Session('Logged_User'),
				"Deleted"=> 0,
			)
			), $Date);
			$WhereQuery = array();
			$ExecData = array();
			foreach($Date['Where'] as $key=>$val){
			if($this->Date['XVweb']->DataBase->isset_field("Messages", $key)){
				$Rand = uniqid();
				$WhereQuery[] = ' MT.{Messages:'.$key.'} = :'.$Rand.' ';
				$ExecData[':'.$Rand] = $val;
				}
			}
			
			
			$LLimit = ($Date['ActualPage']*$Date['EveryPage']);
			$RLimit = $Date['EveryPage'];
		$SQLQuery = 'SELECT SQL_CALC_FOUND_ROWS
			{Messages:*:remove:Message:prepend:MT.},
			SUBSTRING(MT.{Messages:ID}, 1, 160) AS `Message`,
			UT.{Users:Avant} AS `Avant` 
			FROM 
			{Messages} AS `MT`,
			{Users} AS `UT`
			WHERE 
				'.implode(' AND ', $WhereQuery).'
				AND 
			UT.{Users:User} =   MT.{Messages:'.$Date['AvantFrom'].'} 
			ORDER BY MT.'.($this->Date['XVweb']->DataBase->isset_field("Messages", $Date['SortBy']) ? '{Messages:'.$Date['SortBy'].'}' : '{Messages:ID}').' '.($Date['Desc'] == "asc" ? "ASC" : "DESC") .' LIMIT '.$LLimit.', '.$RLimit.';';
			$MessagesList = $this->Date['XVweb']->DataBase->prepare($SQLQuery);
			$MessagesList->execute($ExecData);
			return (object) array('List'=> $MessagesList->fetchAll(PDO::FETCH_ASSOC) , "Count"=>$this->Date['XVweb']->DataBase->query('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count);
	}
	public function Get($ID, $User = null){
			if(is_null($User))
			$User = $this->Date['XVweb']->Session->Session('Logged_User');
				
			$SQLQuery = 'SELECT 
			{Messages:*:prepend:MT.},
			UT.{Users:Avant} AS `Avant` 
			FROM
					{Messages} AS `MT`,
					{Users} AS `UT`
			WHERE 
				 MT.{Messages:ID} = :ID 
			AND
				(MT.{Messages:To} = :User or MT.{Messages:From} = :User)
			AND
				UT.{Users:User} =   MT.{Messages:From}  
			';
			$Message = $this->Date['XVweb']->DataBase->prepare($SQLQuery);
				$Message->execute(array(
				':ID'=>$ID,
				':User'=>$User,
				));
			$MessageResult = $Message->fetch(PDO::FETCH_ASSOC);
			if(isset($MessageResult['ID']) && $this->Date['XVweb']->Session->Session('Logged_User') != $MessageResult['From']){
				$this->Date['XVweb']->DataBase->pquery('UPDATE {Messages} 
				SET 
					{Messages:Read} = 1
				WHERE
					{Messages:ID} = '.$MessageResult['ID'].'
				;');
			}
		return $MessageResult;
	}
	public function Send($to, $message, $topic = 'Re: '){
			if(!$this->Date['XVweb']->ReadUser($to))
				return false;
			
			
		$Message = $this->Date['XVweb']->DataBase->prepare('INSERT INTO 
		{Messages}
		({Messages:Date} , {Messages:Topic} , {Messages:From} , {Messages:To} , {Messages:Message} )
		VALUES (NOW(), :Topic, :From, :To, :Message);
		');
				$Message->execute(array(
					':To'=>$to,
					':From'=> $this->Date['XVweb']->Session->Session('Logged_User'),
					':Message'=> $this->Date['XVweb']->TextParser()->CommentParse($message),
					':Topic'=> htmlspecialchars($topic), 
				));
				//$this->Date['XVweb']->Date['URLS']['Script']
				$EmailVars = array(
					);
				$this->Date['XVweb']->SendMail($this->Date['XVweb']->ReadUser['Mail'], '/System/Emails/NewPrivMessage/', $EmailVars);
			return true;
	}
	public function Delete($Item = array()){
	 $DeleteMessages = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Messages} WHERE {Messages:To} = :User AND {Messages:ID} = :ID LIMIT 1;');
	 foreach($Item as $ID){
			$DeleteMessages->execute(array(
				':ID'=>$ID,
				':User'=> $this->Date['XVweb']->Session->Session('Logged_User'),
				));
	 }
	 return true;
	}
	public function Trash($Item = array()){
	 $DeleteMessages = $this->Date['XVweb']->DataBase->prepare('UPDATE {Messages} SET {Messages:Deleted} = 1 WHERE {Messages:To} = :User AND {Messages:ID} = :ID LIMIT 1;');
	 foreach($Item as $ID){
			$DeleteMessages->execute(array(
				':ID'=>$ID,
				':User'=> $this->Date['XVweb']->Session->Session('Logged_User'),
				));
	 }
	 return true;
	}

}

?>