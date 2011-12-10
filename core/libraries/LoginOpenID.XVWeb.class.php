<?php


class OpenIDLogin
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function LogginWithOpenID(&$OpenIDGet){
			if(empty($OpenIDGet['openid_sreg_nickname']) or empty($OpenIDGet['openid_sreg_email']) or empty($OpenIDGet['openid_identity']) ){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(81);
				return false;
			}
			$UserOILoged = $this->Date['XVweb']->DataBase->prepare('SELECT {Users:*} FROM {Users} WHERE {Users:OpenID} = :OpenIDExecute LIMIT 1');
			$UserOILoged->execute(array(':OpenIDExecute' => ($OpenIDGet['openid_identity'])));
			if($UserOILoged->rowCount()){
				$UserOILoged= $UserOILoged->fetchAll();
				$UserOILoged = $UserOILoged[0];
				$this->Date['XVweb']->Session->Session('Logged_Logged', true);
				$this->Date['XVweb']->Session->Session('Logged_ID', $UserOILoged['ID']);
				$this->Date['XVweb']->Session->Session('Logged_User', $UserOILoged['User']);
				$this->Date['XVweb']->Session->Session('Logged_Password', "O:ID:Type");
				$this->Date['XVweb']->Session->Session('Logged_OpenID', $UserOILoged['OpenID']);
				$this->Date['XVweb']->Session->Session('Logged_Admin', $UserOILoged['Admin']);
				$this->Date['XVweb']->Session->Session('Logged_Theme', $UserOILoged['Theme']);
				$this->Date['XVweb']->GetUserLogedAdmin(true);
				$this->Date['XVweb']->Log("LoggedUser", "ByOpenID:".$UserOILoged['User']);
				return true; 
			}

			if($this->Date['XVweb']->ReadUser($OpenIDGet['openid_sreg_nickname'])){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(80);
				return false;
			}
			$CheckMail = $this->Date['XVweb']->DataBase->prepare('SELECT {Users:User} FROM {Users} WHERE  {Users:Mail} = :MailExecute LIMIT 1');
			$CheckMail->execute(array(':MailExecute' => ($OpenIDGet['openid_sreg_email'])));
			if($CheckMail->rowCount()){
				$User= $CheckMail->fetchAll();
				$User = $User[0];
				$this->Date['XVweb']->LogginWithOpenIDVar['User'] = $User['User'];
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(82);
				return false; 
			}
			if(!preg_match("/^([a-zA-Z0-9 _-])+$/i",  $OpenIDGet['openid_sreg_nickname'])){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(83); //niedozwolone zanki
				return false; 
			}
			if(!preg_match("/^[^@]*@[^@]*\.[^@]*$/", $OpenIDGet['openid_sreg_email'])){
				$this->Date['XVweb']->LoadException();
				throw new XVwebException(84);
				return false; // zly mail;
			}

			$RegisterOpenID = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Users} ({Users:User}, {Users:Mail}, {Users:Creation}, {Users:IP}, {Users:Admin}, {Users:OpenID}) VALUES (:UserExecute , :EmailExecute, NOW(), :IPExecute , :AdminExecute , :OpenIDExecute );');
			$FinnalRegisterOpenIDReturn = $RegisterOpenID->execute(
			array(
				':UserExecute' => ($OpenIDGet['openid_sreg_nickname']),
				':EmailExecute' => ($OpenIDGet['openid_sreg_email']),
				':IPExecute' => ($this->Date['XVweb']->IP),
				':AdminExecute' => ($this->Date['XVweb']->Config("config")->find("config rank openid")->html()),
				':OpenIDExecute' => ($OpenIDGet['openid_identity'])
			)
			);
			$this->Date['XVweb']->Session->Session('Logged_Logged', true);
			$this->Date['XVweb']->Session->Session('Logged_ID',  $this->Date['XVweb']->DataBase->lastInsertId());
			$this->Date['XVweb']->Session->Session('Logged_User', ($OpenIDGet['openid_sreg_nickname']));
			$this->Date['XVweb']->Session->Session('Logged_Password', "O:ID:Type");
			$this->Date['XVweb']->Session->Session('Logged_OpenID', ($OpenIDGet['openid_identity']));
			$this->Date['XVweb']->Session->Session('Logged_Admin', ($this->Date['XVweb']->Config("config")->find("config rank openid")->html()));
			$this->Date['XVweb']->Session->Session('Logged_Theme', Site_Theme);
			$this->Date['XVweb']->Log("LoggedUser", "ByNewOpenID:".($OpenIDGet['openid_sreg_nickname']));
			return true;

	}
}

?>