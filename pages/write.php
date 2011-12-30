<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   write.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :  1.0                *************************
****************   Authors   :  XVweb team         *************************
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
	exit;
}
/*
if(!($XVwebEngine->Session->Session('Logged_Logged'))){ // przekierowanie, jak nie zalogowany
header("location: ".$URLS['Script'].'System/LogIn/');
exit;
}
*/
		
$XVwebEngine->Date['EngineVars'] = array_merge_recursive((is_array($XVwebEngine->Date['EngineVars']) ? $XVwebEngine->Date['EngineVars'] : array()), (is_array($XVwebEngine->Plugins()->Menager()->enginevars()) ? $XVwebEngine->Plugins()->Menager()->enginevars() : array()));
$XVwebEngine->Date['EngineFunctions'] = $XVwebEngine->Plugins()->Menager()->enginefunctions(); // zmienne z plugina :D

LoadLang('edit');

if(isset($_GET['PreView'])){
	exit($XVwebEngine->TextParser()->set("Blocked", false)->SetText($_POST['EditArtPost'])->Parse()->ToHTML());
}

if(isset($_GET['UrlCheck'])){
	$result = true;
	if(empty($_GET['xv-path']))
	$result = false;
	else{
		$URLArticlePrefix = $XVwebEngine->ReadPrefix($_GET['xv-path']);
		if($XVwebEngine->Plugins()->Menager()->prefix(($URLArticlePrefix)))
		$result = false;
		if($XVwebEngine->ReadArticle($_GET['xv-path']))
		$result = false;
	}
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json;');
	exit(json_encode(array("result"=>$result)));
}


if(isset($_GET['settings']) && is_numeric($_GET['settings'])){
	$XVwebEngine->ArticleFooIDinArticleIndex = $_GET['settings'];
	if(!$XVwebEngine->ReadArticle()){
		header("location: ".$URLS['Script'].'System/ArticleDoesNotExist/');
		exit;
	}
	$ResultOperation = false;
	if((xvPerm('AdminPanel'))){
		$SaveSettings = array();
		foreach($_POST['settings'] as $key=> $value)
			$SaveSettings[$key] = ifsetor($_POST['settings'][$key] , 0);
		unset($value);
		$IndexToChange = $_POST['articleindex'];
		$IndexToChange['Options'] = serialize($SaveSettings);
		
		$ResultOperation = $XVwebEngine->EditArticle()->EditIndexArticle($_GET['settings'], $IndexToChange);
	}

	if(!empty($_POST['urlpath']) && (xvPerm('MoveArticle'))){
		$URLFrom = $XVwebEngine->IDtoURL($_GET['settings']);
		$URLTo = $XVwebEngine->AddSlashesStartAndEnd($_POST['urlpath']);
		if ( $URLTo != $URLFrom){
			$ResultOperation = $XVwebEngine->EditArticle()->ChangeURL($URLFrom,$URLTo);
		}
	}
	if(!empty($_POST['alias']) && $_POST['alias'] != $XVwebEngine->ReadArticleIndexOut['URL'] && (xvPerm('CreateAlias'))){
		$ResultOperation = $XVwebEngine->EditArticle()->AddAlias($_POST['alias'],$_GET['settings']);
	}
	if(!empty($_POST['accept']) && (xvPerm('AcceptArticles'))){
	$AcceptResult = ($_POST['accept']['Accept'] == "yes" ? "yes" : "no");
	if($XVwebEngine->ReadArticleIndexOut['Accepted'] != $AcceptResult)
		$XVwebEngine->EditArticle()->AcceptArticle($_GET['settings'], $AcceptResult, (isset($_POST['accept']['SubArticles']) ? "yes": "no" ));
	}
	
	if(xvPerm('BlockArticles')){
		$BlockResult = $_POST['block']['Article'];
		if($XVwebEngine->ReadArticleIndexOut['Blocked'] != $BlockResult)
		$XVwebEngine->EditArticle()->BlockArticle($_GET['settings'], $BlockResult, (isset($_POST['block']['SubArticles']) ? "yes" : "no" ));
	}
	
	$XVwebEngine->EditArticle()->ClearArticleCache($_GET['settings']);
	if($ResultOperation == false){
		header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__));
	}else{
		header("location: ".$URLS['Script'].substr($ResultOperation,1).'?Save=true');
	}
	exit;

}

//Modyfication save
if(isset($_GET['save']) && isset($_POST['xv-description'])){
	if($XVwebEngine->Config("config")->find("config disable edit")->text() == "true" && !xvPerm('AdminPanel')){
		header("location: ".$URLS['Script'].'System/AccessDenied/');
		exit;
		}
	if(!(xvPerm('EditArticle'))){ // przekierowanie, jak nie zalogowany
		header("location: ".$URLS['Script'].'System/AccessDenied/');
		exit;
		}
	if(!is_numeric($_GET['save'])){
		header("location: ".$URLS['Script'].'System/AccessDenied/');
		exit;
	}
	if(trim(ifsetor($_POST['xv-captcha'], "")) != substr($XVwebEngine->Session->GetSID(), 0, 5)){
			header("location: ".$URLS['Script'].'System/SpamBot/');
		exit;
	
	}
		
	if(isset($_POST['amendment']) && $_POST['amendment'] == "true"){
		if($XVwebEngine->EditArticle()->SaveAmendment($_GET['save'], $_POST['EditArtPost'], $_POST['arttitle'])){
			header("location: ".$URLS['Script'].substr($XVwebEngine->URLRepair($XVwebEngine->AddSlashesStartAndEnd($XVwebEngine->ReadArticleIndexOut['URL'])), 1));
		}else{
		header("location: ".$URLS['Script'].'System/Error/');
		}
		exit;
	}else{
		$XVwebEngine->SaveModificationArticle['Topic'] = htmlspecialchars($_POST['arttitle']);

		if($XVwebEngine->EditArticle()->Edit($_GET['save'], $_POST['EditArtPost'], $_POST['xv-description'])){
			header("location: ".$URLS['Script'].substr($XVwebEngine->URLRepair($XVwebEngine->AddSlashesStartAndEnd($XVwebEngine->ReadArticleIndexOut['URL'])), 1));
			exit;
		}
	}
	header("location: ?".http_build_query(array(
		"msg"=> (isset($Language[$XVwebEngine->SaveModificationArticleError]) ?  $Language[$XVwebEngine->SaveModificationArticleError] : $XVwebEngine->SaveModificationArticleError ),
		"error"=> true,
		"title"=>  $Language['Error'],
		"Edit"=>  true,
		"id"=>  $_GET['save'],
	)));
	
	exit;
}
if(isset($_GET['save']) && isset($_POST['xv-path'])){
	if($XVwebEngine->Config("config")->find("config disable write")->text() == "true" && !xvPerm('AdminPanel')){
		header("location: ".$URLS['Script'].'System/AccessDenied/');
		exit;
		}
	if(!(xvPerm('WriteArticle'))) {// Brak dostepu
		header("location: ".$URLS['Script'].'System/AccessDenied/');
		exit;
		}
	if(trim(ifsetor($_POST['xv-captcha'], "")) != substr($XVwebEngine->Session->GetSID(), 0, 5)){
			header("location: ".$URLS['Script'].'System/SpamBot/');
		exit;
		}
	$URLArticlePrefix = $XVwebEngine->ReadPrefix($_POST['xv-path']);

	if($XVwebEngine->Plugins()->Menager()->prefix(($URLArticlePrefix))){
		$XVwebEngine->Session->Session('CategoryBlockedPost', serialize($_POST));
		header("location: ".$URLS['Script'].'System/CategoryBlocked/');
		exit;
	}

	$TopicArticle = (empty($_POST['arttitle']) ? $XVwebEngine->ReadTopicArticleFromUrl($XVwebEngine->AddSlashesStartAndEnd($_POST['xv-path'])) : htmlspecialchars($_POST['arttitle']));

	$XVwebEngine->EditArticle()->Add($XVwebEngine->AddSlashesStartAndEnd($_POST['xv-path']), $_POST['EditArtPost'], null, $TopicArticle, $XVwebEngine->ReadCategoryArticle($_POST['xv-path'], true));
	if($XVwebEngine->SaveArticleError){
		$XVwebEngine->Session->Session('CategoryBlockedPost', serialize($_POST));
		switch($XVwebEngine->SaveArticleError)
		{
		case 1:
			header("location: ".$URLS['Script'].substr($XVwebEngine->URLRepair($XVwebEngine->AddSlashesStartAndEnd($_POST['xv-path'])), 1));
			exit;			
			break;
		case "ArticleIsset":
			header("location: ".$URLS['Script'].'System/IssetArticle/');
			exit;
			break;
		case "CategoryDoesNotExist":
			header("location: ".$URLS['Script'].'System/CategoryDoesNotExist/');
			exit;
			break;
		case "IllegalCharacters":
			header("location: ".$URLS['Script'].'System/IllegalCharacters/');
			exit;
			break;
		case "Antyflood":
			header("location: ".$URLS['Script'].'System/Antyflood/?Time='.$XVwebEngine->AntyFlood()->Date['TimeOut']);
			exit;
			
		case "CategoryBlocked":
			header("location: ".$URLS['Script'].'System/CategoryBlocked/');
			exit;		
			break;
		case "Error":
			header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__));
			exit;		
			break;
			
		default:
			header("location: ".$URLS['Script'].'System/Error/');
			exit;	
		}
	}

	header("location: ".$URLS['Script'].substr($XVwebEngine->AddSlashesStartAndEnd($_POST['xv-path']),1));
	exit;


}

if(isset($_GET['Edit']) && is_numeric($_GET['id'])){
		if($XVwebEngine->Config("config")->find("config disable edit")->text() == "true" && !xvPerm('AdminPanel')){
			header("location: ".$URLS['Script'].'System/AccessDenied/');
			exit;
		}

	if(!(xvPerm('EditArticle'))){ // przekierowanie, jak nie zalogowany
			header("location: ".$URLS['Script'].'System/AccessDenied/');
			exit;
		}

	$XVwebEngine->ArticleFooIDinArticleIndex = $_GET['id'];
	if(!$XVwebEngine->ReadArticle()){
		header("location: ".$URLS['Script'].'System/ArticleDoesNotExist/');
		exit;
	}
	if(($XVwebEngine->ReadArticleIndexOut['Blocked'] == "yes") && !(xvPerm('BlockArticles'))){
		header("location: ".$URLS['Script'].'System/ArticleBlocked/');
		exit;
	}
		if(xvPerm('AcceptArticles')){
			$SettingsInputs['AcceptArticle'] = array("tag"=>"select", "attr"=>array("name"=>"accept[Accept]"), "options"=>array("yes"=>$Language['Yes'], "no"=>$Language['No']), "checked"=>array($XVwebEngine->ReadArticleIndexOut['Accepted'] => true));
			$SettingsInputs['AcceptSubArticles'] =  array("tag"=>"input" , "attr"=>array("name"=>"accept[SubArticles]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox"));
		}
		if(xvPerm('BlockArticles')){
			$SettingsInputs['BlockArticle'] = array("tag"=>"select", "attr"=>array("name"=>"block[Article]"), "options"=>array("yes"=>$Language['Yes'], "no"=>$Language['No']), "checked"=>array($XVwebEngine->ReadArticleIndexOut['Blocked'] => true));
			$SettingsInputs['BlockSubArticles'] =  array("tag"=>"input" , "attr"=>array("name"=>"block[SubArticles]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox"));
		}
		if(xvPerm('AdminPanel')){
			$SettingsInputs['DisableCache'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableCache]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableCache'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableUI'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableUI]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableUI'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableDivisions'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableDivisions]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableDivisions'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableQuickSearch'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableQuickSearch]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableQuickSearch'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableAds'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableAds]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableAds'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['EnablePHP'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[EnablePHP]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['EnablePHP'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['EnableHTML'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[EnableHTML]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox" , "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['EnableHTML'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableParser'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableParser]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableParser'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['IncludeArticle'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[IncludeArticle]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['IncludeArticle'], true) ? "checked" : "unchecked")));
			$SettingsInputs['DisableGeshi'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableGeshi]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableGeshi'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableFiles'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableFiles]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableFiles'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableComments'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableComments]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableComments'], 0) ? "checked" : "unchecked")));
			$SettingsInputs['DisableInfo'] =  array("tag"=>"input" , "attr"=>array("name"=>"settings[DisableInfo]", "value"=>"1", "type"=>"checkbox", "class"=>"xv-checkbox", "checked"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableInfo'], 0) ? "checked" : "unchecked")));


						$SettingsInputs['MainTopic'] =  array("tag"=>"input" , "attr"=>array("type"=>"text", "name"=>"articleindex[Topic]", "value"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Topic'], '')));
						$SettingsInputs['MainViews'] =  array("tag"=>"input" , "attr"=>array("type"=>"text", "name"=>"articleindex[Views]", "value"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Views'], '')));
						$SettingsInputs['MainDate'] =  array("tag"=>"input" , "attr"=>array("type"=>"text", "name"=>"articleindex[Date]", "value"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Date'], '')));
						$SettingsInputs['MainTags'] =  array("tag"=>"input" , "attr"=>array("type"=>"text", "name"=>"articleindex[Tag]", "value"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Tag'], '')));
						$SettingsInputs['MainURL'] =  array("tag"=>"input" , "attr"=>array("type"=>"text", "name"=>"articleindex[URL]", "value"=> ifsetor($XVwebEngine->ReadArticleIndexOut['URL'], '')));
						
						
			$SettingsInputs['Headers'] =  array("tag"=>"textarea" , "attr"=>array("name"=>"settings[Headers]"), "text"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['Headers'], ''));
			$SettingsInputs['CSS'] =  array("tag"=>"textarea" , "attr"=>array("name"=>"settings[CSS]"), "text"=> ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['CSS'], ''));
		}
		if((xvPerm('MoveArticle')))
		$SettingsInputs['URLPath'] =  array("tag"=>"input" , "attr"=>array("name"=>"urlpath",  "type"=>"text", "value"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['URL'], '/'))));
		if((xvPerm('CreateAlias')))
		$SettingsInputs['Alias'] =  array("tag"=>"input" , "attr"=>array("name"=>"alias",  "type"=>"text", "value"=>(ifsetor($XVwebEngine->ReadArticleIndexOut['URL'], '/'))));
		
		eval($XVwebEngine->Plugins()->Menager()->event("onButtonsSettings"));
		$Smarty->assign('SettingsInputs', $SettingsInputs);
	
	$ContextEdit = htmlspecialchars($XVwebEngine->ReadArticleOut['Contents']);
	$Smarty->assign('TitleArt', $XVwebEngine->ReadArticleOut['Topic']);
	$Smarty->assign('WriteDescription', true);
	$Smarty->assign('IDArticle', $XVwebEngine->ArticleFooIDinArticleIndex);
}else{
	$Smarty->assign('WriteUrlArticle', true);
		if(!(xvPerm('WriteArticle'))){ // Brak dostepu
			header("location: ".$URLS['Script'].'System/AccessDenied/');
			exit;
			}
}
$Smarty->assign('ContextEdit', $ContextEdit);
////////Uzupełnianie stałymi szablonu
/**************************THEME*******************/
$Smarty->display('write_show.tpl');

?>