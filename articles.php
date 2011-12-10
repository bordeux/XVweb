<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   articles.php      *************************
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
if(!isset($XVwebEngine))
exit(header("location: http://".$_SERVER['HTTP_HOST']."/"));

///FUNKCJE GET
if(isset($_GET['version']) && is_numeric($_GET['version']))
$XVwebEngine->ArticleFooVersion = $_GET['version'];

//Plugins Vars
$XVwebEngine->Date['EngineVars'] = array_merge_recursive(( isset($XVwebEngine->Date['EngineVars']) && is_array($XVwebEngine->Date['EngineVars']) ? $XVwebEngine->Date['EngineVars'] : array()), (is_array($XVwebEngine->Plugins()->Menager()->enginevars()) ? $XVwebEngine->Plugins()->Menager()->enginevars() : array()));
$XVwebEngine->Date['EngineFunctions'] = $XVwebEngine->Plugins()->Menager()->enginefunctions();
//End Plugins Vars

$XVwebEngine->ArticleInclude = true;

if((xvp()->ReadArticle($XVwebEngine ,$PathInfo))){

	if(!empty($XVwebEngine->ReadArticleIndexOut['Options']['AccessFlags'])){
		foreach($XVwebEngine->ReadArticleIndexOut['Options']['AccessFlags'] as $flag){
			if(!xvPerm($flag)){
				header("location: ".$URLS['Script'].'System/AccessDenied/?Flag='.$flag);
				exit;
			}
		}
		unset($flag);
	}
	if(isset($_GET['doc'])){
		
		//Plugin:onDocMode
		if($XVwebEngine->Plugins()->Menager()->event("ondocmode")) eval($XVwebEngine->Plugins()->Menager()->event("ondocmode")); 
		//!Plugin:onDocMode
		ob_clean();
		xvp()->ReadArticleToDOC($XVwebEngine);
		exit;
	}


	if(isset($_GET['id']) && isset($_GET['vote']) && is_numeric($_GET['id']) && isset($_GET['t'])){
		$Failed = false;
		if(!isset($_GET['SIDCheck']) or (isset($_GET['SIDCheck']) && $_GET['SIDCheck']!= ($XVwebEngine->Session->GetSID())))
		$Failed = "SIDFailed";
		if(!xvPerm('Voting'))
		$Failed =  "AccessDenied";
		
		if($_GET['t'] == "comment"){
			if($_GET['vote'])
			$Vote = 1; else $Vote = -1;
			$Type= "comment";
		}elseif($_GET['t'] == "article"){
			if($_GET['vote'])
			$Vote = 1; else $Vote = -1;
			$Type= "article";
		}else{
			$Failed = "Error";
		}
		$Result = false;
		if(!$Failed){
			$Result = xvp()->set(xvp()->Votes($XVwebEngine), $Type, $_GET['id'], $Vote);
			if(!$Result)
			$Failed =  "Error";
		}
		$Smarty->assign('Failed', $Failed);
		$Smarty->assign('Modified', $Result);
		try {
			$Smarty->display('votes_show.tpl');
		} catch (Exception $e) { 
			xvp()->ErrorClass($XVwebEngine, $e);
		} 
		
		exit;
	}
	if(isset($_GET['edit'])){
		header("location: ".$URLS['Script'].'Write/?Edit&id='.$XVwebEngine->ReadArticleIndexOut['ID']);
		exit;
	}
	if((isset($_GET['Watch']) or isset($_GET['Bookmark'])) && $XVwebEngine->Session->Session('Logged_Logged') && $_GET['SIDCheck'] == ($XVwebEngine->Session->GetSID())){
		xvp()->bokmarks(xvp()->EditArticle($XVwebEngine), $XVwebEngine->ReadArticleIndexOut['ID'], (isset($_GET['Watch']) ? $_GET['Watch'] : $_GET['Bookmark']), (isset($_GET['Watch']) ? 'Observed' : 'Bookmark'));
		if(isset($_GET['Watch']))
		$XVwebEngine->ReadArticleIndexOut['Observed'] = ($_GET['Watch'] ? 1 : 0); else
		$XVwebEngine->ReadArticleIndexOut['Bookmark'] = ($_GET['Bookmark'] ? 1 : 0);
	}
	if(isset($_GET['pdf'])){
		if(isset($_SERVER['HTTP_REFERER'])){
			if (strpos(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST), "google") !== false) {
				header('Location: ?');
				exit;
			}
		}
		$load = (function_exists('sys_getloadavg') ? sys_getloadavg() : array(0=>10));
		if ($load[0] > 80){
			
			try {
				$Smarty->display('ServerBussy_show.tpl');
			} catch (Exception $e) { 
				$XVwebEngine->ErrorClass($e);
			} 
			exit;
		}
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ArticleToPdf.XVWeb.class.php');
		ob_clean();
		xvp()->CreatePDF(xvp()->InitClass($XVwebEngine, 'ArticleToPDF'));
		exit;
	}
	if(isset($_GET['view'])){
		
		if(isset($_SERVER['HTTP_REFERER'])){
			if (strpos(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST), "google") !== false) {
				header('Location: ?');
				exit;
			}
		}
		
		ob_clean();
		if(isset($_GET['download'])){
			header('Content-type:application/octet-stream'); 
			header('Content-Disposition:attachment; filename="'.($XVwebEngine->ReadArticleOut['Topic']).'.html"');
		}
		if(isset($_GET['html'])){
			$Smarty->template_dir = 'themes'.DIRECTORY_SEPARATOR.'blank'.DIRECTORY_SEPARATOR;
			$Smarty->compile_dir  = 'themes'.DIRECTORY_SEPARATOR.'blank'.DIRECTORY_SEPARATOR.'compile'.DIRECTORY_SEPARATOR;
			$Smarty->config_dir   = 'themes'.DIRECTORY_SEPARATOR.'blank'.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
			$Smarty->cache_dir    = 'themes'.DIRECTORY_SEPARATOR.'blank'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;

			$Smarty->assign('Title',  ($XVwebEngine->ReadArticleOut['Topic']));
			$Smarty->assign('Content',  (xvp()->ParseArticleContents($XVwebEngine)));
			try {
				$Smarty->display('blank_blank.tpl');
			} catch (Exception $e) { 
				xvp()->ErrorClass($XVwebEngine,$e);
			} 
			
			exit;
		}
		echo(xvp()->ParseArticleContents($XVwebEngine));
		exit;
	}
	//Disable UI - Options article DisableUI = true or Get vars disableui= true
	if(isset($_GET['disableui']) || ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableUI'], false) == true){
		if(!empty($XVwebEngine->ReadArticleIndexOut['Options']['Headers']))
		header($XVwebEngine->ReadArticleIndexOut['Options']['Headers']); 

		exit(xvp()->ParseArticleContents($XVwebEngine));
	}
	//End Disable UI
	if(!ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableInfo'], 0))
	$Smarty->assign('LoadInfo', true);
	
	
	
	if( $XVwebEngine->Config("config")->find("config disable quicksearch")->text() != "true" && !ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableQuickSearch'], 0)){
		if($XVwebEngine->Cache->exist("QuickSearch", $XVwebEngine->ReadArticleIndexOut['ID'])){
			$Smarty->assign('QuickSearch', $XVwebEngine->Cache->get());
		}else{
			$RecordsLimit = $XVwebEngine->Config("config")->find('config pagelimit quicksearch')->text();
			$RecordsLimit = is_numeric($RecordsLimit) ? $RecordsLimit : 6;
			$SearchClass = &$XVwebEngine->module('SearchClass', 'SearchClass');
			xvp()->set($SearchClass, "noContent", true);
			xvp()->set($SearchClass, "Group", true);
			xvp()->set($SearchClass, "SearchExcept", $XVwebEngine->ReadArticleIndexOut['ID']);
			$QuickResult = xvp()->Search($SearchClass, $XVwebEngine->ReadArticleIndexOut['Topic'], 0, $RecordsLimit);
			$Smarty->assign('QuickSearch', $XVwebEngine->Cache->put("QuickSearch", $XVwebEngine->ReadArticleIndexOut['ID'], $QuickResult));
			unset($QuickResult);
		}
	}
	
	if(!empty($XVwebEngine->ReadArticleIndexOut['Options']['CSS'])){
		$CSSStyle = strtr($XVwebEngine->ReadArticleIndexOut['Options']['CSS'] , array(
		"{{scripturl}}" => $URLS['Script'], 
		"{{siteurl}}" => $URLS['Site'],
		"{{themeurl}}" =>$URLS['Theme']
		));
		if(isset($_GET['css'])){
			header("Pragma: public");
			header ("content-type: text/css; charset: UTF-8"); 
			exit($CSSStyle);
		}
		xv_appendCSS('data:text/css;base64,'.base64_encode($CSSStyle), 23);
	}
	$Smarty->assign('Title', $XVwebEngine->ReadArticleOut['Topic']);
	$Smarty->assign('SiteTopic', $XVwebEngine->ReadArticleOut['Topic']);
	//XVTemplate::xv_appendMeta("og:type", "article");
	//XVTemplate::xv_appendMeta("og:site_name", $XVwebEngine->SrvName);
	//XVTemplate::xv_appendMeta("og:title", $XVwebEngine->ReadArticleOut['Topic']);
	
	//**************MiniMap**************/
	$Smarty->assign('MiniMap', array_merge(array(0=>array("Url"=>"", "Name"=>$Language['MainPage'])), $XVwebEngine->url_explode($XVwebEngine->ReadArticleIndexOut['URL'])));
	//**************MiniMap**************/
	
	$CategoryTMP = (str_replace("/","",($XVwebEngine->ReadArticleIndexOut['Category'])));
	if(empty($CategoryTMP)) $Smarty->assign('RightBox', $XVwebEngine->ReadArticleIndexOut['Topic']); else $Smarty->assign('RightBox', $CategoryTMP);
	unset($CategoryTMP);
	$Smarty->assign('PluginsButton', $XVwebEngine->Plugins()->Menager()->buttons());

	$Smarty->assignByRef('ReadArticleOut', $XVwebEngine->ReadArticleOut);
	$Smarty->assignByRef('ReadArticleIndexOut', $XVwebEngine->ReadArticleIndexOut);
	//Divisions
	if(!ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableDivisions'], false)){
	
		$Divisions = xvp()->GetDivisions($XVwebEngine);
		$Smarty->assign('DivisionsCount', count($Divisions));
		$Divisions = xvp()->partition($XVwebEngine, xvp()->SortDivisions($XVwebEngine, $Divisions) , 2);
		$Smarty->assign('Divisions', $Divisions); unset($Divisions);
	}
	//\Divisions


	if(!(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableComments'], false) OR $XVwebEngine->Config("config")->find("config disable comment")->text() == "true") &&  xvPerm('ViewComments')){
		$Smarty->assign('LoadComment', true);
		$CommentsList = xvp()->CommentArticle($XVwebEngine);
		$Smarty->assign('CommentsCount', count($CommentsList));
		$Smarty->assign('Comments', $CommentsList);
	}
	
	if(ifsetor($XVwebEngine->ReadArticleIndexOut['Options']['DisableAds'], false)){
		$Smarty->assign('Advertisement', false);
	}
	
	$Smarty->assign('Content', xvp()->ParseArticleContents($XVwebEngine));
}else {
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	$XVwebEngine->SearchInVersion = false;
	$ActualPage = (int) $_GET['Page'];
	$RecordsLimit = ifsetor($XVwebEngine->Config("config")->find('config pagelimit notfound')->text(), 30);
	$TitleQuery =  $XVwebEngine->ReadTopicArticleFromUrl($XVwebEngine->ArticleFooLocation);
	$Smarty->assign('NotFoundArticle',true);
	$Smarty->assign('Title',$TitleQuery);
	$Smarty->assign('SiteTopic', sprintf($Language['NotFoundArticleTopic'], $TitleQuery));

	$Smarty->assign('RightBox', $TitleQuery );
	$SearchResult = xvp()->Search($XVwebEngine, $TitleQuery, $ActualPage, $RecordsLimit);
	$Smarty->assignByRef('SearchArray', $SearchResult);
	if(!empty($SearchResult)){
		include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		$pager = pager($RecordsLimit, (int) $XVwebEngine->Date['SearchResultCount'],  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
		$Smarty->assignByRef('Pager',     $pager);
	}

}
//Plugin:onArticleLoad
if($XVwebEngine->Plugins()->Menager()->event("onarticleload")) eval($XVwebEngine->Plugins()->Menager()->event("onarticleload")); 
//!Plugin:onArticleLoad
$Smarty->assign('JSBinder', $JSBinder);
	//ob_start("ob_gzhandler");
try {
	$Smarty->display('view_show.tpl');
} catch (Exception $e) { 
	xvp()->ErrorClass($XVwebEngine, $e);
} 

?>