<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   openid.php        *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0                *************************
****************   Authors   :   XVweb team         *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}

class OpenIDLoginClass {
	public function OpenIDLogin(){
	global $URLS;
		if(empty($_POST['openid_url']))
		return false;
		$GLOBALS['XVwebEngine']->LoadOpenIDClass();
		$GLOBALS['XVwebEngine']->OpenID->SetIdentity($_POST['openid_url']);
		$GLOBALS['XVwebEngine']->OpenID->SetTrustRoot($GLOBALS['UrlSite']);
		$GLOBALS['XVwebEngine']->OpenID->SetRequiredFields(array('email','nickname'));
		$GLOBALS['XVwebEngine']->OpenID->SetOptionalFields(array('dob','gender','postcode','country','language','timezone','fullname'));
		if ($GLOBALS['XVwebEngine']->OpenID->GetOpenIDServer()){
			$GLOBALS['XVwebEngine']->OpenID->SetApprovedURL($URLS['Script'].'openid/OpenIDGet/?UrlToRec='.urlencode($_SERVER['HTTP_REFERER'])); 
			$GLOBALS['XVwebEngine']->OpenID->Redirect(); 
		}else{
			$error = $GLOBALS['XVwebEngine']->OpenID->GetError();
			header("location: ".$URLS['Script'].'System/OpenID/Error/?Code='.$error['code'].'&description='.$error['description']);
			exit;
		}
		exit;

		exit;
	}

	public function OpenIDGet(&$GetVars, $NewNick=false){
	global $URLS;
		$GLOBALS['XVwebEngine']->LoadOpenIDClass();
		if(@$GetVars['openid_mode'] == 'id_res'){ 	// Perform HTTP Request to OpenID server to validate key
			$GLOBALS['XVwebEngine']->OpenID->SetIdentity($GetVars['openid_identity']);
			$openid_validation_result = $GLOBALS['XVwebEngine']->OpenID->ValidateWithServer();

			if ($openid_validation_result == true or $NewNick){ 		// OK HERE KEY IS VALID
				try {
					if($GLOBALS['XVwebEngine']->LogginWithOpenID($GetVars)){
						header("location: ".$GetVars['UrlToRec']);
						exit;
					}
				} catch (XVwebException $e) {
					switch ($e->getCode()) {
					case 80:
						$this->ChangeNick();
						exit;
						break;
					case 81:
						header("location: ".$URLS['Script'].'System/OpenID/Error/?Code='.$e->getCode().'&description='.urlencode($e->getMessage()));
						exit;
						break;
					case 82:
						header("location: ".$URLS['Script'].'System/OpenID/EmailIsUsed/?UserUsed='.urlencode($GLOBALS['XVwebEngine']->LogginWithOpenIDVar['User']));
						exit;
						break;
					case 83:
						$this->ChangeNick();
						exit;
						break;
					case 84:
						header("location: ".$URLS['Script'].'System/OpenID/BadEmailAdress/');
						exit;
						break;
					}
					exit('Error '.$e->getCode().' line'.__LINE__);
				}
				exit;
			}else if($GLOBALS['XVwebEngine']->OpenID->IsError() == true){			// ON THE WAY, WE GOT SOME ERROR
				$error = $GLOBALS['XVwebEngine']->OpenID->GetError();
				header("location: ".$URLS['Script'].'System/OpenID/Error/?Code='.$error['code'].'&description='.$error['description']);
				exit;
			}else{											// Signature Verification Failed
				header("location: ".$URLS['Script'].'System/OpenID/InvalidAuth/');
				exit;
			}
		}else if (@$GetVars['openid_mode'] == 'cancel'){ // User Canceled your Request
			header("location: ".$URLS['Script'].'System/OpenID/Caceled/');
			exit;
		}
	}

	public function ChangeNick(){
	global $URLS;
		$GLOBALS['XVwebEngine']->Session->Session('OpenID_SaveTMP', $_GET);
		header("location: ".$URLS['Script'].'openid/ChangeNick/');
		exit;
	}
	public function ChangeNickTheme(){
		$GLOBALS['Smarty']->assign('FormPath', 'OpenID/NewNick');
		$GLOBALS['Smarty']->display('changenick_show.tpl');
	}

	public function ChangeNickFinish(){
		$TmpArray = $GLOBALS['XVwebEngine']->Session->Session('OpenID_SaveTMP');
		$TmpArray['openid_sreg_nickname']  = $_POST['changenick']['Nick'];
		$this->OpenIDGet($TmpArray, true);
		unset($TmpArray);
	}

}

$OpenIDLoginClass = new OpenIDLoginClass;
switch (strtolower($XVwebEngine->GetFromURL($PathInfo, 2))) {
case "openidlogin":
	$OpenIDLoginClass->OpenIDLogin();
	break;
case "openidget":
	$OpenIDLoginClass->OpenIDGet($_GET);
	break;
case "changenick":
	$OpenIDLoginClass->ChangeNickTheme();
	break;
case "newnick":
	$OpenIDLoginClass->ChangeNickFinish();
	break;
default:
	header("location: ".$URLS['Script'].'System/OpenID/');
	exit;
	break;
}

?>