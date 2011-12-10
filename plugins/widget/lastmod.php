<?php
//include($GLOBALS['RootDir'].DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'widget'.DIRECTORY_SEPARATOR.'lastmod.php');
class LastModWidget
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		$this->Date['LastArticles'] = array();
	}
	public function &LastArticles(){
			$RecordsLimit = 50;
	$this->Date['LastArticles'] =  $AddFileSQL = $this->Date['XVweb']->DataBase->pquery('SELECT 
		{ListArticles:URL} AS `URL`,
		{ListArticles:Date} AS `Date`,
		{ListArticles:Topic} AS `Topic`
	FROM {ListArticles} WHERE {ListArticles:Accepted} = "yes" ORDER BY {ListArticles:Date} DESC LIMIT '.$RecordsLimit.';')->fetchAll(PDO::FETCH_ASSOC);
	return $this;
	}
	public function gethtml(){
	global $URLS;
	$result ="<div id='LastArticles'>".chr(13).
	'<ul>'.chr(13);
		foreach($this->Date['LastArticles'] as $value){
		$result .= "<li><a href='".$URLS['Script']. $this->Date['XVweb']->URLRepair(substr(str_replace(" ", "_", $value['URL']),1))."'>".htmlspecialchars($value['Topic'])."</a></li>".chr(13);
		}
		$result .="</ul></div>";
		return $result;
	}

}
$MyResult =  $GLOBALS['XVwebEngine']->InitClass('LastModWidget')->LastArticles()->gethtml();


?>