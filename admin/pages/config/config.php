<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   config.php        *************************
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

if(isset($_POST['ConfigXML'])){
	libxml_use_internal_errors(true);
	$doc = new DOMDocument();
	$doc->loadXML($_POST['ConfigXML']);
	$errors = libxml_get_errors();
	$error = $errors[ 0 ];
	if(empty($errors) or $error->level < 3){
		include_once($RootDir.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'BeautyXML.class.php');
		$bc = new BeautyXML();
		file_put_contents($RootDir."config/config.xml", '<?xml version="1.0" encoding="utf-8"?>'.chr(13).$bc->format($doc->saveXML()));
		$XVwebEngine->Cache->clear("XMLParse");
		/*header("location: ?".http_build_query(array(
		"msg"=> $Language['Saved'],
		"success"=> true,
		)));*/
		exit;
	}
	$lines = explode("r", $xml);
	$line = $lines[($error->line)-1];

	$message = $error->message.' at line '.$error->line.':<br />'.htmlentities($line);
	/*header("location: ?".http_build_query(array(
	"msg"=> 'Syntax error',
	"list"=> array($message),
	"error"=> true,
	"title"=>  $Language['Error'],
	)));*/
	exit();
}

$Listing = array();
$DomParser = new DOMDocument;
function xv_langs(){
	global $Listing, $RootDir;
	$Listing['Lang'] = array();
	foreach (glob($RootDir.'languages'.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) as $filename){
		if(file_exists($filename.DIRECTORY_SEPARATOR.'general.'.basename($filename).'.php'))
		$Listing['Lang'][basename($filename)] = basename($filename);
	}
	return $Listing['Lang'];
}
function xv_themes(){
	global $Listing;
	$DomParser = new DOMDocument;
	$Themes = array();
	foreach (glob($RootDir.'themes'.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) as $filename){
		if(file_exists($filename.DIRECTORY_SEPARATOR.'theme.xml')){
			$DomParser->load($filename.DIRECTORY_SEPARATOR.'theme.xml');
			$Parms = $DomParser->getElementsByTagName('theme')->item(0)->getElementsByTagName( "*" );
			$k=0;
			$Theme = array();
			foreach ($Parms as $Parm){
				$Theme[$Parms->item($k)->nodeName] = $Parms->item($k)->nodeValue;
				++$k;
			}
			$Listing['Theme'][] = $Theme;
			$Themes[$Theme['name']] = $Theme['name'];
		}
	}
	return $Themes;
}
require($XVwebDir."libraries".DIRECTORY_SEPARATOR."formgenerator".DIRECTORY_SEPARATOR."formgenerator.php");
$form=new Form();        
$form->set("title", "Config Edit");
$form->set("name", "config_form");        
$form->set("linebreaks", false);       
$form->set("errorBox", "error");    
$form->set("class", " xv-form");            
$form->set("attributes", " data-xv-result='.xv-config-form' ");     
$form->set("errorClass", "error");       
$form->set("divs", true);    
$form->set("action", $GLOBALS['URLS']['Script'].'Administration/Get/Config/Save/');
$form->set("errorTitle", $Language['Error']);    

$form->set("errorPosition", "before");		

$form->set("submitMessage", "Zapisano");

$form->set("showAfterSuccess", true);
$form->JSprotection(uniqid());

function generateEditor($pq, $Actual = "config > *" , $Selector = "config"){
	global $Language, $form;
	foreach($pq->find($Actual) as $child){
		if(pq($child)->children() == ""){
			$InputOptions = array();
			$InputOptions['type'] = "text";
			$InputOptions['label'] = "------";
			$InputOptions['required'] = true;
			$InputOptions['value'] = pq($child)->html();
			$InputOptions['options'] = false;
			if(pq($child)->attr('xv-type') != ""){
				$InputOptions['type'] = pq($child)->attr('xv-type');
			}
			if(pq($child)->attr('xv-values') != ""){
				$InputOptions['type'] = "select";
				$Options = explode(",",pq($child)->attr('xv-values'));
				$Options = array_combine($Options, $Options);;
				$InputOptions['options'] = $Options;    
			}
			if(pq($child)->attr('xv-values-from-function') != "" && function_exists(pq($child)->attr('xv-values-from-function'))){
				$InputOptions['type'] = "select";
				$InputOptions['options'] = call_user_func(pq($child)->attr('xv-values-from-function'));
			}
			
			if(pq($child)->attr('xv-required') == "false"){
				$InputOptions['required'] = false;
			}
			if(pq($child)->attr('xv-lang') != ""){
				if(isset($Language[pq($child)->attr('xv-lang')])){
					$InputOptions['label'] = $Language[pq($child)->attr('xv-lang')];
				}else{
					$InputOptions['label'] = pq($child)->attr('xv-lang');
				}
			}
			
			$form->addField($InputOptions['type'], $Selector.'-'.$child->tagName, $InputOptions['label'] , $InputOptions['required'], $InputOptions['value'], $InputOptions['options']);
			
			if(pq($child)->attr('xv-validator') != ""){
				$form->validator($Selector.'-'.$child->tagName , pq($child)->attr('xv-validator'), pq($child)->attr('xv-validator-1-arg'), pq($child)->attr('xv-validator-2-arg'), pq($child)->attr('xv-validator-3-arg'), pq($child)->attr('xv-validator-4-arg'), pq($child)->attr('xv-validator-5-arg'), pq($child)->attr('xv-validator-6-arg'));
			}
			if(pq($child)->attr('xv-values') != ""){
				$form->validator($Selector.'-'.$child->tagName , "inList", pq($child)->attr('xv-values'), "BadValue");
			}
			
			
		}else{
			$form->addItem("<fieldset>");
			$form->addItem("<legend>");
			if(pq($child)->attr('xv-lang') != ""){
				if(isset($Language[pq($child)->attr('xv-lang')])){
					$form->addItem($Language[pq($child)->attr('xv-lang')]);
				}else{
					$form->addItem(pq($child)->attr('xv-lang'));
				}
			}else{
				$form->addItem("------");
			}
			
			$form->addItem("</legend>");
			
			generateEditor(pq($child), "> *", $Selector.'-'.$child->tagName);
			$form->addItem("</fieldset>");
		}
		
	}
}
generateEditor($XVwebEngine->Config("config"));
$form->addItem("<div style='display:none' id='ThemesListing'>".json_encode($Listing['Theme'])."</div>");
$form->addField("hidden", "config_submit", $Language['Save'], false);
$FormXHTML = $form->display($Language['Save'], "config_submit", false);

$result =($form->getData());
if ($result){
	foreach ($result as $name =>$item){
		$XVwebEngine->Config("config")->find(str_replace("-", " > ", $name))->text(trim($item));
	}
	
	include_once($RootDir.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'BeautyXML.class.php');
	$bc = new BeautyXML();
		file_put_contents($RootDir."config/config.xml", ($XVwebEngine->Config("config")));
	$XVwebEngine->Cache->clear("XMLParse");
	echo "<div class='success'>Saved</div>";
	exit;
}

if(!empty($_POST))
	exit($FormXHTML);

class XV_Admin_config_visual{
	var $style = "height: 500px; width: 90%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "Config/Visual/";
	var $content = "";
	var $id = "config-visual-window";
	var $Date;
	public function __construct(&$XVweb){
		global $form, $Language,  $Listing;
		$this->title =  "Config - Visual editor";
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/config.png';	
		$this->content = '<div class="xv-config-form"> '.$GLOBALS['FormXHTML'] .'</div>';
		
	}
}

$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('XV_Admin_config_'.$CommandSecond)) {
	$XVClassName = 'XV_Admin_config_'.$CommandSecond;
}else
$XVClassName = "XV_Admin_config_visual";


?>