<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   receiver.php      *************************
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

switch (strtolower($XVwebEngine->GetFromURL($PathInfo, 2))) {
	case "language.js":
		LanguageJS();
	case "tag":
		ChangeTag();
		break;
	case "addcomment":
		AddComment();
		break;
	case "lostpassword":
		LostPassword();
		break;
	case "ec":
		EditComment();
		break;
	case "dc":
		DeleteComment();
		break;
	case "da":
		DeleteArticle();
		break;
	case "previewcomment":
		PreViewComment();
		break;
	case "dlva":
		DeleteLastVerArticle();
		break;
	case "dva":
		DeleteVerArticle();
		break;
	case "issetuser":
		IssetUser();
		break;
	case "user":
		 GetUser();
		break;
}


function LanguageJS(){
global $Language, $XVwebEngine;
//Tutaj jest błąd, gdyz nie bedzie sprawdzal innych includowanych jezykow. Popraw to
				if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == 'Wed, 20 Jan 2010 18:50:13 GMT') {
					header("HTTP/1.0 304 Not Modified");
					header('XVwebMSG: "Not modified"');
					exit;
				}
	if(isset($_GET['include'])){
		switch(strtolower($_GET['include'])){
		case "custom":
			if (file_exists('languages'.DIRECTORY_SEPARATOR.$Language['Lang'].DIRECTORY_SEPARATOR.'custom.'.$Language['Lang'].'.php')) {
				@include_once('languages'.DIRECTORY_SEPARATOR.$Language['Lang'].DIRECTORY_SEPARATOR.'custom.'.$Language['Lang'].'.php');
			} else {
				if(!@include_once('languages'.DIRECTORY_SEPARATOR. $XVwebEngine->Config("config")->find("config lang")->text().DIRECTORY_SEPARATOR.'custom.'. $XVwebEngine->Config("config")->find("config lang")->text().'.php'))
				die("XVweb Fatal Error. Don't isset custom language custom.". $XVwebEngine->Config("config")->find("config lang")->text());
			}
		}
	}
	ob_get_clean();
	$expires = 60*60*24*14;
	header("Pragma: public");
	header("Last-Modified: Wed, 20 Jan 2010 18:50:13 GMT"); 
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	header ("content-type: text/javascript; charset: UTF-8");   
	header ('Vary: Accept-Encoding');
	header('Etag: '.md5($Language['Lang'].(isset($_GET['include']) ? addslashes(htmlspecialchars($_GET['include'])) : '' ))); 
	header("XVwebMSG: Sended");
	exit('var Language = '.json_encode($Language).';');
}

function ChangeTag(){
	global $Language, $XVwebEngine, $Smarty;
	if($XVwebEngine->permissions('EditTag')){
		if($XVwebEngine->EditTagArticle($_POST['TagArticleID'],$_POST['TagsArticle']))
		$Smarty->assign('Result', "Success"); else $Smarty->assign('Result', "Failed");
	}else
	$Smarty->assign('Result', "AccessDenied");
	
	$Smarty->display('changetag_show.tpl');
}



function AddComment(){
	global $Smarty, $XVwebEngine, $Language;
	try {
	if( !xv_perm('AdminPanel'))
		exit($Language['Disabled']);
	if(trim(ifsetor($_POST['xv-captcha'], "")) != substr($XVwebEngine->Session->get_sid(), 0, 5))
		exit("You are spambot!");
		
		$XVwebEngine->EditArticle()->SaveComment($_POST['CommentContent'], $_POST['ArticleID']);
		$XVwebEngine->IncludeParseHTML();
		$Smarty->assign('Comments', array(array("Date"=>(date("Y.m.d H:i:s")), "Author"=>($XVwebEngine->Session->Session('Logged_User')),  "ID"=> ($XVwebEngine->Date['SaveCommentID']), "Comment"=>($XVwebEngine->ParserMyBBcode->CommentParse($_POST['CommentContent'])))));
		$Smarty->assign('ArticleURL', $XVwebEngine->IDtoURL($_POST['ArticleID']));
	} catch (XVwebException $e) {
		$Smarty->assign('Exception', True);
		$Smarty->assign('AntiFlood', $XVwebEngine->AntyFlood()->Date['TimeOut']);
		$Smarty->assign('ExceptionCode', $e->getCode());
	}
	$Smarty->assign('AddComment', True);
	$Smarty->display('comment_show.tpl');
}

function EditComment(){
	global $XVwebEngine, $Smarty;
	$XVwebEngine->CommentRead($_GET['id']);
	$Smarty->assign('IDComment', $XVwebEngine->CommentRead['ID']);
	$Smarty->assign('EditToolContent', $XVwebEngine->CommentRead['Comment']);
	$Smarty->display('EditComment_show.tpl');
}

function DeleteComment(){
	global $Smarty,$Language;
	if($_GET['SIDCheck'] != ($GLOBALS['XVwebEngine']->Session->get_sid()))
	exit($Language['SIDCheckFailed']);
	$Smarty->assign('IDComment', $_GET['CommentID']);
	$Smarty->assign('DeleteComment', true);
	$Smarty->assign('ComementReturn', $GLOBALS['XVwebEngine']->DeleteComment($_GET['CommentID']));
	$Smarty->display('delete_comment_show.tpl');
}

function DeleteArticle(){
global $Smarty, $XVwebEngine;
	if($_GET['SIDCheck'] != $XVwebEngine->Session->get_sid())
	$Smarty->assign('result', false); else
	$Smarty->assign('result', $XVwebEngine->EditArticle()->DeleteArticle($_GET['ArticleID']));
	$Smarty->display('deltearticle_show.tpl');
}

function  DeleteLastVerArticle(){
global $Smarty, $XVwebEngine;
	if($_GET['SIDCheck'] != $XVwebEngine->Session->get_sid())
	$Smarty->assign('result', false); else
		$Smarty->assign('result', $XVwebEngine->DelArtVer()->DeleteLastVersion($_GET['ArticleID']));

	$Smarty->display('deltearticle_show.tpl');
}

function PreViewComment(){
	$GLOBALS['XVwebEngine']->IncludeParseHTML();
	echo  $GLOBALS['XVwebEngine']->ParserMyBBcode->CommentParse($_POST['CommentContent']);
}

function DeleteUser(){
	$GLOBALS['XVwebEngine']->IncludeParseHTML();
	echo  $GLOBALS['XVwebEngine']->ParserMyBBcode->CommentParse($_POST['CommentContent']);
}

function DeleteVerArticle(){
global $Smarty, $XVwebEngine;
	if($_GET['SIDCheck'] != $GLOBALS['XVwebEngine']->Session->get_sid())
	exit; 
	$XVwebEngine->DelArtVer()->DLVwithID($_GET['ArticleID'], $_GET['Version']);
	$Smarty->display('deltearticle_show.tpl');
}
function IssetUser(){
$Result = true;
if(preg_match("/^([a-zA-Z0-9 _-])+$/i",  $_GET['User']))
	$Result = $GLOBALS['XVwebEngine']->isset_user($_GET['User']);

	exit(json_encode(array("Isset" => $Result)));
}
function GetUser(){
global $XVwebEngine, $URLS;
$Result = array();
	if(!$XVwebEngine->ReadUser($_GET['User']))
				$Result = false; else{
				$Result['ID'] = $XVwebEngine->ReadUser['ID'];
				$Result['Nick'] = $XVwebEngine->ReadUser['Nick'];
				$Result['Avant'] = $XVwebEngine->ReadUser['Avant'];
				$Result['AvantURL'] = $URLS['Avats'];
				$Result['OpenID'] = $XVwebEngine->ReadUser['OpenID'];
				$Result['Sex'] = $XVwebEngine->ReadUser['Sex'];
				$Result['Name'] = $XVwebEngine->ReadUser['Name'];
				$Result['VorName'] = $XVwebEngine->ReadUser['VorName'];
				$Result['Creation'] = $XVwebEngine->ReadUser['Creation'];
				$Result['WhereFrom'] = $XVwebEngine->ReadUser['WhereFrom'];
				}
	
	exit(json_encode($Result));
}



?>