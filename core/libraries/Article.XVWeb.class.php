<?php


class XVArticle
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	function Edit($IdInArticleIndex = null, $Contents=null, $Change = null, $Author = null){
		if(empty($this->Date['XVweb']->SaveModificationArticle['Topic']))
		$this->Date['XVweb']->SaveModificationArticle['Topic'] = $this->Date['XVweb']->ReadArticleOut['Topic'];
		
		if(!is_null($Author))
		$this->Date['XVweb']->SaveModificationArticle['Author'] = $Author;
		if(!is_null($Contents))
		$this->Date['XVweb']->SaveModificationArticle['Contents'] = $Contents;
		if(!is_null($Change))
		$this->Date['XVweb']->SaveModificationArticle['Change'] = $Change;
		if(empty($this->Date['XVweb']->SaveModificationArticle['Author']))
		$this->Date['XVweb']->SaveModificationArticle['Author'] = $this->Date['XVweb']->Session->Session('user_name');

		if(strlen(trim($Change)) < 6){
			$this->Date['XVweb']->SaveModificationArticleError = "ToShortDescription"; //za krotki opis zmian
			return false;
		}

		if(!$this->Date['XVweb']->permissions('EditArticle')){
			$this->Date['XVweb']->SaveModificationArticleError = "AccessDenied"; //brak dostepu
			return false;
		}

		if(!is_null($IdInArticleIndex) && !is_numeric($IdInArticleIndex)){
			$this->Date['XVweb']->SaveModificationArticleError = "BadIDArticle"; //blad przy podaniu ID
			return false;
		}
		if(!empty($IdInArticleIndex)){
			$this->Date['XVweb']->SaveModificationArticle['ID'] = $IdInArticleIndex;
		}

		if(empty($this->Date['XVweb']->SaveModificationArticle['ID']) or !is_numeric($this->Date['XVweb']->SaveModificationArticle['ID'])){
			$this->Date['XVweb']->SaveModificationArticleError = "BadIDArticle"; //blad przy przypisaniu ID 
			return false;
		}


		$this->Date['XVweb']->ArticleFooIDinArticleIndex = ($this->Date['XVweb']->SaveModificationArticle['ID']);
		if(!($this->Date['XVweb']->ReadArticle())){
			switch(($this->Date['XVweb']->ReadArticleError))
			{
			case 1:	
				$this->Date['XVweb']->SaveModificationArticleError = "BadIDArticle"; // zle podales id
				return false;                        
				break;
			case 2:
				$this->Date['XVweb']->SaveModificationArticleError = "ArticleDoesntExist"; // art nie istnieje
				return false;
				break;
			default:
				$this->Date['XVweb']->SaveModificationArticleError = "Error"; // inny bład :D
				return false;     
			}
		}
		$NextVersion = (($this->Date['XVweb']->ReadArticleOut['Version'])+1);


		$SaveModificationArticleSQL = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Articles} ({Articles:AdressInSQL} , {Articles:Date}, {Articles:Topic}, {Articles:Contents}, {Articles:Author} , {Articles:DescriptionOfChange} , {Articles:Version}) VALUES (:IDUrlExecute, NOW(), :TopicArticleExecute, :ContentsArticleExecute, :AuthorArticleExecute, :ChangeArticleExecute, :NewVersionArticleExecute )');
		$SaveModificationArticleSQL->execute(
		array(
		':IDUrlExecute' => ($this->Date['XVweb']->ReadArticleOut['AdressInSQL']), 
		':TopicArticleExecute' => $this->Date['XVweb']->SaveModificationArticle['Topic'],
		':AuthorArticleExecute' => ($this->Date['XVweb']->SaveModificationArticle['Author']),
		':ContentsArticleExecute' => ($this->Date['XVweb']->SaveModificationArticle['Contents']),
		':ChangeArticleExecute' => ($this->Date['XVweb']->SaveModificationArticle['Change']), 
		':NewVersionArticleExecute' => ($NextVersion)
		)
		);
		$this->Date['XVweb']->DataBase->pquery('UPDATE {Text_Index}
	SET 
	{Text_Index:ActualVersion}  = '.($NextVersion).'
	WHERE 
	{Text_Index:AdressInSQL}  = '.$this->Date['XVweb']->DataBase->quote($this->Date['XVweb']->ReadArticleOut['AdressInSQL']).';');
		
		$this->Date['XVweb']->Cache->clear("Article", ($this->Date['XVweb']->ReadArticleIndexOut['URL']));
		$this->Date['XVweb']->Cache->clear("Article-Include", ($this->Date['XVweb']->ReadArticleIndexOut['URL'] ));
		$this->Date['XVweb']->Log("EditArticle", array("URL"=>$this->Date['XVweb']->ReadArticleIndexOut['URL']));
		
		$this->BookmarkEvent($this->Date['XVweb']->ReadArticleIndexOut['ID'], "article", '/System/Emails/OnArticleEdited/', array(
		"{{link}}"=>$this->Date['XVweb']->ReadArticleIndexOut['URL'],
		"{{topic}}"=>$this->Date['XVweb']->ReadArticleIndexOut['Topic'],
		"{{id}}"=>$this->Date['XVweb']->ReadArticleIndexOut['ID'],
		"{{by}}"=>  $this->Date['XVweb']->Session->Session('user_name'),
		));
		
		return true;
	}
	public function ChangeURL($from, $to){
		$Category =  $this->Date['XVweb']->ReadCategoryArticle(($to)); 
		if($this->Date['XVweb']->isset_article($to))
		return false;
		if($Category != "/"){
			if(!$this->Date['XVweb']->isset_article($Category))
			return false;
		}
		if(substr($to, 0, strlen($from)) == $from)
		return false;
		$DataSet =array(
		":PathFrom"=> $from,
		":PathTo"=>$to
		);
		
		$this->Date['XVweb']->DataBase->prepare('
UPDATE {Text_Index} SET {Text_Index:URL} = CONCAT(:PathTo, SUBSTRING({Text_Index:URL} , (length(:PathFrom)+1))) WHERE {Text_Index:URL} LIKE CONCAT(:PathFrom, \'%\');
')->execute($DataSet);

		$this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} 
			SET
			{Text_Index:Category} = CONCAT(:PathTo, SUBSTRING({Text_Index:Category} , LENGTH(:PathFrom)+1)) WHERE {Text_Index:Category} LIKE CONCAT(:PathFrom, \'%\');')->execute($DataSet);

		$this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} 
			SET
			{Text_Index:Category} = :Category WHERE {Text_Index:URL} = :URLarticle LIMIT 1;')->execute(
		array(
		":Category" => $Category,
		":URLarticle"=>$to
		)
		);
		$this->Date['XVweb']->Log("ChangePath", array("From"=>$from, "To"=>$to));
		return true;
	}
	/************************************************************************************************/
	public function EditIndexArticle($ID, $settings = array()){
		$ToChange = array();
		$ToValues = array();
		foreach($settings as $Key=>$Value){
			if($this->Date['XVweb']->DataBase->isset_field("Text_Index", $Key)){
				$ToChange[] = "{Text_Index:".$Key."} = :".$Key.'Exec';
				$ToValues[':'.$Key.'Exec'] = $Value;
			}
		}
		if(empty($ToChange))
		return true;
		$ToValues[':IDExecute'] = $ID ;
		$SettingsSQL = $this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} SET '.implode(", ", $ToChange).' WHERE {Text_Index:ID} = :IDExecute');
		$SettingsReturn = $SettingsSQL->execute($ToValues);
		$IDtoURLTmp = $this->Date['XVweb']->IDtoURL($ID);
		$this->ClearArticleCache($ID, $IDtoURLTmp);
		if($SettingsReturn)
		return $IDtoURLTmp; else
		return false;
	}
	/************************************************************************************************/
	function Add($UrlArticle=null, $ContentsArticle=null, $AuthorArticle=null, $TopicArticle=null, $CategoryArticle=null){
		if(!is_null($UrlArticle)){
			$this->Date['XVweb']->SaveArticle['URL'] = $UrlArticle;
		}
		if(!is_null($TopicArticle)){
			$this->Date['XVweb']->SaveArticle['Topic'] = $TopicArticle;
		}
		if(!is_null($ContentsArticle)){
			$this->Date['XVweb']->SaveArticle['Contents'] = $ContentsArticle;
		}
		if(empty($AuthorArticle)){
			$this->Date['XVweb']->SaveArticle['Author'] = $AuthorArticle;
			if(empty($this->Date['XVweb']->SaveArticle['Author'])){
				$this->Date['XVweb']->SaveArticle['Author'] = $this->Date['XVweb']->Session->Session('user_name');
			}

		}
		if(!is_null($CategoryArticle)){
			$this->Date['XVweb']->SaveArticle['Category'] = $CategoryArticle;
		}
		$this->Date['XVweb']->SaveArticle['URL'] = $this->Date['XVweb']->add_path_slashes($UrlArticle); //yu
		$this->Date['XVweb']->SaveArticle['URL'] = str_replace("_", " ", $this->Date['XVweb']->SaveArticle['URL']);
		if(strripos($this->Date['XVweb']->SaveArticle['URL'], '"') or strripos(($this->Date['XVweb']->SaveArticle['URL']), "'")){
			$this->Date['XVweb']->SaveArticleError = "IllegalCharacters";
			return false; // nie dozwolone znakli
		}


		$CheckIndexArticleSQL = $this->Date['XVweb']->DataBase->prepare('SELECT * FROM {Text_Index} WHERE  {Text_Index:URL} = :AddressInSQLExecute LIMIT 1');
		$CheckIndexArticleSQL->execute(
		array(
		':AddressInSQLExecute' => ($this->Date['XVweb']->SaveArticle['URL'])
		)
		);

		if(($CheckIndexArticleSQL->rowCount())){
			$this->Date['XVweb']->SaveArticleError = "ArticleIsset";
			return false; // taki art juz jest
		}

		if(empty($this->Date['XVweb']->SaveArticle['Category'])){
			$CheckCategory  = $this->Date['XVweb']->ReadCategoryArticle(($this->Date['XVweb']->SaveArticle['URL'])); //tu
			if($CheckCategory != "/"){
				$this->Date['XVweb']->SaveArticle['Category'] = $CheckCategory;
			}
		}
		
		$this->Date['XVweb']->SaveArticle['Category'] = str_replace("_", " ", $this->Date['XVweb']->SaveArticle['Category']);
		if($this->Date['XVweb']->SaveArticle['Category'] !='/'){
			$CheckMatrixArticle = $this->Date['XVweb']->DataBase->prepare('SELECT * FROM {Text_Index} WHERE {Text_Index:URL} = :MatrixExecute LIMIT 1');
			$CheckMatrixArticle->execute(
			array(
			':MatrixExecute' => ($this->Date['XVweb']->SaveArticle['Category'])
			)
			);

			if(!($CheckMatrixArticle->rowCount())){
				$this->Date['XVweb']->SaveArticleError = "CategoryDoesNotExist";
				return false; // brak macierzy
			}
		}
		if(empty($this->Date['XVweb']->SaveArticle['Topic'])){
			$this->Date['XVweb']->SaveArticle['Topic'] =  $this->Date['XVweb']->read_sufix_from_url(($this->Date['XVweb']->SaveArticle['URL'])); //tu
		}

		// blokowanie pisania w zablokowanej kategorii


		$UNIQID = uniqid();
		$SaveArticleSQL = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Text_Index} ({Text_Index:Date} , {Text_Index:URL}, {Text_Index:Topic}, {Text_Index:Tag} , {Text_Index:Category} , {Text_Index:AdressInSQL} , {Text_Index:Accepted} ) VALUES (NOW(), :AddressURLExecute, :TopicIndexArticleExecute, :TagIndexArticleExecute, :CategoryIndexArticleExecute, :AddressInSQLExecute,   :AcceptArticles); 
INSERT INTO {Articles} ({Articles:AdressInSQL} , {Articles:Date}, {Articles:Topic}, {Articles:Contents}, {Articles:Author} , {Articles:DescriptionOfChange} , {Articles:Version}) VALUES (:AddressInSQLExecute, NOW(), :TopicArticleExecute, :ContentsArticleExecute, :AuthorArticleExecute, null, 1 )');
		$SaveArticleSQL->execute(
		array(
		':AddressURLExecute' => ($this->Date['XVweb']->SaveArticle['URL']),
		':TopicIndexArticleExecute' => ($this->Date['XVweb']->SaveArticle['Topic']),
		':TagIndexArticleExecute' => ($this->Date['XVweb']->SaveArticle['Topic']) ,
		':CategoryIndexArticleExecute' => (empty($this->Date['XVweb']->SaveArticle['Category'])? null : $this->Date['XVweb']->SaveArticle['Category']),
		':AddressInSQLExecute' => ($UNIQID),
		':TopicArticleExecute' => ($this->Date['XVweb']->SaveArticle['Topic']),
		':ContentsArticleExecute' => ($this->Date['XVweb']->SaveArticle['Contents']) ,
		':AuthorArticleExecute' => ($this->Date['XVweb']->SaveArticle['Author']),
		':AcceptArticles' => ($this->Date['XVweb']->permissions('AutoAccept') ? "yes":"no"),
		)
		);
		$this->Date['XVweb']->Cache->clear("GetDivisions",(empty($this->Date['XVweb']->SaveArticle['Category'])? null : $this->Date['XVweb']->SaveArticle['Category']));

		return true;
	}
	public function AddAlias($url, $IDArticle){
		$url =  $this->Date['XVweb']->add_path_slashes($url); 
		$topic =  $this->Date['XVweb']->read_sufix_from_url($url);
		$category =  $this->Date['XVweb']->ReadCategoryArticle($url);
		if($category != "/"){
			if(!$this->Date['XVweb']->isset_article($category))
			return false;
		}
		
		if($this->Date['XVweb']->isset_article($url))
		return false;
		
		$this->Date['XVweb']->ArticleFooIDinArticleIndex = $IDArticle;
		if(!($this->Date['XVweb']->ReadArticle())){
			return false;
		}
		
		$AddAlias = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Text_Index} ({Text_Index:Date}, {Text_Index:URL} , {Text_Index:Topic}, {Text_Index:Tag} , {Text_Index:Category} , {Text_Index:AdressInSQL} ,  {Text_Index:Alias}, {Text_Index:Accepted} ) VALUES ( NOW() , :AddressURLExecute, :TopicIndexArticleExecute, :TagIndexArticleExecute, :CategoryIndexArticleExecute, :AddressInSQLExecute , 1, 1); ');
		$AddAlias->execute(
		array(
		":AddressURLExecute"=>$url,
		":TopicIndexArticleExecute"=>$topic,
		":TagIndexArticleExecute"=>$topic,
		":CategoryIndexArticleExecute"=>$category ,
		":AddressInSQLExecute"=> $this->Date['XVweb']->ReadArticleOut['LocationInSQL'],
		)
		);
		$this->Date['XVweb']->Log("AddAlias", array(
		"URL"=>$url,
		"SecondURL"=>$this->Date['XVweb']->ReadArticleOut['URL'],
		"User"=> $this->Date['XVweb']->Session->Session('user_name'),
		"IP"=> $_SERVER['REMOTE_ADDR'],
		));
		return true;
		
	}
	public function DelAlias(){
		
	}
	
	function SaveAmendment($IDArticle = null, $Contents=null, $Topic=null){

		if(!$this->Date['XVweb']->permissions('Amendments')){
			$this->Date['XVweb']->SaveModificationArticleError = 7; //brak dostepu
			return false;
		}

		$this->Date['XVweb']->ArticleFooIDinArticleIndex = ($IDArticle);
		if(!($this->Date['XVweb']->ReadArticle())){
			switch(($this->Date['XVweb']->ReadArticleError))
			{
			case 1:	
				$this->Date['XVweb']->SaveModificationArticleError = 1; // zle podales id
				return false;                        
				break;
			case 2:
				$this->Date['XVweb']->SaveModificationArticleError = 3; // art nie istnieje
				return false;
				break;
			default:
				$this->Date['XVweb']->SaveModificationArticleError = 4; // inny bład :D
				return false;     
			}
		}
		$IDArticle= ($this->Date['XVweb']->ReadArticleOut['ID']);

		$SQLAmendment = $this->Date['XVweb']->DataBase->prepare('UPDATE {Articles} SET {Articles:Contents} =  :Contents '.(is_null($Topic) ? "" :" , {Articles:Topic} = :Topic ").'WHERE {Articles:ID} = :IDarticle;');
		$ExArray = array(
		':Contents' => ($Contents),
		':IDarticle' => $IDArticle
		);
		if(!is_null($Topic))
		$ExArray[":Topic"] = $Topic;
		$SQLAmendment->execute($ExArray);
		
		$this->ClearArticleCache(null, $this->Date['XVweb']->ReadArticleIndexOut['URL'], $this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL']);
		$this->Date['XVweb']->Log("Amendment", array(
		"URL"=>$this->Date['XVweb']->ReadArticleIndexOut['URL'],
		"User"=> $this->Date['XVweb']->Session->Session('user_name'),
		"IP"=> $_SERVER['REMOTE_ADDR'],
		));
		
		$this->BookmarkEvent($this->Date['XVweb']->ReadArticleIndexOut['ID'], "article", '/System/Emails/OnArticleEdited/', array(
		"{{link}}"=>$this->Date['XVweb']->ReadArticleIndexOut['URL'],
		"{{topic}}"=>$this->Date['XVweb']->ReadArticleIndexOut['Topic'],
		"{{id}}"=>$this->Date['XVweb']->ReadArticleIndexOut['ID'],
		"{{by}}"=>  $this->Date['XVweb']->Session->Session('user_name'),
		));
		return true;
	}
	/************************************************************************************************/
	public function BlockArticle($ID,$value="yes", $Subarticles = false){
		if($Subarticles){
			$BlockArticle = $this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} SET {Text_Index:Blocked} = :BlockExecute WHERE {Text_Index:URL} LIKE :URLArticle');
			$BlockArticleReturn = $BlockArticle->execute(array(
			':BlockExecute' => $value,
			':URLArticle' => $this->Date['XVweb']->IDtoURL($ID).'%'
			));
			$this->Date['XVweb']->Cache->clear("Article");
			$this->Date['XVweb']->Cache->clear("ArticleBlocked");
		}else{
			$BlockArticle = $this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} SET {Text_Index:Blocked} = :BlockExecute WHERE {Text_Index:ID} = :IDExecute');
			$BlockArticleReturn = $BlockArticle->execute(array(
			':BlockExecute' => $value,
			':IDExecute' => $ID 
			));
		}
		if($BlockArticleReturn)
		return true; else
		return false;
	}
	public function AcceptArticle($ID,$value="yes", $Subarticles = false){
		if($Subarticles){
			$AcceptArticle = $this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} SET {Text_Index:Accepted} = :AcceptedExecute WHERE {Text_Index:URL} LIKE :URLArticle');
			$AcceptArticleReturn = $AcceptArticle->execute(array(
			':AcceptedExecute' => $value,
			':URLArticle' => $this->Date['XVweb']->IDtoURL($ID).'%'
			));
			$this->Date['XVweb']->Cache->clear("Article");
			$this->Date['XVweb']->Cache->clear("ArticleAccepted");
		}else{
			$AcceptArticle = $this->Date['XVweb']->DataBase->prepare('UPDATE {Text_Index} SET {Text_Index:Accepted} = :AcceptedExecute WHERE {Text_Index:ID} = :IDExecute');
			$AcceptArticleReturn = $AcceptArticle->execute(array(
			':AcceptedExecute' => $value,
			':IDExecute' => $ID 
			));
		}
		if($AcceptArticleReturn)
		return true; else
		return false;
	}
	public function ClearArticleCache($ID = null, $URL = null, $IDLoc = null ){
		if(is_null($URL))
		$URL= $this->Date['XVweb']->IDtoURL($ID);
		if(is_null($ID))
		$ID = $this->Date['XVweb']->URLtoID($URL);
		$this->Date['XVweb']->Cache->clear("ArticleBlockedURL", $URL);
		$this->Date['XVweb']->Cache->clear("Article", $IDLoc);
		$this->Date['XVweb']->Cache->clear("Article-Include",$URL);
		$this->Date['XVweb']->Cache->clear("ArticleBlocked", $ID);
		$this->Date['XVweb']->Cache->clear("ArticleParse");
	}
	
	public function DeleteArticle($ID){
		if(!is_numeric($ID))
		return false;
		if(!$this->Date['XVweb']->permissions('DeleteArticle')){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(122);
			return false;
		}

		$this->Date['XVweb']->ArticleFooIDinArticleIndex = $ID;
		$this->Date['XVweb']->ReadArticle();
		

		if($this->Date['XVweb']->ReadArticleIndexOut['Alias'] == "yes"){
			$DeleteArticleSQL = $this->Date['XVweb']->DataBase->prepare('
DELETE FROM {Text_Index} WHERE {Text_Index:ID} = :IDExec;');
			$DeleteArticleSQL->execute(
			array(
			':IDExec' => $this->Date['XVweb']->ReadArticleIndexOut['ID']
			)
			);
			
		}else{
			$DeleteArticleSQL = $this->Date['XVweb']->DataBase->prepare('
DELETE FROM {Text_Index} WHERE {Text_Index:AdressInSQL} = :AdressInSQLExecute ;');
			$DeleteArticleSQL->execute(
			array(
			':AdressInSQLExecute' => $this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL']
			)
			);
			$DeleteArticleSQL = $this->Date['XVweb']->DataBase->prepare('
DELETE FROM {Comments} WHERE {Comments:IDArticleInSQL} = :IDArticleExecute ;');
			$DeleteArticleSQL->execute(
			array(
			':IDArticleExecute' => $this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL']
			)
			);
			$DeleteArticleSQL = $this->Date['XVweb']->DataBase->prepare('
DELETE FROM {Articles} WHERE {Articles:AdressInSQL} = :AdressInSQLExecute ;');
			$DeleteArticleSQL->execute(
			array(
			':AdressInSQLExecute' => $this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL']
			)
			);
		}
		$this->ClearArticleCache($this->Date['XVweb']->ReadArticleIndexOut['ID'], $this->Date['XVweb']->ReadArticleIndexOut['URL'], $this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL']);
		$this->Date['XVweb']->Log("DeleteArticle", array("ArticleURL"=>$this->Date['XVweb']->ReadArticleIndexOut['URL'], "ArticleID"=>$this->Date['XVweb']->ReadArticleIndexOut['ID']));
		$this->BookmarkEvent($this->Date['XVweb']->ReadArticleIndexOut['ID'], "article", '/System/Emails/OnArticleDelete/', array(
		"{{link}}"=>$this->Date['XVweb']->ReadArticleIndexOut['URL'],
		"{{topic}}"=>$this->Date['XVweb']->ReadArticleIndexOut['Topic'],
		"{{id}}"=>$this->Date['XVweb']->ReadArticleIndexOut['ID'],
		"{{by}}"=>  $this->Date['XVweb']->Session->Session('user_name'),
		));
		return true;
	}
	public function bokmarks($id, $val = true, $type = "Observed", $cat = "article",  $user = null){
		if(is_null($user))
		$user = $this->Date['XVweb']->Session->Session('user_name');
		
		$AddBookMark = $this->Date['XVweb']->DataBase->prepare('INSERT INTO 
		{Bookmarks} ({Bookmarks:Uniq}, {Bookmarks:IDS}, {Bookmarks:Type} , {Bookmarks:User}, {Bookmarks:'.$type.'}) 
		VALUES 
		(:UNIQExec, :IDExec, :TypeExec, :UserExec ,:ValExec)
ON DUPLICATE KEY UPDATE {Bookmarks:'.$type.'} = :ValExec ;');

		$AddBookMark->execute(array(
		':UNIQExec' => substr(md5($id.$user),0,10),
		':IDExec' =>$id,
		':TypeExec' => $cat,
		':UserExec' => $user,
		':ValExec' => ($val ? 1 : 0)
		));

	}
	public function BookmarkEvent($ID, $type, $articleURL, $info){
		
		$info = array_merge((array)$info, array(
	
		'{{urlscript}}'=>$this->Date['XVweb']->Date['URLS']['Script'],
		'{{url}}'=>$this->Date['XVweb']->Date['URLS']['Site'],
		'{{theme}}'=>$this->Date['XVweb']->Date['URLS']['Theme'],
		
		));
		$this->Date['XVweb']->ArticleFooIDinArticleIndex ='';
		$this->Date['XVweb']->ArticleFooVersion = '';
		if(!($this->Date['XVweb']->ReadArticle($articleURL, "","BETh"))){
			///$this->Date['XVweb']->LoadException();
			//throw new XVwebException(5); 
			return false;
		}else{
			$MailContent = $this->Date['XVweb']->ParseArticleContents($this->Date['XVweb']->Date['BETh']['ReadArticleOut']['Contents']);
			$MailContent = strtr($MailContent, $info);
			$MailTopic = strtr($this->Date['XVweb']->Date['BETh']['ReadArticleIndexOut']['Topic'], $info);
		}
		
		$Query = $this->Date['XVweb']->DataBase->prepare('SELECT {Bookmarks:*:prepend:BT.} , UT.{Users:Mail} AS `Mail`   FROM {Bookmarks} AS `BT`, {Users} AS `UT`  WHERE BT.{Bookmarks:IDS} = :ID AND UT.{Users:User} = BT.{Bookmarks:User} AND BT.{Bookmarks:User} <> :User ;');
		$Query->execute(array(
		":ID" => $ID,
		":User" => $this->Date['XVweb']->Session->Session('user_name')
		));
		

		foreach ($Query->fetchAll() as $row) {
			$MailContent = strtr($MailContent, 		array(
			'{{user}}'=>$row['User'],
			'{{mail}}'=>$row['Mail'],
			'{{uniq}}'=>$row['Uniq'],
			));
			$this->Date['XVweb']->MailClass()->mail($row['Mail'], $MailTopic, $MailContent);

		}
		
	}
	function SaveComment($Comment=null, $LocationCommentID = null){
		if(!$this->Date['XVweb']->permissions('WriteComment')){ 
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(125);
			return false;
		}
		if(!is_null($Comment))
		$this->Date['XVweb']->Date['SaveComment'] =  $Comment;
		
		$this->Date['XVweb']->Date['SaveCommentAuthor'] =  $this->Date['XVweb']->Session->Session('user_name');
		
		if(is_numeric($LocationCommentID))
		$this->Date['XVweb']->Date['SaveCommentIDArticle'] =  $LocationCommentID;
		

		$this->Date['XVweb']->ArticleFooIDinArticleIndex = $this->Date['XVweb']->Date['SaveCommentIDArticle'];
		if(!($this->Date['XVweb']->ReadArticle())){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(40); // nie istnieje art
			return false;
		}
		if(ifsetor($this->Date['XVweb']->ReadArticleIndexOut['Options']['DisableComments'], 0)){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(41); //zablokowany art
			return false;
		}

		$SaveCommentSQL = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Comments}  ({Comments:Author} , {Comments:Date} , {Comments:IDArticleInSQL} , {Comments:IP}  , {Comments:Comment} , {Comments:Parsed} ) VALUES ( :CommentAuthorExecute , NOW(), :AdresInSQL , :CommentIPExecute, :CommentComment, :ParsedComment )');
		$SaveCommentSQL->execute(array(
		':CommentAuthorExecute' => ($this->Date['XVweb']->Date['SaveCommentAuthor']) ,
		':AdresInSQL' => $this->Date['XVweb']->ReadArticleIndexOut['AdressInSQL'],
		':CommentIPExecute' => ($_SERVER['REMOTE_ADDR']),
		':CommentComment' => ($this->Date['XVweb']->Date['SaveComment']),
		':ParsedComment' => $this->Date['XVweb']->TextParser()->CommentParse($this->Date['XVweb']->Date['SaveComment']),
		)
		);
		
		$this->Date['XVweb']->Date['SaveCommentID'] = $this->Date['XVweb']->DataBase->lastInsertId();

		$this->Date['XVweb']->Cache->clear("Comment",$this->Date['XVweb']->ReadArticleIndexOut['AdressInSQL']);
		$this->Date['XVweb']->SaveCommentError = 0;

		$this->Date['XVweb']->Log("NewComment", (array("CommentID" =>$this->Date['XVweb']->Date['SaveCommentID'], "ArticleID"=> $this->Date['XVweb']->Date['SaveCommentIDArticle'])));
		$this->BookmarkEvent($this->Date['XVweb']->ReadArticleIndexOut['ID'], "article", '/System/Emails/OnArticleComment/', array(
		"{{link}}"=>substr($this->Date['XVweb']->ReadArticleIndexOut['URL'],1),
		"{{topic}}"=>$this->Date['XVweb']->ReadArticleIndexOut['Topic'],
		"{{commentid}}"=>$this->Date['XVweb']->Date['SaveCommentID'],
		"{{id}}"=>$this->Date['XVweb']->ReadArticleIndexOut['ID'],
		"{{comment}}"=> htmlspecialchars($this->Date['XVweb']->Date['SaveComment']),
		"{{by}}"=>  $this->Date['XVweb']->Session->Session('user_name'),
		));
		return true;
	}
	
	public function GetTags($IDS){
		$GetTags = $this->Date['XVweb']->DataBase->prepare('SELECT group_concat({Tags:Tag} separator :Seperator) AS `tags` FROM {Tags}  WHERE {Tags:AdressInSQL} = :IDS ;');
		$GetTags->execute(array(
		':IDS' => ($IDS) ,
		':Seperator' => ','
		)
		);
		$Tags = $GetTags->fetch();
		return explode(',' , $Tags['tags']);
	}
	
	public function AddTags($IDS, $Tags, $User = null){
		if(is_null($User))
		$User = $this->Date['XVweb']->Session->Session('user_name');
		
		$Tags = str_replace(" ", ",", $Tags);
		$GetTags = $this->Date['XVweb']->DataBase->prepare('
					INSERT INTO {Tags} ({Tags:AdressInSQL} , {Tags:Tag}, {Tags:User}, {Tags:Date}) VALUES (:IDS, :Tag, :User, NOW()); 
				' );
		$Tags = explode(",", $Tags);
		foreach($Tags as $TagItem){
			$TagItem = trim($TagItem);
			$Added = 0;
			if(strlen($TagItem) > 2){
				$GetTags->execute(array(
				':IDS' => ($IDS) ,
				':Tag' => $TagItem,
				':User' => $User,
				)
				);
				++$Added;
			}
		}
		return $Added;
	}
}

?>