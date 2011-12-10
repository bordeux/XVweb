<?php


class LostPassword
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function FirstStep($Mail){
		$ReadSQLUser = $this->Date['XVweb']->DataBase->prepare('SELECT
		{Users:ID} as `ID`,
		{Users:User} as `User`,
		{Users:Mail} as `Mail`,
		{Users:Password} as `Password`
		FROM {Users} WHERE  {Users:Mail}= :MailExecute LIMIT 1');
			$ReadSQLUser->execute(array(':MailExecute' => trim($Mail)));
			if(!($ReadSQLUser->rowCount())){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(6); // nie istnieje mail
				return false;
			}
			
			$ReadUser = $ReadSQLUser->fetchAll();
			$ReadUser = $ReadUser[0];
			
			
	$UrlReset = $this->Date['XVweb']->SrvLocation.'LostPass/Reset/'.($this->Date['XVweb']->URLRepair($ReadUser['User'])).'/'.md5(MD5Key.$ReadUser['Password'].$ReadUser['ID']).'/';
	
			if(($this->Date['XVweb']->ReadArticle("/System/ResetPassword/Step1/"))){
			$MailContent = $this->Date['XVweb']->ParseArticleContents();
	
			$MailContent = strtr($MailContent, array("{{link}}"=> $UrlReset, "{{user}}"=>$ReadUser['User'], "{{userID}}"=>$ReadUser['ID'], "{{usermail}}"=>$ReadUser['Mail'], "{{serwis}}"=> $this->Date['XVweb']->SrvName));
			
			if(!$this->Date['XVweb']->MailClass()->mail($ReadUser['Mail'], $this->Date['XVweb']->ReadArticleOut['Topic'], $MailContent)){
				if(!($this->Date['XVweb']->ReadArticle("/System/ResetPassword/Step1MSG/"))){
					$this->Date['XVweb']->LoadException();
					throw new XVwebException(5); // nie istnieje mail
					return false;
				}
				$this->Date['MSG'] = $this->Date['XVweb']->ParseArticleContents();
			return true;
			} else{
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(3); // problem z mailem
				return false;
			}
			
			}else{
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(5); 
				return false;
			}
	
	}
	function SecondStep($User, $ValidationCode){
	if(!$this->Date['XVweb']->ReadUser($User)){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(6); // nie istnieje user
			return false;
		}
	$Key = md5(MD5Key.$this->Date['XVweb']->ReadUser['Password'].$this->Date['XVweb']->ReadUser['ID']);
		if($ValidationCode == $Key){
		$NewPassword = substr(md5(uniqid(mt_rand(), true)), 0 ,6);
					if(($this->Date['XVweb']->ReadArticle("/System/ResetPassword/Step3/"))){
			$MailContent = $this->Date['XVweb']->ParseArticleContents();
	
			$MailContent = strtr($MailContent, array("{{user}}"=>$this->Date['XVweb']->ReadUser['Nick'], "{{userid}}"=>$this->Date['XVweb']->ReadUser['ID'], "{{usermail}}"=>$this->Date['XVweb']->ReadUser['Mail'], "{{password}}"=>$NewPassword, "{{serwis}}"=>$this->Date['XVweb']->SrvName));
						$this->Date['XVweb']->EditUserInit()->Date['OffSecure']= true;
						$this->Date['XVweb']->EditUserInit()->Init($this->Date['XVweb']->ReadUser['Nick']);
						$this->Date['XVweb']->EditUserInit()->set("Password", md5(MD5Key.$NewPassword));
						$this->Date['XVweb']->EditUserInit()->execute();
						
			if(!$this->Date['XVweb']->MailClass()->mail($this->Date['XVweb']->ReadUser['Mail'], $this->Date['XVweb']->ReadArticleOut['Topic'], $MailContent)){
			return true;
			} else{
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(3); // problem z mailem
				return false;
			}
			
			
			}else{
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(5); // nie istnieje art
				return false;
			}
			
		
		}else
				return false;
		
	}
}

?>