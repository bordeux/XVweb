<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
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
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
class XV_Admin_articles{
	var $style = "height: 500px; width: 90%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "Articles/";
	var $content = "test";
	var $id = "articles-window";
	var $Date;
	//var $contentAddClass = " xv-terminal";
	public function __construct(&$XVweb){
		
		if(isset($_GET['Sort']) && $_GET['Sort'] == "desc")
		$SortByP = 'asc'; else
		$SortByP = 'desc';
		
		
		$RecordsLimit=30;
		$ActualPage = (int) ifsetor($_GET['Page'], 0);
		$TextsList =	$this->GetAricles($XVweb, $ActualPage,$RecordsLimit, $_GET['SortBy'], $SortByP );
		//$TextsList = $this->GetAricles($XVweb, $ActualPage,$RecordsLimit, (isset($_GET['LogSelect']) ? $_GET['LogSelect'] : null));
		include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		$pager = pager($RecordsLimit, (int) $TextsList->Count,  "?".$XVweb->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
		


		$this->content = '	<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a href="?'.$XVweb->AddGet('SortBy=ID&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['ID'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Date&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Date'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Topic&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Topic'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Accepted&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Accepted'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Blocked&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Blocked'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Views&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Views'].'</a></th>
					</tr>
				</thead> 
				<tbody>';
		
		

		
		foreach($TextsList->List as $Text){
			$this->content .= '<tr>
					<td>'.$Text['ID'].'</td>
					<td>'.$Text['Date'].'</td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/Articles/IA/?id='.$Text['ID'].'" class="xv-get-window" >'.htmlspecialchars($Text['Topic']).'</a> [<a href="'.$GLOBALS['URLS']['Script'].''.$XVweb->URLRepair(substr(str_replace(" ", "_", $Text['URL']), 1)).'" target="_blank" >Link</a>]</td>
					<td>'.($Text['Accepted'] == "yes" ? '<span class="ui-icon ui-icon-circle-check"></span>' : '<span class="ui-icon ui-icon-circle-minus"></span>').'</td>
					<td>'.($Text['Blocked'] == "yes" ? '<span class="ui-icon ui-icon-locked"></span>' : '<span class="ui-icon ui-icon-unlocked"></span>').'</td>
					<td>'.$Text['Views'].'</td>
				</tr>';
		}
		
		$this->content .= '</tbody> 
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
			</div>';
		
		$this->title = $GLOBALS['Language']['Articles'];
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/logs.png';
		
	}
	
	public function GetAricles(&$XVweb, $ActualPage = 0, $EveryPage =30, $SortBy = "ID", $Desc = "desc"){
		$LLimit = ($ActualPage*$EveryPage);
		$RLimit = $EveryPage;
		
		$ArticleSQL = $XVweb->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
				{Text_Index:*}
		FROM {Text_Index} ORDER BY '.($XVweb->DataBase->isset_field("Text_Index", $SortBy) ? "{Text_Index:".$SortBy."}" : "{Text_Index:ID}").' '.($Desc == "asc" ? "ASC" : "DESC") .' LIMIT '.$LLimit.', '.$RLimit.';
		');
		
		$ArticleSQL->execute();
		$ArrayArticle = $ArticleSQL->fetchAll();
		
		return (object) array("List"=>$ArrayArticle , "Count"=>$XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `ArticleCount`;')->fetch(PDO::FETCH_OBJ)->ArticleCount);
	}
}


class XV_Admin_articles_comments{
	var $style = "height: 500px; width: 90%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "Articles/Comments/";
	var $content = "";
	var $id = "comments-window";
	var $Date;
	//var $contentAddClass = " xv-terminal";
	public function __construct(&$XVweb){
		
		if(isset($_GET['Sort']) && $_GET['Sort'] == "desc")
		$SortByP = 'asc'; else
		$SortByP = 'desc';
		
		
		$RecordsLimit=30;
		$ActualPage = (int) ifsetor($_GET['Page'], 0);
		$TextsList =	$this->GetComments($XVweb, $ActualPage,$RecordsLimit, $_GET['SortBy'], $SortByP );
		include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		$pager = pager($RecordsLimit, (int) $TextsList->Count,  "?".$XVweb->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
		


		$this->content = '	<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a href="?'.$XVweb->AddGet('SortBy=ID&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['ID'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Date&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Date'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Topic&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Topic'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=IP&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['IP'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Author&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['User'].'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Comment&Sort='.$SortByP, true).'">'.$GLOBALS['Language']['Comment'].'</a></th>
						<th></th>
					</tr>
				</thead> 
				<tbody>';
		
		

		
		foreach($TextsList->List as $Text){
			$this->content .= '<tr class="xv-comments-row-'.$Text['CID'].'">
					<td>'.$Text['CID'].'</td>
					<td>'.$Text['CDate'].'</td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/Articles/IA/?id='.$Text['LID'].'" class="xv-get-window" >'.htmlspecialchars($Text['LTopic']).'</a> [<a href="'.$GLOBALS['URLS']['Script'].''.$XVweb->URLRepair(substr(str_replace(" ", "_", $Text['LURL']), 1)).'#Comment-'.$Text['CID'].'" target="_blank">Link</a>]</td>
					<td>'.htmlspecialchars($Text['CIP']).'</td>
					<td>'.htmlspecialchars($Text['CAuthor']).'</td>
					<td>'.htmlspecialchars($Text['CComment']).'</td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/Articles/DC/?id='.$Text['CID'].'" class="xv-bt-delete xv-get-window">&nbsp;</a></td>
				</tr>';
		}
		
		$this->content .= '</tbody> 
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
			</div>';
		
		$this->title = $GLOBALS['Language']['Comments'];
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/comments.png';
		
	}
	
	public function GetComments(&$XVweb, $ActualPage = 0, $EveryPage =30, $SortBy = "ID", $Desc = "desc"){
		$LLimit = ($ActualPage*$EveryPage);
		$RLimit = $EveryPage;
		
		$CommentSQL = $XVweb->DataBase->prepare('
				SELECT 
	SQL_CALC_FOUND_ROWS
	{Comments}.{Comments:ID} AS `CID`,
	{Comments}.{Comments:Author} AS `CAuthor`,
	{Comments}.{Comments:Date} AS `CDate`,
	{Comments}.{Comments:IP} AS `CIP`,
	{Comments}.{Comments:Comment} AS `CComment`,
	{Comments}.{Comments:Parsed} AS `CParsed`,
	{Text_Index}.{Text_Index:ID} AS `LID`,
	{Text_Index}.{Text_Index:URL} AS `LURL`,
	{Text_Index}.{Text_Index:Topic} AS `LTopic`
FROM 
	{Comments}
LEFT JOIN 
	({Text_Index})
ON 
	({Comments}.{Comments:IDArticleInSQL} = {Text_Index}.{Text_Index:AdressInSQL}) 
ORDER BY 
	{Comments}.'.($XVweb->DataBase->isset_field("Comments", $SortBy) ? "{Comments:".$SortBy."}" : "{Comments:ID}").' '.($Desc == "asc" ? "ASC" : "DESC") .' 
LIMIT 
	'.$LLimit.', '.$RLimit.';

		');
		$CommentSQL->execute();
		$ArrayComments = $CommentSQL->fetchAll(PDO::FETCH_ASSOC);

		
		return (object) array(
		"List"=>$ArrayComments , 
		"Count"=> $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `CommentsCount`;')->fetch(PDO::FETCH_OBJ)->CommentsCount
		);
	}
}

class XV_Admin_articles_ia{
	var $style = "height: 500px; width: 60%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "";
	var $content = "";
	var $id = "";
	var $Date;
	//var $contentAddClass = " xv-terminal";
	public function __construct(&$XVweb){
		global $Language;
		$_GET['id'] = (int) $_GET['id'];
		$this->title = "Edit ListArticle: ID - ".$_GET['id'];
		$this->id = "ia-".$_GET['id']."-window";
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/edittext.png';
		$this->URL = "Articles/IA/?id=".$_GET['id'];
		$IAQuery = 	$XVweb->DataBase->prepare('SELECT * FROM {Text_Index} WHERE {Text_Index:ID} = :ID ; ');
		$IAQuery->execute(array(":ID"=> $_GET['id']));
		$IAQuery = $IAQuery->fetch(PDO::FETCH_ASSOC);
		if(empty($IAQuery)){
			$this->content = "<div class='error'> Nie znaleziono artykułu</div>";
			return;
		}
		$TableStructure = 	$XVweb->DataBase->prepare('DESCRIBE {Text_Index}');
		$TableStructure->execute();
		
		$TableStructure = $TableStructure->fetchAll(PDO::FETCH_ASSOC);	
		foreach($TableStructure as &$field){
			preg_match('/(?P<type>\w+)($|\((?P<length>(\d+|(.*)))\))/', $field["Type"], $matched);
			$field["Type"] = $matched;
		}
		
		include_once($GLOBALS['XVwebDir'].'libraries/formgenerator/formgenerator.php');
		
		$form=new Form(); 
		$form->set("title", "Article Edit");
		$form->set("name", "ia_form");        
		$form->set("linebreaks", false);       
		$form->set("errorBox", "error");    
		$form->set("class", " xv-form");            
		$form->set("attributes", " data-xv-result='.xv-config-form' ");     
		$form->set("errorClass", "error");       
		$form->set("divs", true);    
		$form->set("action",$GLOBALS['URLS']['Script'].'Administration/Get/Articles/IA/?id='.$_GET['id']);
		$form->set("errorTitle", $Language['Error']);    

		$form->set("errorPosition", "before");		

		$form->set("submitMessage", "Zapisano");

		$form->set("showAfterSuccess", true);
		$form->JSprotection($XVweb->Session->GetSID());
		

		
				foreach($TableStructure as $field){
				$field["FieldDisplay"] = $XVweb->Config('db')->find('tables table#Text_Index field[name="'.$field["Field"].'"]')->attr("id")." (".$field["Field"].")";
						switch ($field["Type"]["type"]) {
							case "char":
							case "varchar":
								$form->addField("text", $field["Field"], $field["FieldDisplay"] , true, $IAQuery[$field["Field"]], " maxlength='".$field["Type"]["length"]."' " );
								//$form->validator($field["Field"], "textValidator", 0, $field["Type"]["length"]); 
								break;
							case "int":
							case "mediumint":
								$form->addField("text", $field["Field"], $field["FieldDisplay"] , true, $IAQuery[$field["Field"]], " maxlength='".$field["Type"]["length"]."' " );
								//$form->validator($field["Field"], "textValidator", 0, $field["Type"]["length"]); 
							//	$form->validator($field["Field"], "fromFunction", "is_numeric"); 
							break;
							case "datetime":
								$form->addField("text", $field["Field"], $field["FieldDisplay"] , true, $IAQuery[$field["Field"]], "class='datepicker'");
								//$form->validator($field["Field"], "regExpValidator", "(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})", "Not a valid date"); 
								break;
							case "enum":
								$field["Type"]["length"] = str_replace(array('"', "'"), "", $field["Type"]["length"]);
								$field["Type"]["length"] = explode(",",$field["Type"]["length"]);
									$form->addField("select", $field["Field"], $field["FieldDisplay"], false, $IAQuery[$field["Field"]], array_combine($field["Type"]["length"], $field["Type"]["length"]));
							break;
							default:
								$form->addField("textarea", $field["Field"], $field["FieldDisplay"], false, $IAQuery[$field["Field"]], "cols='40' rows='7'");
							break;
							
							}
				
				}
				
		$form_html = $form->display($Language['Save'], "ia_submit", false);
		
		$result=($form->getData());
		$Content .= $form_html;
		if($result){
			//$Content .= "<div class='success'>Saved</div>";
		}else{
			//$Content .= $form_html;
		}
		
		
		$this->content = ($Content);
		
		
		$this->content .= '	<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption style="color: red;"><a>Wersje</a></caption>
				<thead> 
					<tr class="xv-pager">
						<th><a>'.$GLOBALS['Language']['ID'].'</a></th>
						<th><a>'.$GLOBALS['Language']['Date'].'</a></th>
						<th><a>'.$GLOBALS['Language']['Topic'].'</a></th>
						<th><a>'.$GLOBALS['Language']['DescriptionOfChange'].'</a></th>
						<th><a>'.$GLOBALS['Language']['Version'].'</a></th>
					</tr>
				</thead> 
				<tbody>';
		
		$ArticlesQuery  = 	$XVweb->DataBase->prepare('SELECT 
			{Articles:ID} AS `ID`,
			{Articles:Date} AS `Date`,
			{Articles:Topic} AS `Topic`,
			{Articles:DescriptionOfChange} AS `DescriptionOfChange`,
			{Articles:Version} AS `Version`
				FROM
			{Articles}
				WHERE
			{Articles:AdressInSQL} = :AdressInSQL
			');
		
		$ArticlesQuery->execute(array(":AdressInSQL" => $IAQuery['adressinsql'])); // kurde co by tu wymyslic, bez klucza w myqsl
		
		
		foreach($ArticlesQuery->fetchAll(PDO::FETCH_ASSOC) as $Text){
			$this->content .= '
				<tr>
					<td>'.$Text['ID'].'</td>
					<td>'.$Text['Date'].'</td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/Articles/A/?id='.$Text['ID'].'" class="xv-get-window" >'.htmlspecialchars($Text['Topic']).'</a></td>
					<td>'.htmlspecialchars($Text['DescriptionOfChange']).'</td>
					<td>'.htmlspecialchars($Text['Version']).'</td>
				</tr>';
		}
		
		
		$this->content .= '</tbody> 
				</table>
			</div>';
		
		if(!empty($_POST)){
			
			exit($this->content);
		}
		
	}
	
}	
class XV_Admin_articles_a {
	var $style = "height: 500px; width: 80%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "";
	var $content = "";
	var $id = "";
	var $Date;
	public function __construct(&$XVweb){
		global $Language;
		$_GET['id'] = (int) $_GET['id'];
		$this->title = "Edit Article: ID - ".$_GET['id'];
		$this->id = "a-".$_GET['id']."-window";
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/edittext.png';
		$this->URL = "Articles/A/?id=".$_GET['id'];
		$IAQuery = 	$XVweb->DataBase->prepare('SELECT * FROM {Articles} WHERE {Articles:ID} = :ID ; ');
		$IAQuery->execute(array(":ID"=> $_GET['id']));
		$IAQuery = $IAQuery->fetch(PDO::FETCH_ASSOC);
		if(empty($IAQuery)){
			$this->content = "<div class='error'> Nie znaleziono artykułu</div>";
			return;
		}
		$TableStructure = 	$XVweb->DataBase->prepare('DESCRIBE {Articles}');
		$TableStructure->execute();
		
		$TableStructure = $TableStructure->fetchAll(PDO::FETCH_ASSOC);	
		foreach($TableStructure as &$field){
			preg_match('/(?P<type>\w+)($|\((?P<length>(\d+|(.*)))\))/', $field["Type"], $matched);
			$field["Type"] = $matched;
		}
		
		include_once($GLOBALS['XVwebDir'].'libraries/formgenerator/formgenerator.php');
		$form=new Form();        
		$form->set("title", "Article edit");
		$form->set("name", "a_form");        
		$form->set("linebreaks", false);       
		$form->set("errorBox", "error");    
		$form->set("class", " xv-form");            
		$form->set("attributes", " data-xv-result='.content' ");     
		$form->set("errorClass", "error");       
		$form->set("divs", true);    
		$form->set("action", $GLOBALS['URLS']['Script'].'Administration/Get/Articles/A/?id='.$_GET['id']);
		$form->set("errorTitle", $Language['Error']);    
		$form->set("errorPosition", "before");		
		$form->set("submitMessage", "Zapisano");
		$form->set("showAfterSuccess", false);
		$form->JSprotection(uniqid());

		
		foreach($TableStructure as $field){
			$field["FieldDisplay"] = $XVweb->Config('db')->find('tables table#Articles field[name="'.$field["Field"].'"]')->attr("id")." (".$field["Field"].")";
			switch ($field["Type"]["type"]) {
			case "char":
			case "varchar":
				$form->addField("text", $field["Field"], $field["FieldDisplay"] , false, $IAQuery[$field["Field"]], " maxlength='".$field["Type"]["length"]."' " );
				$form->validator($field["Field"], "textValidator", 0, $field["Type"]["length"]); 
				break;
			case "int":
			case "mediumint":
				$form->addField("text", $field["Field"], $field["FieldDisplay"] , true, $IAQuery[$field["Field"]], " maxlength='".$field["Type"]["length"]."' " );
				$form->validator($field["Field"], "textValidator", 0, $field["Type"]["length"]); 
				$form->validator($field["Field"], "fromFunction", "is_numeric"); 
				break;
			case "datetime":
				$form->addField("text", $field["Field"], $field["FieldDisplay"] , false, $IAQuery[$field["Field"]], "class='datepicker'");
				$form->validator($field["Field"], "regExpValidator", "(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})", "Nieprawidłowa data"); 
				break;
			case "enum":
				$field["Type"]["length"] = str_replace(array('"', "'"), "", $field["Type"]["length"]);
				$field["Type"]["length"] = explode(",",$field["Type"]["length"]);
				$form->addField("select", $field["Field"], $field["FieldDisplay"], true, $IAQuery[$field["Field"]], array_combine($field["Type"]["length"], $field["Type"]["length"]));
				break;
			default:
				$form->addField("textarea", $field["Field"], $field["FieldDisplay"], false, $IAQuery[$field["Field"]], "cols='40' rows='7'");
				break;
				
			}
			
		}
		
		$form->addField("hidden", "a_submit", $Language['Save'], false);
		$Content .= $form->display($Language['Save'], "a_submit", false);  
		$result=($form->getData());
		if($result){
			exit("zapisano");
			//var_dump($result['language']);
		}
		
		$this->content = ($Content);
		
		if(!empty($_POST))
		exit($this->content);
		
		
		
	}
	
}
class XV_Admin_articles_dc {
	var $style = "max-height: 200px; width: 250px; left: 40%; top: 100px;";
	public function __construct(&$XVweb){
		$this->URL = "Articles/DC/?id=".urlencode($_GET['id']);
		$this->id = "xv-dc-d-".substr(md5($_GET['id']), 28);
		$this->title = "Delete comment ".basename($_GET['id']);
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
		
		
		if(isset($_POST['xv-comment'])){
			if(!is_numeric($_POST['xv-comment']))
			exit("<div class='failed'>Błąd : ID nie jest INT</div>");
			
			if($XVweb->Session->GetSID() != $_POST['xv-sid'])
			exit("<div class='failed'>Błąd : Zły SID</div>");
			
			$DeleteCommentSQL = $XVweb->DataBase->prepare('DELETE FROM {Comments} WHERE {Comments:ID} = :IDComment LIMIT 1');
			$DeleteCommentSQL->execute(array(':IDComment' => ($_POST['xv-comment'])));
			$XVweb->Log("DeleteComment", array("CommentID"=> ($_POST['xv-comment'])));
			echo "<div class='success'>Komentarz usunięty ID - ".($_POST['xv-comment']).".</div>
					<script type='text/javascript'>
						$('.xv-comments-row-".($_POST['xv-comment'])."').hide('slow');
					</script>
					"; 
			
			
			exit;
		}
		$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Articles/DC/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['id']).'" name="xv-comment" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
					<div style="text-align:center;">Do you want delete comment ID : '.htmlspecialchars($_GET['id']).' ?</div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="'.ifsetor($GLOBALS['Language']['Yes'], "Yes").'" /></td>
							<td><input type="button" value="'.ifsetor($GLOBALS['Language']['No'], "No").'" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
	}
}

$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('XV_Admin_articles_'.$CommandSecond)) {
	$XVClassName = 'XV_Admin_articles_'.$CommandSecond;
}else
$XVClassName = "XV_Admin_articles";


?>