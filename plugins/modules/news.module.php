<?php
if(!isset($NPSConfig)){
	$NPSConfig = array("NoneCategory"=>"/News/");
}
class NewsPageScript
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		$this->Date['LastArticles'] = array();
		$this->Date['CountRows'] = 0;
		$this->Date['Options'] = array("Template"=>"news_contents.tpl", "Parse"=>false, "CharsLimit"=>0, "ActualPage"=>(int)$_GET['NewsPage'], "Category"=>"/News/", "EveryPage"=> (int) ifsetor($this->Date['XVweb']->Config("config")->find('config pagelimit news')->text(), 30));
	}
	public function &LastNews($Date= array()){

		$this->Date['Options']= array_merge($this->Date['Options'],$Date);
		
		//**********************************************************	
		$QuerySQL = '
SELECT SQL_CALC_FOUND_ROWS
	(SELECT count(*) FROM {Comments} WHERE {Comments:IDArticleInSQL} = `IA`.{Text_Index:AdressInSQL}) AS `CommentsCount`,
	((SELECT CONCAT(COALESCE( SUM({Votes:Vote}), 0),"|", COUNT(*)) FROM {Votes} WHERE {Votes:Type} = :TypeVote AND  {Votes:SID} =  IA.{Text_Index:ID} )) AS `Votes`,
	`IA`.{Text_Index:URL} AS `URL`,
	`IA`.{Text_Index:ID} AS `ID`,
	`IA`.{Text_Index:Date} AS `Date`,
	`IA`.{Text_Index:Tag} AS `Tags`,
	`IA`.{Text_Index:Options} AS `Options`,
	`AA`.{Articles:Topic} AS `Topic`, 
	'.(isset($this->Date['Options']['NoContent']) ?'""' : ($this->Date['Options']['CharsLimit'] ? 'SUBSTRING(`AA`.{Articles:Contents} ,1,'.$this->Date['Options']['CharsLimit'].')' : '`AA`.{Articles:Contents}')).' AS `Contents`, 
	`AA`.{Articles:Author} AS `Author`
FROM 
		{Text_Index} AS `IA` INNER JOIN
		{Articles} AS `AA` ON (`IA`.{Text_Index:AdressInSQL}  = `AA`.{Articles:AdressInSQL})
WHERE
		`IA`.{Text_Index:Accepted} = "yes" AND
	'.(!isset($this->Date['Options']['NoneCategory']) ? (' `IA`.{Text_Index:Category} = :CategorySelect  AND') : '').'
		`AA`.{Articles:Version} = `IA`.{Text_Index:ActualVersion}
ORDER BY `IA`.{Text_Index:Date} DESC
LIMIT '.($this->Date['Options']["ActualPage"]*$this->Date['Options']["EveryPage"]).', '.($this->Date['Options']["EveryPage"]);
		//**********************************************************

		$QueryNews = $this->Date['XVweb']->DataBase->prepare($QuerySQL);
		$SetArray = (isset($this->Date['Options']['NoneCategory']) ? array(
		":TypeVote" =>"article"
		) :array(
		":CategorySelect"=>$this->Date['Options']['Category'],
		":TypeVote" =>"article"
		));

		$QueryNews->execute($SetArray);
		$this->Date['News'] = $QueryNews->fetchAll(PDO::FETCH_ASSOC);
		foreach($this->Date['News'] as $key=>&$val){
			$val['Options'] = unserialize($val['Options']);
			if(is_array($val['Options']['AccessFlags'])){
				foreach($val['Options']['AccessFlags'] as $flag){
					if(!$this->Date['XVweb']->Admin[$flag])
					unset($this->Date['News'][$key]);
				}
				
			}
			list($val['Votes'], $val['VotesCount']) = explode('|',$val['Votes']);
			
			if($this->Date['Options']['Parse'])
			$val['Contents'] = $this->Date['XVweb']->TextParser(true)->set("Options", $val['Options'])->SetText($val['Contents'])->Parse()->ToHTML(); else
			$val['Contents'] = htmlspecialchars($val['Contents']);
			
		}
		unset($val);
		unset($flag);
		
		$this->Date['CountRows'] = $this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `CountRows`;')->fetch(PDO::FETCH_OBJ)->CountRows;
		return $this;
	}
	public function gethtml(){
		global $Smarty;
		include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		$pager = pager($this->Date['Options']['EveryPage'], (int) $this->Date['CountRows'],  "?".$this->Date['XVweb']->AddGet(array("NewsPage"=>"-npage-id-"), true), $this->Date['Options']['ActualPage']);
		$Smarty->assign('Pager', $pager);
		$Smarty->assign('News', $this->Date['News']);
		$Smarty->display('contents'.DIRECTORY_SEPARATOR.$this->Date['Options']['Template']);
	}
}
if(!isset($NPSConfig['NoExecute'])){
	xv_append_css($GLOBALS['URLS']['Theme'].'css/news.css', 24);
	$GLOBALS['JSBinder'][26] = 'news';
	$GLOBALS['XVwebEngine']->InitClass('NewsPageScript')->LastNews($NPSConfig)->gethtml();
}

?>