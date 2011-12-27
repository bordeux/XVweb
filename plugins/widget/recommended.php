<?php
//include($GLOBALS['RootDir'].DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'widget'.DIRECTORY_SEPARATOR.'lastmod.php');
class RecommendedWidget
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		$this->Date['LastArticles'] = array();
	}
	public function &Recommended(){
	$QuerySQL = '
SELECT
	`IA`.{ListArticles:URL} AS `URL`,
	`IA`.{ListArticles:Date} AS `Date`,
	`IA`.{ListArticles:Tag} AS `Tags`,
	`AA`.{Articles:Topic} AS `Topic`, 
	`AA`.{Articles:Contents}  AS `Contents`, 
	`IA`.{ListArticles:Options}  AS `Options`, 
	`AA`.{Articles:Author} AS `Author`
FROM 
		{ListArticles} AS `IA` INNER JOIN
        {Articles} AS `AA` ON (`IA`.{ListArticles:AdressInSQL} = `AA`.{Articles:AdressInSQL} )
		
WHERE
        `IA`.{ListArticles:Accepted} = "yes" AND
        `IA`.{ListArticles:Category} = :CategorySelect  AND
        `AA`.{Articles:Version} = `IA`.{ListArticles:ActualVersion}
ORDER BY `IA`.{ListArticles:Date}
DESC
LIMIT 15';


			$QueryNews = $this->Date['XVweb']->DataBase->prepare($QuerySQL);

		$QueryNews->execute(array(
		":CategorySelect"=>"/System/Recommended/",
		));
		return $QueryNews->fetchAll(PDO::FETCH_ASSOC);
		
	}
	
	public function gethtml(){
	global $URLS;
				if($this->Date['XVweb']->Cache->exist("WidGet",("RecommendedWidget")))
					return $this->Date['XVweb']->Cache->get();
					
	$result = "<div id='RecommendedWidget'>";
		foreach($this->Recommended() as $recom){
		$Content = $this->Date['XVweb']->TextParser()->set("Options", unserialize($recom['Options']))->set("Blocked", 1)->SetText($recom['Contents'])->Parse()->ToHTML();
		$result .= "
		<div>
			<div class='WContent'>{$Content}</div>
		</div>
		";
		}
		$result .= "</div>";
		return $this->Date['XVweb']->EvalHTML($this->Date['XVweb']->Cache->put("WidGet",("RecommendedWidget"), $result));
	}

}

$MyResult =  $GLOBALS['XVwebEngine']->InitClass('RecommendedWidget')->gethtml();


?>