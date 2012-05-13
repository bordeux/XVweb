<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
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

xv_load_lang('user');
if(!empty($UserFromUrl)){
	if(!$XVwebEngine->ReadUser($UserFromUrl)){
		header("location: ".$URLS['Script'].'System/UserDoesNotExist/');
		exit;
	}
	if(isset($_GET['delete'])){
		if($_GET['SIDCheck'] == $XVwebEngine->Session->GetSID() && $XVwebEngine->ReadUser['ID']!=1)
		$XVwebEngine->DeleteUser()->DeletUserByNick($XVwebEngine->ReadUser['User']);
		header("location: ?");
		exit;
	}
	if(!empty($Command) && strtolower($Command) == "edit"){
		if(isset($_GET['Save'])){
		try {
			if(!((isset($_POST['SIDCheck']) && $_POST['SIDCheck'] == $XVwebEngine->Session->GetSID()) OR  (isset($_GET['SIDCheck']) && $_GET['SIDCheck'] == $XVwebEngine->Session->GetSID()))){
			header('location: ?');
			exit;
			}
		

			$SaveError = array();

			$XVwebEngine->EditUserInit();

			$XVwebEngine->Date['EditUser']->Init($XVwebEngine->ReadUser['User']);
				
			if(isset($_POST['user']['VorName']) && $_POST['user']['VorName'] != $XVwebEngine->ReadUser['VorName']){
				$_POST['user']['VorName'] = htmlspecialchars($_POST['user']['VorName']);
				$XVwebEngine->Date['EditUser']->set("VorName", $_POST['user']['VorName']);
			}
			
			if(isset($_POST['user']['WhereFrom']) && $_POST['user']['WhereFrom'] != $XVwebEngine->ReadUser['WhereFrom']){
				$_POST['user']['WhereFrom'] = htmlspecialchars($_POST['user']['WhereFrom']);
				$XVwebEngine->Date['EditUser']->set("WhereFrom", $_POST['user']['WhereFrom']);
			}
			
			if(isset($_POST['user']['Name']) && $_POST['user']['Name'] != $XVwebEngine->ReadUser['Name']){
				$_POST['user']['Name'] = htmlspecialchars($_POST['user']['Name']);
				$XVwebEngine->Date['EditUser']->set("Name", $_POST['user']['Name']);
			}
			
			if(isset($_POST['user']['Skype']) && $_POST['user']['Skype'] != $XVwebEngine->ReadUser['Skype']){
				$_POST['user']['Skype'] = htmlspecialchars($_POST['user']['Skype']);
				$XVwebEngine->Date['EditUser']->set("Skype", $_POST['user']['Skype']);
			}
			
			if(isset($_POST['user']['Born']) && $_POST['user']['Born'] != $XVwebEngine->ReadUser['Born']){
			$BrithDate =explode('-', $_POST['user']['Born']);
			if(checkdate($BrithDate[1], $BrithDate[2], $BrithDate[0]))
				$XVwebEngine->Date['EditUser']->set("Born", $BrithDate[0].'-'.$BrithDate[1].'-'.$BrithDate[2]);
				else
					$SaveError[] = $Language['BadBrithDate'];
			}
			
			
			if(isset($_FILES['user']['tmp_name']['Avant'])){
				if(is_uploaded_file($_FILES['user']['tmp_name']['Avant'])) {
				if ((($_FILES['user']["type"]['Avant'] == "image/gif")
					|| ($_FILES['user']["type"]['Avant'] == "image/jpeg")
					|| ($_FILES['user']["type"]['Avant'] == "image/pjpeg")
					|| ($_FILES['user']["type"]['Avant'] == "image/png")
					|| ($_FILES['user']["type"]['Avant'] == "image/png"))
					){
					$DirAvants = ROOT_DIR.'files'.DIRECTORY_SEPARATOR.'avants'.DIRECTORY_SEPARATOR;
					$FileName =  $XVwebEngine->ReadUser['User'];
					$AvantLocation = str_replace('..','', $_FILES['user']['tmp_name']['Avant']);
					$PluginContinue = true;
					if($XVwebEngine->Plugins()->Menager()->event("onUploadAvant")) eval($XVwebEngine->Plugins()->Menager()->event("onUploadAvant")); 
					if($PluginContinue == true){
					include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ResizeImage.class.php');
						$image = new SimpleImage();
						$image->load($AvantLocation); 
						$image->resize(150,150);
						$image->save($DirAvants.$FileName.'_150.jpg');
						   
						$image->resize(64,64);
						$image->save($DirAvants.$FileName.'_64.jpg');
				
						$image->resize(32,32);
						$image->save($DirAvants.$FileName.'_32.jpg');
						$image->resize(16,16);
						$image->save($DirAvants.$FileName.'_16.jpg');	
						$XVwebEngine->Date['EditUser']->set("Avant", true);		
					}
					  }

				}
			}
			
			
			
			if(!empty($_POST['user']['Sex'])){
				switch($_POST['user']['Sex'])
				{
				case "male":
					$_POST['user']['Sex'] = 2;			
					break;
				case "female":
					$_POST['user']['Sex'] = 1;
					break;
				default:
					$_POST['user']['Sex'] = 0 ;
				}
				
				if($XVwebEngine->ReadUser['Sex']!=$_POST['user']['Sex'])
				$XVwebEngine->Date['EditUser']->set("Sex", $_POST['user']['Sex']);
				

			}
			
			if(isset($_POST['user']['ICQ']) && $_POST['user']['ICQ'] != $XVwebEngine->ReadUser['ICQ']){
				if(is_numeric($_POST['user']['ICQ']))
				$XVwebEngine->Date['EditUser']->set("ICQ", $_POST['user']['ICQ']); else
				$SaveError[] = $Language['BadICQnumber'];
				
			}
			
			if(isset($_POST['user']['GaduGadu']) && $_POST['user']['GaduGadu'] != $XVwebEngine->ReadUser['GaduGadu']){
				if(is_numeric($_POST['user']['GaduGadu']))
				$XVwebEngine->Date['EditUser']->set("GaduGadu", $_POST['user']['GaduGadu']) ; 
				else
				$SaveError[] = $Language['BadGGnumber'];
			}
			
			if(isset($_POST['user']['Signature']) && $_POST['user']['Signature'] != $XVwebEngine->ReadUser['Signature'])
				$XVwebEngine->Date['EditUser']->set("Signature", $_POST['user']['Signature']) ; 
			

			
			if((!empty($_POST['user']['Page'])) && ($_POST['user']['Page'] != "http://") && ($_POST['user']['Page'] != $XVwebEngine->ReadUser['Page'])){
				$_POST['user']['Page'] = htmlspecialchars($_POST['user']['Page']);
				if($XVwebEngine->Date['EditUser']->validate_url($_POST['user']['Page']))
				$XVwebEngine->Date['EditUser']->set("Page", $_POST['user']['Page']);
				else
				$SaveError[] = $Language['BadPageAdress'];
				
			}
			
			if(isset($_POST['user']['Languages']) && $_POST['user']['Languages'] != $XVwebEngine->ReadUser['Languages']){
				$_POST['user']['Languages'] = htmlspecialchars($_POST['user']['Languages']);
				$XVwebEngine->Date['EditUser']->set("Languages", $_POST['user']['Languages']);
			}
			
			if(!empty($_POST['user']['Password']['Old']) && !empty($_POST['user']['Password']['New']) && !empty($_POST['user']['Password']['Replay'])){
				if($_POST['user']['Password']['New'] != $_POST['user']['Password']['Replay']){
					$SaveError[] = $Language['PassNotDoMatch'];
				}elseif(!xv_perm('EditOtherProfil') && md5(MD5Key.$_POST['user']['Password']['Old']) != $XVwebEngine->ReadUser['Password']){
					$SaveError[] = $Language['LogegedBadPassword'];
				}else{
					$XVwebEngine->Date['EditUser']->set("Password", md5(MD5Key.$_POST['user']['Password']['New']));
				}	
				
			}
			
			eval($XVwebEngine->Plugins()->Menager()->event("onEditProfile"));
			
			$XVwebEngine->Date['EditUser']->execute();
			
			if(!empty($SaveError)){
				$Smarty->assign('ErrorSave', $SaveError);
				$Smarty->assign('Error', true);
			}
			
		
		} catch (XVwebException $e) {
			switch($e->getCode())
			{
			case 1:
				header("location: ".$URLS['Script'].'System/AccessDenied/');
				exit;		
			default:
				header("location: ".$URLS['Script'].'System/Error/?Code='.$e->getCode());
				exit;
			}
		}
	$Smarty->assign('Edited', true);
	$XVwebEngine->ReadUser($UserFromUrl);
	}
	
		$Smarty->assign('User', $XVwebEngine->ReadUser);

		$UserInputs['Name'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Name]", "value"=>(ifsetor($XVwebEngine->ReadUser['Name'], '')), "type"=>"text",));
		$UserInputs['VorName'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[VorName]", "value"=>(ifsetor($XVwebEngine->ReadUser['VorName'], '')), "type"=>"text",));
		//$UserInputs['Mail'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Mail]", "value"=>(ifsetor($XVwebEngine->ReadUser['Mail'], '')), "type"=>"text",));
		$UserInputs['WhereFrom'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[WhereFrom]", "value"=>(ifsetor($XVwebEngine->ReadUser['WhereFrom'], '')), "type"=>"text",));
		$UserInputs['Sex'] =  array("tag"=>"select", "attr"=>array("name"=>"user[Sex]"), "options"=>array("male"=>$Language['Male'], "female"=>$Language['Female'], "none"=>"-----"), "checked"=>($XVwebEngine->ReadUser['Sex'] == 2 ? array("male"=>true) : ($XVwebEngine->ReadUser['Sex'] == 1 ? array("female"=>true) : array())));
		$UserInputs['Page'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Page]", "value"=>(ifsetor($XVwebEngine->ReadUser['Page'], '')), "type"=>"text",));
		$UserInputs['Languages'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Languages]", "value"=>(ifsetor($XVwebEngine->ReadUser['Languages'], '')), "type"=>"text",));
		$UserInputs['GaduGadu'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[GaduGadu]", "value"=>(ifsetor($XVwebEngine->ReadUser['GaduGadu'], '')), "type"=>"text",));
		$UserInputs['Skype'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Skype]", "value"=>(ifsetor($XVwebEngine->ReadUser['Skype'], '')), "type"=>"text",));
		$UserInputs['Tlen'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Tlen]", "value"=>(ifsetor($XVwebEngine->ReadUser['Tlen'], '')), "type"=>"text",));
		$UserInputs['BornDate'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Born]", "value"=>(ifsetor($XVwebEngine->ReadUser['Born'], '')), "type"=>"text",));
		$UserInputs['ICQ'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[ICQ]", "value"=>(ifsetor($XVwebEngine->ReadUser['ICQ'], '')), "type"=>"text",));
		$UserInputs['Password'] =  array("tag"=>"multiinput", "attr"=>array("name"=>"Password") , "inputs"=>array("OldPassword"=>array("name"=>"user[Password][Old]", "value"=>"", "type"=>"password"), "NewPassword"=>array("name"=>"user[Password][New]", "value"=>"", "type"=>"password"), "ReplayPassword"=> array("name"=>"user[Password][Replay]", "value"=>"", "type"=>"password")));
		$UserInputs['Signature'] =  array("tag"=>"textarea" , "attr"=>array("name"=>"user[Signature]"), "text"=> (ifsetor($XVwebEngine->ReadUser['Signature'], '')));
		
		$UserInputs['Avant'] =  array("tag"=>"input" , "attr"=>array("name"=>"user[Avant]",  "type"=>"file",));
		//$UserInputs['Avant'] =  array("tag"=>"multiinput", "attr"=>array("name"=>"Avant") , "inputs"=>array("None"=>array("name"=>"MAX_FILE_SIZE", "value"=>"100000000", "type"=>"hidden"), "AvantUpload"=>array("name"=>"UploadAvant", "type"=>"file")));

		eval($XVwebEngine->Plugins()->Menager()->event("onEditProfilePage"));
		
		$Smarty->assign('UserInputs', $UserInputs);
		$Smarty->assign('MiniMap', array(
			array("Url"=>"/Users/", "Name"=>$Language['Users']),
			array("Url"=>"/Users/".urlencode($XVwebEngine->ReadUser['Nick']).'/', "Name"=>$XVwebEngine->ReadUser['Nick']),
			array("Url"=>"/Users/".urlencode($XVwebEngine->ReadUser['Nick']).'/Edit/', "Name"=>$Language['Edit']),
		)
		);
	
		$Smarty->display('useredit_show.tpl');
	}else{
	$XVwebEngine->ReadUser['Password'] = "***Secure***";
	$Smarty->assign('ContextEdit',  $ContextEdit);
	$Smarty->assign('Title', $GLOBALS['Language']['User'].': '.htmlspecialchars($UserFromUrl,  ENT_QUOTES));
	$Smarty->assign('SiteTopic', $GLOBALS['Language']['User'].': '.htmlspecialchars($UserFromUrl,  ENT_QUOTES));
	$Smarty->assign('User', $XVwebEngine->ReadUser);
	$Smarty->assign('LogedUser', $XVwebEngine->Session->Session('Logged_Logged'));
	$Smarty->assign('RightBox', $XVwebEngine->ReadUser['Nick']);
	include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
	
	$modifications_list = $XVwebEngine->module("user_info")->get_modifications($XVwebEngine->ReadUser['Nick'], (int) $_GET['mod_pager']);
	$modifications_count = $XVwebEngine->module("user_info")->get_last_count_records();
	$Smarty->assign('modifications_list',    $modifications_list);
	$Smarty->assign('modifications_count',    $modifications_count);
	$Smarty->assign('modifications_pager',   pager(30, (int) $modifications_count,  "?".$XVwebEngine->add_get_var(array("mod_pager"=>"-npage-id-"), true), (int) $_GET['mod_pager']));	
	
	$files_list = $XVwebEngine->module("user_info")->get_files($XVwebEngine->ReadUser['Nick'], (int) $_GET['files_pager']);
	$files_count = $XVwebEngine->module("user_info")->get_last_count_records();
	$Smarty->assign('files_list',    $files_list);
	$Smarty->assign('files_count',    $files_count);
	$Smarty->assign('files_pager',   pager(30, (int) $files_count,  "?".$XVwebEngine->add_get_var(array("files_pager"=>"-npage-id-"), true), (int) $_GET['mod_pager']));
	
	
	$Smarty->assign('MiniMap', array(
			array("Url"=>"/Users/", "Name"=>$Language['Users']),
			array("Url"=>"/Users/".urlencode($XVwebEngine->ReadUser['Nick']).'/', "Name"=>$XVwebEngine->ReadUser['Nick']),
		)
	);
	
	$Smarty->display('users_show.tpl');
	}
}else{
	include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');

	$RecordsLimit = (int) ifsetor($XVwebEngine->Config("config")->find('config pagelimit userlist')->text(), 30);;
	$Smarty->assign('Title', $GLOBALS['Language']['Users']);
	$Smarty->assign('SiteTopic', $GLOBALS['Language']['Users']);
	$Smarty->assign('RightBox', $GLOBALS['Language']['Users']);

	$UserList = $XVwebEngine->UserList(array("ActualPage"=>(int) $_GET['Page'] , "EveryPage" => $RecordsLimit));
	$Smarty->assign('UserList',$UserList[0]);

	$pager = pager($RecordsLimit, (int) $UserList[1],  "?".$XVwebEngine->add_get_var(array("Page"=>"-npage-id-"), true), (int) $_GET['Page']);
	
	$Smarty->assign('Pager',        $pager);
	$Smarty->assign('ActualPage',   $ActualPage);
	
	$Smarty->assign('MiniMap', array(
			array("Url"=>"/Users/", "Name"=>$Language['Users']),
		)
	);
	
	$Smarty->display('usersList_show.tpl');
}
?>