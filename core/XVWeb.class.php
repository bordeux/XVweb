<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   XVWeb.class.php   *************************
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
define('DownloadLink', "http://www.bordeux.net/xvweb/getlast/?version=1.0",  true);
if(!defined('Cache_dir'))
define('Cache_dir', dirname(__FILE__).DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'xv_config'.DIRECTORY_SEPARATOR.'xv_config.class.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Session.XVWeb.class.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'operation.XVWeb.class.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'db.XVWeb.class.php');

$LocationXVWeb = dirname(__FILE__);
class XVWeb extends OperationXVWeb
{	
	const Version = "1.0";
	//**********Baza**********//
	var $DataBase='';
	//**********/Baza**********//
	//**********XVWeb**********//
	var $IP='';
	var $Cookie = array();
	var $Server = array();
	//**********/XVWeb**********//
	//**********Sesje**********//
	var $Session='';
	//**********/Sesje**********//
	//**********Sesje**********//
	var $ParserMyBBcode;
	//**********/Sesje**********//
	//**********Sesje**********//
	var $HTMLtoDoc;
	//**********/Sesje**********//
	//*****Ustawienia Tabel********//
	var $DataBasePrefix = '';

	//*****/Ustawienia Tabel*******//
	//**********/Serwis**********//
	//**********Register********//
	var $Register = '';
	var $RegisterID = '';
	var $RegisterError = '';
	//*********/Register********//
	var $Date = array();
	//**********ReadArticle********//
	var $ReadArticleOut = null; //array
	var $ReadArticleIndexOut = null; //array
	var $ReadArticleError = '';
	var $ArticleFooLocation = '';
	var $ArticleFooVersion = '';
	var $ArticleFooIDinArticleIndex = '';
	//*********/ReadArticle*******//
	//**********SystemSQL********//
	var $SystemRegisterMail = 'RegisterMail';
	var $SystemRegisterResult = 'RegisterResult';
	//**********/SystemSQL*******//
	//**********Users********//
	var $ReadUser= "";
	//*********/Users********//
	//**********SaveArticle*******//
	var $SaveArticle = array();
	var $SaveArticleError;
	//*********/SaveArticle*******//
	//**********SaveModificationArticle*******//
	var $SaveModificationArticle = array();
	var $SaveModificationArticleError;
	//*********/SaveModificationArticle*******//
	var $XVwebError;
	var $Cache;
	/*************************************************************************************************************/
	//**********Admin**********//
	public $AdminCheck;
	//**********/Admin*********//
	public $Admin;
	function __construct($ConfigDir = null) {
		if(!is_null($ConfigDir) ){
			$this->Date['ConfigDir'] = $ConfigDir;
		}
		$this->Cookie =&$GLOBALS['_COOKIE'];
		$this->IP = $_SERVER['REMOTE_ADDR'];
	}
	/************************************************************************************************/
	public function &PreWork(){
		$this->Cache = new Cache($this);
		$this->Session = new SessionClass($this);
		if(is_null($this->Session->Session('user_permissions'))){
			$this->Session->Session('Logged_ID', 2);
			$this->Session->Session('Logged_User', "Anonymous");
			$this->Session->Session('user_group', "anonymous");
			$this->Session->Session('user_permissions', $this->get_group_permissions("anonymous"));
		}
		return $this;
	}
	/************************************************************************************************/
	public function connect_db() {
		try {
			$this->DataBase = new xvDB($this);
			$this->DataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->DataBase->setAttribute(PDO::ATTR_PERSISTENT, true);
			$this->DataBase->setAttribute(PDO::MYSQL_ATTR_DIRECT_QUERY, 1);
			$this->DataBase->setAttribute( PDO::ATTR_STATEMENT_CLASS, array( 'xvDB_statement', array(&$this->DataBase, &$this)) );
			$this->DataBase->exec("SET NAMES 'utf8' COLLATE 'utf8_bin'");
		} catch (PDOException $e) {
			$this->ErrorClass($e);
			return false;
		}
		return true;
	}
	/************************************************************************************************/
	public function __clone() {
		echo "Warning! XVweb is cloning !";
	}
	
	/************************************************************************************************/
	function LoadException() {
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Exception.XVWeb.class.php');
	}
	/************************************************************************************************/
	function IncludeParseHTML(){
		if(empty($this->ParserMyBBcode)){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'parser.MyHTML.XVweb.class.php');
			$this->ParserMyBBcode =new ParserMyHTML($this);
		}
	}
	/************************************************************************************************/
	function &TextParser($reload=false){
		if(empty($this->Date['Classes']['TextParser']) or $reload){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'parser.MyHTML.XVweb.class.php');
			$this->Date['Classes']['TextParser'] =new ParserMyHTML($this);
		}
		return $this->Date['Classes']['TextParser'];
	}
	/************************************************************************************************/
	function &AntyFlood() {
		if(empty($this->Date['Classes']['AntyFlood'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'AntyFlood.XVWeb.class.php');
			$this->Date['Classes']['AntyFlood'] = new AntyFlood($this);
		}
		return $this->Date['Classes']['AntyFlood'];
	}

	/************************************************************************************************/
	public function ActivateUser($User, $temppass){
		return $this->Users()->ActivateUser($User, $temppass);
	}
	/************************************************************************************************/
	public function GetDivisions($URLArticle = null){
			if(is_null($URLArticle)){
				$URLArticle = $this->ReadArticleIndexOut['URL'];
			}
			if($this->Cache->exist("GetDivisions",$URLArticle))
			return  $this->Cache->get();	
			$GetDivisions = $this->DataBase->prepare('SELECT {Text_Index:*} FROM {Text_Index} WHERE {Text_Index:Category} = :ExCategory AND {Text_Index:Accepted} = "yes" ORDER BY {Text_Index:Topic} ASC');
			$GetDivisions->execute(array(':ExCategory' => ($URLArticle)));
			return $this->Cache->put("GetDivisions", $URLArticle, $GetDivisions->fetchAll(PDO::FETCH_ASSOC));
	}
	/************************************************************************************************/
	function ReadArticle($address=null, $VersionArticle = "", $Theread = null) {
                        if(!empty($VersionArticle) or $VersionArticle != 0 && is_numeric($VersionArticle)){
                                $this->ArticleFooVersion = $VersionArticle;
                        }
                        if(!is_null($address)){
                                $this->ArticleFooLocation = $this->AddSlashesStartAndEnd($address); //tu
                                $this->ArticleFooLocation = str_replace("_", " ", $this->ArticleFooLocation);
                        }
                        if(!empty($this->ArticleFooIDinArticleIndex) && !is_numeric($this->ArticleFooIDinArticleIndex)){
                                $this->ReadArticleError  = 1; // bład przy doborze ID
                                return false;
                        }
                        if(!is_null($Theread)){
                                $IAS = $this->ReadArticleIndexOut;
                                $AAS = $this->ReadArticleOut;
                                //$this->ReadArticleIndexOut = &$this->Date[$Theread]['ReadArticleIndexOut'];
                                //$this->ReadArticleOut = &$this->Date[$Theread]['ReadArticleOut'];
                        }

                        $ExecArgs = array();
                        $ExecArgs[':TypeVote'] = 'article';

                        $Select .= '{Text_Index:*:prepend:IA.} , ((SELECT CONCAT(COALESCE( SUM({Votes:Vote}), 0),"|", COUNT(*)) FROM {Votes} WHERE {Votes:Type} = :TypeVote AND  {Votes:SID} =  IA.{Text_Index:ID} )) AS `Votes` ';

                        if($this->Session->Session('Logged_Logged') == true){
                                $Select .= ', ((SELECT CONCAT(COALESCE({Bookmarks:Observed} , 0),"|", COALESCE({Bookmarks:Bookmark}, 0)) FROM {Bookmarks} WHERE {Bookmarks:Type} = :TypeVote AND  {Bookmarks:IDS} =  IA.{Text_Index:ID}  AND {Bookmarks:User} = :UserExec)) AS `Bookmarks` ';
                                $ExecArgs[':UserExec'] = $this->Session->Session('Logged_User');
                        }

                        if(!empty($this->ArticleFooIDinArticleIndex)){
                                $ReadIndexArticleSQL = $this->DataBase->prepare('SELECT SQL_CACHE '.$Select.' FROM {Text_Index} AS `IA` WHERE {Text_Index:ID} = :IDExec LIMIT 1');
                                $ExecArgs[':IDExec'] = ($this->ArticleFooIDinArticleIndex);
                                $ReadIndexArticleSQL->execute($ExecArgs);
                        }else{
                                $ReadIndexArticleSQL = $this->DataBase->prepare('SELECT '.$Select.' FROM {Text_Index} AS `IA`  WHERE IA.{Text_Index:URL} = :AdresExec LIMIT 1');
                                $ExecArgs[':AdresExec'] = ($this->ArticleFooLocation);
                                $ReadIndexArticleSQL->execute($ExecArgs);
                        }
                        if(!($ReadIndexArticleSQL->rowCount())){
                                $this->ReadArticleOut = null;
                                $this->ReadArticleError  = 2; // art nie istnieje
                                return false;
                        }
                        $this->ReadArticleIndexOut = $ReadIndexArticleSQL->fetch(PDO::FETCH_ASSOC);
                        $this->ReadArticleIndexOut['LocationInSQL'] = $this->ReadArticleIndexOut['AdressInSQL'];
                        $this->ReadArticleIndexOut['Options'] = unserialize($this->ReadArticleIndexOut['Options']);
                        list($this->ReadArticleIndexOut['Votes'], $this->ReadArticleIndexOut['AllVotes']) = explode("|", $this->ReadArticleIndexOut['Votes']);
                        if($this->ReadArticleIndexOut['Accepted'] == "no")
                                $this->ReadArticleIndexOut['AcceptedMsg'] = $this->GetOnlyContextArticle('/System/NotAccepted/');
                        if(!empty($this->ReadArticleIndexOut['Bookmarks']))
                                list($this->ReadArticleIndexOut['Observed'], $this->ReadArticleIndexOut['Bookmark']) = explode('|',$this->ReadArticleIndexOut['Bookmarks']);

                        unset($Select);
                        unset($ReadIndexArticleRow);

                        $this->DataBase->pquery('UPDATE {Text_Index} SET {Text_Index:Views} = {Text_Index:Views} +1 WHERE {Text_Index:ID} = '.$this->ReadArticleIndexOut['ID']); // Counter

                        if(ifsetor($this->ReadArticleIndexOut['Options']["DisableCache"], false) == true)
                        $this->Cache->disable(); //disable cache - options article


                        if( $this->Cache->exist("Article", ($this->ReadArticleIndexOut['LocationInSQL'].(empty($this->ArticleFooVersion) ? "" : ($this->ArticleFooVersion))))){
                                $this->ReadArticleOut = $this->Cache->get();
                        }else{
   
                                if(!empty($this->ArticleFooVersion) && is_numeric($this->ArticleFooVersion)){
                                        $ReadArticleSQL = $this->DataBase->prepare('SELECT SQL_CACHE {Articles:*} FROM {Articles} WHERE {Articles:AdressInSQL} = :AddressInSQL  AND {Articles:Version} <= :ArticleVersion ORDER BY {Articles:Version} DESC LIMIT 1');
                                        $ReadArticleSQL->execute(array(
                                                ':AddressInSQL' => ($this->ReadArticleIndexOut['LocationInSQL']),
                                                ':ArticleVersion' => ($this->ArticleFooVersion)
                                        ));
                                }else{
                                        $ReadArticleSQL = $this->DataBase->prepare('SELECT SQL_CACHE {Articles:*} FROM {Articles} WHERE {Articles:AdressInSQL} = :AddressInSQL AND  {Articles:Version}  = :ActualVersion LIMIT 1');
                                        $ReadArticleSQL->execute(array(
                                                ':AddressInSQL' => ($this->ReadArticleIndexOut['LocationInSQL']),
                                                ':ActualVersion' => ($this->ReadArticleIndexOut['ActualVersion']),
                                        ));
                                }
                                unset($Select);

                                if(!($ReadArticleSQL->rowCount())){
                                        $this->ReadArticleOut = null;
                                        $this->ReadArticleError  = 2; // art nie istnieje, ale pozostal tylko wpis w ArticleIndex, ktory zostal usuniety
                                        return false;
                                }
                                $this->ReadArticleOut = $ReadArticleSQL->fetch(PDO::FETCH_ASSOC);
                                $this->ReadArticleOut['LocationInSQL'] =  $this->ReadArticleOut['AdressInSQL'];
                                $this->Cache->put("Article", ($this->ReadArticleIndexOut['LocationInSQL'].(empty($this->ArticleFooVersion) ? "" : $this->ArticleFooVersion)), $this->ReadArticleOut);
                        }

                        if(!is_null($Theread)){
                                $this->Date[$Theread]['ReadArticleIndexOut'] = $this->ReadArticleIndexOut;
                                $this->Date[$Theread]['ReadArticleOut'] = $this->ReadArticleOut;
                                $this->ReadArticleIndexOut = $IAS;
                                $this->ReadArticleOut = $AAS;
                        }

                        $this->ReadArticleError  = 0; // ok
                        return true;
        }
	/************************************************************************************************/
	var $IssetArticleID;
	function isset_article($Location=null){
	if(is_numeric($this->IssetArticleID)){
				$IssetArticleSQL = $this->DataBase->prepare('SELECT SQL_CACHE {Text_Index:ID} FROM{Text_Index} WHERE {Text_Index:ID} = :IDArticle LIMIT 1');
				$IssetArticleSQL->execute(array(':IDArticle' => ($this->IssetArticleID))); //tu
				if(!($IssetArticleSQL->rowCount())){
					return false;
				}
				return true;
			}
			$IssetArticleSQL = $this->DataBase->prepare('SELECT SQL_CACHE {Text_Index:ID}  FROM {Text_Index} WHERE {Text_Index:URL} = :UrlIdexArticle LIMIT 1');
			$IssetArticleSQL->execute(array(':UrlIdexArticle' => ($this->AddSlashesStartAndEnd($Location)))); //tu
			if(!($IssetArticleSQL->rowCount())){
				return false;
			}
			return true;
	}

	/************************************************************************************************/
	function isset_user($User){
			$IssetUserSQL = $this->DataBase->prepare('SELECT SQL_CACHE * FROM {Users} WHERE {Users:User} = :IssetUser LIMIT 1');
			$IssetUserSQL->execute(array(':IssetUser' => ($User)));
			if(!($IssetUserSQL->rowCount())){
				return false;
			}
			return true;
	}
	/************************************************************************************************/
	function user_config($User, $Data = null, $extend = true){
			$IssetUserSQL = $this->DataBase->prepare('SELECT {Users:Config} AS `uconfig` FROM {Users} WHERE {Users:User} = :IssetUser LIMIT 1');
			$IssetUserSQL->execute(array(':IssetUser' => ($User)));
			$Result = $IssetUserSQL->fetch();
			$Result = unserialize($Result['uconfig']);
			
					if(!is_null($Data) && is_array($Data)){
						if($extend)
						$Result = $this->array_merge_recursive_distinct($Result, $Data);
							else 
							$Result = $Data;
							
						$IssetUserSQL = $this->DataBase->prepare('UPDATE {Users} SET {Users:Config} = :Data WHERE {Users:User} = :IssetUser LIMIT 1');
						$IssetUserSQL->execute(array(':IssetUser' => ($User), ":Data"=>serialize($Result)));
					}
			return ($Result);
	}
	/************************************************************************************************/
	function CheckAdmin($User= null, $Bit= 1){
			if(!is_numeric($Bit) or !($Bit)){
				return false;
			}
			$WildCard = str_repeat("_", ($Bit - 1));
			$WildCard .= "1%";
			$CheckAdminSql = $this->DataBase->prepare('SELECT * FROM {Users} WHERE {Users:User} = :UserExecute AND {Users:Admin} LIKE "'.$WildCard.'" LIMIT 1');
			$CheckAdminSql->execute(array(':UserExecute' => ($User)));
			if(($CheckAdminSql->rowCount())){
				return true;
			}else{
				return false;
			}
	}
	/************************************************************************************************/
	function ReadUser($User = null){
			if(!is_null($User)){
				$this->ReadUser['User'] = $User;
			}
			$ReadSQLUser = $this->DataBase->prepare('SELECT {Users:*} FROM {Users} WHERE  {Users:User} = :UserExecute LIMIT 1');
			$ReadSQLUser->execute(array(':UserExecute' => $this->ReadUser['User']));
			if(!($ReadSQLUser->rowCount())){
				return false;
			}
			$this->ReadUser = $ReadSQLUser->fetch();
			$this->ReadUser['Nick'] = $this->ReadUser['User'];
			$this->ReadUser['GG'] = $this->ReadUser['GaduGadu'];
			
			$this->EditUserInit();
				$this->Date['EditUser']->Date['Log'] = false;
				$this->Date['EditUser']->Date['OffSecure']=true;
				$this->Date['EditUser']->Init($this->ReadUser['User']);
				$this->Date['EditUser']->set("Views", $this->ReadUser['Views']+1);
			$this->Date['EditUser']->execute();
			unset($this->Date['EditUser']);
			
			return true;
	}
	/************************************************************************************************/
	function SaveComment($Comment=null, $Author = null, $LocationCommentID = null){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'CommentSave.XVWeb.class.php');
		$CommentSave =  new CommentSave($this);
		return $CommentSave->SaveComment($Comment, $Author, $LocationCommentID);
	}
	/************************************************************************************************/
	var $CommentRead;
	function CommentRead($ID=null){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ReadComment.XVWeb.class.php');
		$ReadComment =  new ReadComment($this);
		return $ReadComment->CommentRead($ID);
	}
	
	var $SaveModification = array(
	"IDComment"=>"",
	"Comment"=>"",
	"Error"=>""
	);
	/************************************************************************************************/
	function SaveModificationComment($ID = null, $Comment=null){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ModComment.XVWeb.class.php');
		$SaveModComment =  new SaveModComment($this);
		return $SaveModComment->SaveModificationComment($ID, $Comment);
	}
	/************************************************************************************************/
	public function ReadArticleToDOC($URL= null){
		if(!is_null($URLS['Site'])){
			if(!($this->ReadArticle($URL)))
			return false;
			
		}
		$this->IncludeParseHTML();
		if(empty($this->HTMLtoDoc)){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'html_to_doc.inc.php');
			$this->HTMLtoDoc = new HTML_TO_DOC();
		}
		if(is_null($this->ReadArticleOut) or is_null($this->ReadArticleIndexOut))
		return false; else
		$this->HTMLtoDoc->createDoc($this->ParseArticleContents(), $this->ReadArticleIndexOut['Topic'], true);
	}
	/************************************************************************************************/
	var $Loggin = null;
	public function Loggin($User= null, $Password= null, $MD5Pass=false , $ValidPass = true){
			if(!is_null($User)){
				$this->Loggin['User'] = $User;
			}
			if(!is_null($Password)){
				$this->Loggin['Password'] = $Password;
			}
			if(!$this->ReadUser($this->Loggin['User'])){
				$this->Loggin['Error'] = 1 ; //brak usera
				return false;
			}
			if(!empty($this->ReadUser['OpenID'])) {
				$this->Loggin['Error'] = 3 ; //open id check it is
				return false;
			}

			if($ValidPass){
				if($MD5Pass==true){
					if($this->Loggin['Password'] != md5(MD5Key.$this->ReadUser['Password'])){
						$this->Loggin['Error'] = 2; //zle haslo
						return false;
					}
				}else{
					if(md5(MD5Key.$this->Loggin['Password']) != $this->ReadUser['Password']){ //tu
						$this->Loggin['Error'] = 2; //zle haslo
						return false;
					}
				}
			}

			$this->EditUserInit();
			$this->Date['EditUser']->Date['Log'] = false;
			$this->Date['EditUser']->Date['OffSecure']=true;
			$this->Date['EditUser']->Init($this->ReadUser['User']);
			$this->Date['EditUser']->set("IP", $_SERVER['REMOTE_ADDR'].", ".gethostbyaddr($_SERVER['REMOTE_ADDR']).", ".$_SERVER['HTTP_USER_AGENT']);
			$this->Date['EditUser']->set("LastLogin",  date('Y-m-d H:i:s'));
			$this->Date['EditUser']->set("LoginCount", $this->ReadUser['LoginCount']+1);
			$this->Date['EditUser']->execute();
			
			$this->Session->Session('Logged_Logged', true);
			$this->Session->Session('Logged_ID', $this->ReadUser['ID']);
			$this->Session->Session('Logged_User', $this->ReadUser['Nick']);
			$this->Session->Session('Logged_Password', $this->ReadUser['Password']);
			$this->Session->Session('Logged_Theme', $this->ReadUser['Theme']);
			$this->Session->Session('Logged_Avant', $this->ReadUser['Avant']);
			$this->Session->Session('user_group', $this->ReadUser['Group']);
			$this->Session->Session('user_permissions', $this->get_group_permissions($this->ReadUser['Group']));
			$this->Log("LoggedUser", array("User"=>$this->ReadUser['Nick']));
			return true;
	}
	/************************************************************************************************/
	var $LogginWithOpenIDVar;
	public function LogginWithOpenID(&$OpenIDGet){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'LoginOpenID.XVWeb.class.php');
		$OpenIDLogin =  new OpenIDLogin($this);
		return $OpenIDLogin->LogginWithOpenID($OpenIDGet);
	}
	/************************************************************************************************/
	var $OpenID;
	public function LoadOpenIDClass(){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'class.openid.php');
			if(empty($this->OpenID))
			$this->OpenID   = new SimpleOpenID;
	}
	/************************************************************************************************/
	public function LoadGOpenID(){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'GOpenID.class.php');
			if(empty($this->Date['GOpenID']))
			$this->Date['GOpenID']   = new GOpenID;
	}
	/************************************************************************************************/
	public function LogOut(){
		$this->Session->Clear();
	}
	/************************************************************************************************/
	function ParseArticlecontents($text = null){
			$MD5Hash = md5(MD5Key.(is_null($text)?$this->ReadArticleOut['ID']:$text)); // zmien na url i id versji
			if($this->Cache->exist("ArticleParse",$MD5Hash))
			return (ifsetor($this->ReadArticleIndexOut['Options']['EnablePHP'], 0) ? $this->EvalHTML($this->Cache->get()): $this->Cache->get());
			$this->IncludeParseHTML();
			$Result = $this->Cache->put("ArticleParse",$MD5Hash, (is_null($text) ? $this->ParserMyBBcode->set("Options", $this->ReadArticleIndexOut['Options'])->set("Blocked", ($this->ReadArticleIndexOut['Blocked'] == "yes" ? 1 : 0))->SetText($this->ReadArticleOut['Contents'])->Parse()->ToHTML() : $this->ParserMyBBcode->set("Blocked", ($this->ReadArticleIndexOut['Blocked'] == "yes" ? 1 : 0))->SetText($text)->Parse()->ToHTML()));

			return (ifsetor($this->ReadArticleIndexOut['Options']['EnablePHP'], 0) ? $this->EvalHTML($Result) : $Result);
	}
	/************************************************************************************************/
	function CommentArticle($IDArticle = null, $Parse = true){
			$localID = $this->ReadArticleIndexOut['AdressInSQL'];
			if(!is_null($IDArticle)){
				$localID = $IDArticle; //tu
			}
			if(empty($localID))
			return array();
			
			if($this->Cache->exist("Comment",$localID)){
				return $this->Cache->get();
			}
			if($Parse){
				$this->IncludeParseHTML();
			}
			
			$SQLComment = $this->DataBase->prepare('SELECT 
			{Comments:*:prepend:CT.} ,
			UT.{Users:Avant} AS `Avant` ,
			(SELECT COALESCE( SUM({Votes:Vote}), 0) FROM {Votes} WHERE {Votes:Type} = :TypeVote AND {Votes:SID} =  CT.{Comments:ID} ) AS `Votes`
			FROM 
				{Comments} AS `CT`,
				{Users} AS `UT`
		WHERE   
			CT.{Comments:IDArticleInSQL} = :URLExecute AND UT.{Users:User} =   CT.{Comments:Author}  ORDER BY {Comments:ID} DESC');
			$SQLComment->execute(array(':URLExecute' => $localID, ":TypeVote"=>"comment"));
			$ArrayComment = $SQLComment->fetchAll();
			return $this->Cache->put("Comment",$localID, $ArrayComment);
	}

	/************************************************************************************************/
	function EditTagArticle($ArticleID, $Tags){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'EditTag.XVWeb.class.php');
		$EditArticle =  new EditArticle($this);
		return $EditArticle->EditTagArticle($ArticleID, $Tags);
	}
	/************************************************************************************************/
	public function ConfigSystem($id, $Mod = null){
			if(is_null($Mod)){
				$ConfigCache = $this->Cache("Config", $id);
				if(!is_null($ConfigCache))
				return $ConfigCache;
				$ConfigSQL = $this->DataBase->prepare('SELECT * FROM `'.($this->DataBasePrefix).($this->DataBaseSystem['DataBaseSystem']).'` WHERE  `'.($this->DataBaseSystem['Name']).'` = :NameExecute LIMIT 1');
				$ConfigSQL->execute(array(':NameExecute' => $id));
				while ($SQlRowConfig = $ConfigSQL->fetch()) {
					$return = $SQlRowConfig;
				}
				$TMPRetrun = (isset($return) ? $return[($this->DataBaseSystem['Value'])] : null);
				$this->Cache("Config",$id, $TMPRetrun, 900);
				return $TMPRetrun;
			}else{
				if(is_null($this->ConfigSystem($id))){
					$SystemInfoSQL = $this->DataBase->prepare('INSERT INTO `'.($this->DataBasePrefix).($this->DataBaseSystem['DataBaseSystem']).'`  (`'.($this->DataBaseSystem['Name']).'`, `'.($this->DataBaseSystem['Value']).'`) VALUES ( :IDExecute , :ModExecute )');
					$SystemInfoSQL->execute(
					array(':IDExecute' => $id ,
					':ModExecute' => $Mod
					)
					);
					if($SystemInfoSQL){
						return $Mod;
					}else{
						return false;
					}
				}else{
					$SystemInfoSQL = $this->DataBase->prepare('UPDATE `'.($this->DataBasePrefix).($this->DataBaseSystem['DataBaseSystem']).'` SET `'.($this->DataBaseSystem['Value']).'` = :ModExecute WHERE `'.($this->DataBaseSystem['Name']).'` = :IDExecute');
					$SystemInfoSQL = $SystemInfoSQL->execute(
					array(':IDExecute' => $id ,
					':ModExecute' => $Mod
					)
					);
					if($SystemInfoSQL){
						return $Mod;
					}else{
						return false;
					}
				}
			}
	}
	/************************************************************************************************/
	public function DeleteComment($ID){
			if(!is_numeric($ID)){
				return false;
			}
			$this->CommentRead($ID);
			if(($this->Admin['DeleteComment'] && $this->CommentRead['Author']==$this->Session->Session('Logged_User')) or $this->Admin['DeleteCommentOther']){
				$DeleteCommentSQL = $this->DataBase->prepare('DELETE FROM {Comments} WHERE {Comments:ID} = :IDComment LIMIT 1');
				$DeleteCommentSQL->execute(array(':IDComment' => ($ID)));
				$this->Cache->clear("Comment", $this->CommentRead['IDArticleInSQL']);
				$this->Log("DeleteComment", array("CommentID"=> $ID));
				return true;
			}else{
				return false;
			}
	}
	/************************************************************************************************/
	public function IDtoURL($id){
			if(is_numeric($id)){
				if($this->Cache->exist("IDtoURL",($id)))
				return $this->Cache->get();
				
				$IDtoURLSQL = $this->DataBase->prepare('SELECT {Text_Index:URL} AS `URL` FROM {Text_Index} WHERE {Text_Index:ID} = :IDinArticleIndexExecute LIMIT 1');
				$IDtoURLSQL->execute(array(':IDinArticleIndexExecute' => ($id)));
				$IDtoURLSQL = $IDtoURLSQL->fetch();
				return $this->Cache->put("IDtoURL",($id), $IDtoURLSQL['URL']);
			}
			return false;
	}
	/************************************************************************************************/
	public function URLtoID($UrlArticle){
			if(!empty($UrlArticle)){
				$UrlArticle = $this->AddSlashesStartAndEnd($UrlArticle);
				if($this->Cache->exist("URLtoID",($UrlArticle))){
					return $this->Cache->get();
				}
				$URLtoIDSQL = $this->DataBase->prepare('SELECT {Text_Index:ID} AS `ID` FROM {Text_Index} WHERE {Text_Index:URL} = :URLinArticleIndexExecute LIMIT 1');
				$URLtoIDSQL->execute(array(':URLinArticleIndexExecute' => ($UrlArticle)));
				$URLtoIDSQL = $URLtoIDSQL->fetch();
				return $this->Cache->put("URLtoID",($UrlArticle), $URLtoIDSQL['ID']);
			}
			return false;
	}
	/************************************************************************************************/
	public function DeleteArticle($ID){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'DeleteArticle.XVWeb.class.php');
		$DeleteArticle =  new DeleteArticleClass($this);
		return $DeleteArticle->DeleteArticle($ID);
	}
	/************************************************************************************************/
	var $Search;
	var $SearchResultCount;
	var $SearchInVersion=false;
	public function Search($String, $ActualPage = 0, $EveryPage =30){
		if(empty($this->Date['Search'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'SearchClass.XVWeb.class.php');
			$this->Date['Search'] =  new SearchClass($this);
		}
		return $this->Date['Search']->Search($String, $ActualPage, $EveryPage);
	}
	/************************************************************************************************/
	public function Log($type, $data,  $who=null, $ip =null){
		if(is_null($who)){
		if (is_object($this->Session)) 
			$who = $this->Session->Session('Logged_User');
		}else{
			$who = "Error";
		}
		if(empty($who))
		$who = null;
		if(is_null($ip))
		$ip = $this->IP;
		try {
		
			if(isset($this->DataBase) && !empty($this->DataBase) && get_class($this->DataBase) == "xvDB"){
			$LogSQL = $this->DataBase->prepare('INSERT INTO {Logs}  ( {Logs:Date} , {Logs:Type} , {Logs:User} , {Logs:Text} , {Logs:IP} ) VALUES ( NOW() , :TypeExecute , :UserExecute , :TextExecute , :IPExecute ) ;');
			$LogSQL->PDOException();
			$LogSQL->execute(
			array(
			':TypeExecute' => $type,
			':UserExecute' => $who,
			':TextExecute' => serialize($data),
			':IPExecute'   => $ip
			)
			);
			}
		} catch (Exception $e) {
			$this->ErrorClass($e);
			$this->XVwebError[] = $e->getMessage();
			return false;
		}
		return true;
	}
	/************************************************************************************************/
	public function ErrorClass($Exception){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PDOError.XVWeb.class.php');
		$PDOError = new PDOError($Exception);
		$this->Log("Exception", $Exception);
		ob_start();
		($PDOError->show($this));
	}
	/************************************************************************************************/
	function GetOnlyContextArticle($URL){
		$URL = $this->AddSlashesStartAndEnd($URL);
		$GetOnlyContex = $this->DataBase->prepare('SELECT {Articles:Contents} AS `Contents`  FROM  {Text_Index} ArticleIndex RIGHT JOIN {Articles} Article ON ArticleIndex.{Text_Index:AdressInSQL}=Article.{Articles:AdressInSQL} WHERE ArticleIndex.{Text_Index:URL} = :URLExecute ORDER BY Article.{Articles:Version} DESC LIMIT 1;');
		$GetOnlyContex->execute(
		array(
		':URLExecute' => $URL 
		)
		);
		$ContextFinall = $GetOnlyContex->fetch();
		if(empty($ContextFinall))
		$ContextFinall = ""; else
		$ContextFinall = $ContextFinall['Contents'];
		
		return $ContextFinall;
	}
	/************************************************************************************************/
	function GetHisotryAricle($ID){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'HistoryArticle.XVWeb.class.php');
		$HistoryArticle =  new HistoryArticle($this);
		return $HistoryArticle->GetHisotryAricle($ID);
	}
	/************************************************************************************************/
	public function UserList($Date = array()){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'UserList.XVWeb.class.php');
		$UserList =  new UserListClass($this);
		return $UserList->UserList($Date);
	}
	/************************************************************************************************/
	public function OnlineList(){
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'OnlineList.XVWeb.class.php');
		return  new OnlineListClass($this);
	}
	/************************************************************************************************/
	public function PluginInt($Date = array(), $PHPLocation, $ClassName){
		include_once($PHPLocation);
		return  new $ClassName($this);
	}
	/************************************************************************************************/
	public function &Users(){
		if(empty($this->Date['UserClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'User.XVWeb.class.php');
			$this->Date['UserClass'] = new UsersClass($this);
		}
		return $this->Date['UserClass'];
	}
	/************************************************************************************************/
	public function &MailClass(){
		if(empty($this->Date['MailClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'mail.XVWeb.class.php');
			$this->Date['MailClass'] = new MailClass();
		}
		return $this->Date['MailClass'];
	}
	/************************************************************************************************/
	public function &DeleteUser(){
		if(empty($this->Date['DeleteUser'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'DeleteUser.XVWeb.class.php');
			$this->Date['DeleteUser'] = new DeletUserClass($this);
		}
		return$this->Date['DeleteUser'];
	}
	/************************************************************************************************/
	public function OnlineInit($UrlLocation){
		if(empty($this->Date['Online'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Online.XVWeb.class.php');
			$this->Date['Online'] = new OnlineClass($this, $UrlLocation);
		}
	}
	/************************************************************************************************/
	public function &EditUserInit(){
		if(empty($this->Date['EditUser'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'EditUser.XVWeb.class.php');
			$this->Date['EditUser'] = new EditUserClass($this);
		}
		return $this->Date['EditUser'];
	}
	/************************************************************************************************/
	public function &DelArtVer(){
		if(empty($this->Date['DeleteArtVer'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'DeleteVersionArticle.XVWeb.class.php');
			$this->Date['DeleteArtVer'] = new DeleteVersionArticleClass($this);
		}
		return $this->Date['DeleteArtVer'];
	}
	/************************************************************************************************/
	public function &FilesClass(){
		if(empty($this->Date['FilesClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Files.XVWeb.class.php');
			$this->Date['FilesClass'] = new FilesClass($this);
		}
		return $this->Date['FilesClass'];
	}
	/************************************************************************************************/
	public function &DiffClass(){
		if(empty($this->Date['DiffClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'DiffArticle.XVWeb.class.php');
			$this->Date['DiffClass'] = new DiffArticleClass($this);
		}
		return $this->Date['DiffClass'];
	}
	/************************************************************************************************/
	public function &Votes(){
		if(empty($this->Date['VotesClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Votes.XVWeb.class.php');
			$this->Date['Votes'] = new VotesClass($this);
		}
		return $this->Date['Votes'];
	}
	/************************************************************************************************/
	public function &XMLParser(){
		if(empty($this->Date['XMLParser'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'XmlParser.XVWeb.class.php');
			$this->Date['XMLParser'] = new XMLParser($this);
		}
		return $this->Date['XMLParser'];
	}
	/************************************************************************************************/
	public function &Config($var){
		if(empty($this->Date['Config'][$var])){
		$File = $this->Date['ConfigDir'].$var.'.xml';
			if (!file_exists($File)){
					$BackTrack = debug_backtrace();
					$BackTrack = ($BackTrack[0]);
					$ErrorInfo[] = array("Message"=>"ErrorMessage", "value"=> "Warning: XVweb::Config(".$var.") [function.Config]: failed to open stream: No such file or directory in ".realpath($File)." on line ".$BackTrack['line']. " in file ".$BackTrack['file']);
					$ErrorInfo[] = array("Message"=>"ErrorCode", "value"=> "404");
					$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
					$ErrorInfo[] = array("Message"=>"ErrorLine", "value"=> $BackTrack['line']);
					$ErrorInfo[] = array("Message"=>"ErrorTime", "value"=> date("y.m.Y H:i:s:u"));
					$ErrorInfo[] = array("Message"=>"ClientIP", "value"=> $_SERVER['REMOTE_ADDR']);
					$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
					$this->ErrorClass($ErrorInfo);
				return false;
				}
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'phpQuery'.DIRECTORY_SEPARATOR.'phpQuery.php');
			$this->Date['Config'][$var] = phpQuery::newDocumentFile($File);
		}
		return $this->Date['Config'][$var];
	}
	/************************************************************************************************/
	public function &XML($File){
		if(empty($this->Date['XML'][$File])){
			$this->Date['XML'][$File] = new DOMDocument('1.0', 'UTF-8');
			//$this->Date['XML'][$File]->encoding= "utf-8";
			$this->Date['XML'][$File]->load($File);
		}
		return $this->Date['XML'][$File];
	}
	/************************************************************************************************/
	public function &Plugins(){
		if(empty($this->Date['PluginsClass'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Plugins.XVWeb.class.php');
			$this->Date['PluginsClass'] = new Plugins($this);
		}
		return $this->Date['PluginsClass'];
	}
	/************************************************************************************************/
	public function &LostPassword(){
		if(empty($this->Date['LostPassword'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'LostPassword.XVWeb.class.php');
			$this->Date['LostPassword'] = new LostPassword($this);
		}
		return $this->Date['LostPassword'];
	}
	/************************************************************************************************/
	public function &InitClass($ClassName){
		if(empty($this->Date['Classes'][$ClassName])){
			$this->Date['Classes'][$ClassName] = new $ClassName($this);
		}
		return $this->Date['Classes'][$ClassName];
	}
	/************************************************************************************************/
	public function &EditArticle(){
		if(empty($this->Date['EditArticle'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Article.XVWeb.class.php');
			$this->Date['EditArticle'] =  new XVArticle($this);
		}
		return $this->Date['EditArticle'];
	}
	/************************************************************************************************/
	public function &Messages(){
		if(empty($this->Date['Messages'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Messages.XVWeb.class.php');
			$this->Date['Messages'] =  new Messages($this);
		}
		return $this->Date['Messages'];
	}
	/************************************************************************************************/
	public function SendMail($mail, $url, $vars){
		if(!($this->ReadArticle($url))){
			$BackTrack = debug_backtrace();
			$BackTrack = ($BackTrack[0]);
					$ErrorInfo[] = array("Message"=>"ErrorMessage", "value"=> "The system article doesn't exist : ".$url);
					$ErrorInfo[] = array("Message"=>"ErrorCode", "value"=> "5");
					$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
					$ErrorInfo[] = array("Message"=>"ErrorLine", "value"=> $BackTrack['line']);
					$ErrorInfo[] = array("Message"=>"ErrorTime", "value"=> date("y.m.Y H:i:s:u"));
					$ErrorInfo[] = array("Message"=>"ClientIP", "value"=> $_SERVER['REMOTE_ADDR']);
					$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $BackTrack['file']);
			$this->ErrorClass($ErrorInfo);
				return false;
		}
		
			
					
		foreach($this->Date['URLS'] as $key=>$val)
			$vars["{{urls.".$key."}}"] = $val;
			
		foreach($vars as $key=>$val){
			$vars[str_replace(array("{", "}"), array("%7B", "%7D"), $key)] = $val;
		}
		//var_dump($vars);
		$MailContent = $this->ParseArticleContents();
		$MailContent = $this->stritr($MailContent, $vars);
		$MailTopic = $this->stritr($this->ReadArticleOut['Topic'], $vars);
		return $this->MailClass()->mail($mail, $MailTopic, $MailContent);
		
	}
	/************************************************************************************************/
	public function &module($class, $file = null){
	if(is_null($file))
		$file = $class;
		if(empty($this->Date['Classes'][$class])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.$file.'.XVWeb.class.php');
			$this->Date['Classes'][$class] = new $class($this);
		}
		return $this->Date['Classes'][$class];
	}
	/************************************************************************************************/
	public function message($ErrorPage){
			ob_clean();
			extract($GLOBALS);
			$ErrorPage['URLS'] = $this->Date['URLS'];
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'errorpage'.DIRECTORY_SEPARATOR.'index.php');
			exit;
	}
	/************************************************************************************************/
	public function get_group_permissions($group){
			$permissions = array();
			$permissions_sql = $this->DataBase->prepare('SELECT {Groups:Permission} AS `Permission`  FROM  {Groups} WHERE {Groups:Name} = :name ;');
			$permissions_sql->execute(array(
				":name" => $group
			));
			$permissions_sql = $permissions_sql->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($permissions_sql as $permission)
				$permissions[] = $permission['Permission'];
				
		return $permissions;
	}
	/************************************************************************************************/
	public function permissions(){
		 $perms = &$this->Session->Session('user_permissions');
		 if(!is_array($perms))
			return false;
			
		 foreach(func_get_args() as $a){
			if(!in_array($a, $perms))
				return false;
		 }
	return true;
	}
	/************************************************************************************************/
	
	
	
	function __destruct() {
	}
	/************************************************************************************************/
	
}
?>