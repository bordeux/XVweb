<?php
/****************************************************************************
****************   Bordeux.NET Project              *************************
****************   File name :  mainpage.module.php *************************
****************   Start     :  22.05.2007 r.       *************************
****************   License   :  GNU                 *************************
****************   Version   :  1.0                 *************************
****************   Authors   :  XVweb team          *************************
*************************XVweb Team******************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
global $Smarty,$RootDir;

$Smarty->assign('Title', $Language['MainPage'] );
$Smarty->assign('SiteTopic', $Language['MainPage'] );
$Smarty->assign('RightBox', $Language['MainPage'] );
$Smarty->assign('MainPage', true);

	if(isset($_GET["SaveSort"]) && (xv_perm('AdminPanel'))){
	$oXMLout = new XMLWriter();
	$oXMLout->openMemory();
	$oXMLout->startElement("config");
		$oXMLout->startElement("widgets");
					foreach($_POST as $key=>$Widget){
						$oXMLout->startElement("widget");
						$oXMLout->writeAttribute("name", $key);
						$oXMLout->writeAttribute("file", $Widget['file']);
						$oXMLout->writeElement("width", $Widget['width']);
						$oXMLout->writeElement("name", $Widget['name']);
						$oXMLout->endElement();
					}
		$oXMLout->endElement();
	$oXMLout->endElement();

		include_once($RootDir.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'BeautyXML.class.php');
			$bc = new BeautyXML();
			file_put_contents($RootDir.'config'.DIRECTORY_SEPARATOR.'mainpage.xml', $bc->format($oXMLout->outputMemory()));
	//setcookie("WidgetSort", (serialize($_POST["SortBy"])), strtotime("+14 days"), "/");
		exit;
	}
class WidgetClass {

public function Load($file, $name, $Options){
global $Widgets, $XVwebEngine;

	$doc = new DOMDocument();
	$doc->load($file);
	//echo $doc->SaveXML();
	//var_dump($Options->getElementsByTagName("*"));
	foreach($Options->getElementsByTagName("*") as $option)
		$doc->getElementsByTagName("config")->item(0)->appendChild($doc->importNode($option, true));
		
	//var_dump($option);
	//var_dump($doc->createElement("para"));
		//$doc->getElementsByTagName("config")->item(0)->appendChild();
	//var_dump($doc->SaveXML());
//exit;
	$Widgets[$name] = $XVwebEngine->Plugins()->Widget($doc);
	$Widgets[$name]['name']['file'] = pathinfo($file, PATHINFO_BASENAME);
	if($Widgets[$name]['name']['lang'] == "php"){
		$Func = create_function("",$Widgets[$name]['name']['value']);
		$Widgets[$name]['name']['value'] = $Func();
	}
	if($Widgets[$name]['content']['lang'] == "php"){
		$Func  = create_function("",$Widgets[$name]['content']['value']);
		$Widgets[$name]['content']['value'] = $Func();
	}
	//foreach($Options->getElementsByTagName("*") as $option)
	//var_dump($option->nodeValue);
		//print_r($Options->getElementsByTagName("*"));

}

public function SortArrayByOrder( $Order){
global $Widgets;
		$NewArray = array();
		foreach ($Order as $valueOrder) {
		$valueOrder  = $valueOrder[0];
			if(isset($Widgets[($valueOrder[0])])){
				$NewArray[] = array($valueOrder => $Widgets[$valueOrder]);
				unset($Widgets[$valueOrder]);
			}
		}
		foreach ($Widgets as $key=> $valueOrder) 
			$NewArray[] = array($key => $valueOrder);
		
			unset($Widgets);
		return $NewArray;
	}

}

			$MainPageConfig = new DOMDocument;
			$MainPageConfig->load($RootDir.'config'.DIRECTORY_SEPARATOR.'mainpage.xml');
			$WidgetList = $MainPageConfig->getElementsByTagName('widgets')->item(0)->getElementsByTagName('widget');
			foreach ($WidgetList as $WidgetLoad){
			$SortBy[] = $WidgetLoad->getAttribute("name");
				WidgetClass::Load($RootDir.'plugins'.DIRECTORY_SEPARATOR.'widget'.DIRECTORY_SEPARATOR.($WidgetLoad->getAttribute("file")), $WidgetLoad->getAttribute("name"), $WidgetLoad);
				}
	//	if(isset($_COOKIE['WidgetSort']))
	//	$SortBy = unserialize($_COOKIE['WidgetSort']);
		

xv_append_css($GLOBALS['URLS']['Theme'].'css/index.css', 5);
$GLOBALS['JSBinder'][3] = 'jquery-ui-1.8.7.custom.min';
$GLOBALS['JSBinder'][4] = 'IndexPage';

$Smarty->assign('Widgets', WidgetClass::SortArrayByOrder($SortBy));
try {
	$Smarty->display('contents/index_contents.tpl');
} catch (Exception $e) { 
	$GLOBALS['XVwebEngine']->ErrorClass($e);
} 
?>