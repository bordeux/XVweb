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

	class xv_admin_lang{
		var $style = "height: 500px; width: 80%;";
		var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
		var $URL = "Lang/";
		var $content = "";
		var $id = "lang-window";
		var $Date;
		public function __construct(&$XVweb){
			$this->title =  "Lang Editor";
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/lang.png';
			

	include_once($GLOBALS['XVwebDir'].'libraries/formgenerator/formgenerator.php');
		$LangFiles = array();
		function all_files($dir){
			$files = Array();
			$file_tmp= glob($dir.'*',GLOB_MARK | GLOB_NOSORT);

			foreach($file_tmp as $item){
				if(substr($item,-1)!=DIRECTORY_SEPARATOR)
					$files[] = $item;
				else
					$files = array_merge($files,all_files($item));
			}

			return $files;
		}

		foreach (all_files($GLOBALS['RootDir']."languages/*") as $filename) {
			$LangFiles[realpath($filename)] = realpath($filename);
			}
		$Content = "";		
			
	$form=new Form();        
        //setup form
        //$form->set("title", "Kontakt");
        $form->set("name", "form_langfile");
        $form->set("linebreaks", false);            
        $form->set("class", " xv-form");            
        $form->set("attributes", " data-xv-result='.xv-edit-lang-form' ");            
        $form->set("sanitize", false);            
        $form->set("divs", true);                
        $form->set("action", $GLOBALS['URLS']['Script'].'Administration/Get/Lang/Load/');
        $form->set("method", "get");
        $form->set("submitMessage", "");
		$form->addField("select", "langfile","LangFile ", false, $_GET['langfile'], $LangFiles); 
		$Content .= $form->display("ładuj", "form1_submit", false) . '<div class="xv-edit-lang-form"></div>
		<style type="text/css" media="all">
		#form_lang {  
				-moz-column-count: 2;
				-webkit-column-count: 2;
				column-count: 2;
			}
		</style>
		';  
		
		
		
			$this->content =  $Content;
		}
	}
	
		class xv_admin_lang_load{
		var $Date;
		public function __construct(&$XVweb){
		
		$LangList = array();
		if(isset($_GET['langfile'])){
			$LangList = $this->ReadLang($_GET['langfile']);
		}
		include_once($GLOBALS['XVwebDir'].'libraries/formgenerator/formgenerator.php');
			$form=new Form();        
			$form->set("name", "form_lang");
			$form->set("linebreaks", false);    
			$form->set("class", " xv-form");            
			$form->set("attributes", " data-xv-result='.xv-edit-lang-form' ");      			
			$form->set("errorBox", "ErrorTip");       
			$form->set("errorClass", "ErrorTip");       
			$form->set("sanitize", false);       
			$form->set("divs", true);     
			$form->set("method", "post");			
			$form->set("errorPosition", "before");
			$form->set("action", $GLOBALS['URLS']['Script'].'Administration/Get/Lang/Load/?langfile='.$_GET['langfile']);
			$form->JSprotection(uniqid());
			$form->set("submitMessage", "");
			foreach($LangList as $key=>$val)
				$form->addField("text", "language[".$key."]",$key, false, $val);
				
			$form->addField("textarea", "newlang","Dodaj nowe KEY=VAL", false);
			$form->addField("hidden", "xv-sid",false, false, htmlspecialchars($XVweb->Session->get_sid()));
			$Content .= $form->display($GLOBALS['Language']['Save'], "lang_submit", false);  
			 if(isset($_POST['language']) && is_array($_POST['language'])){
			 
			 if($XVweb->Session->get_sid() != ifsetor($_POST['xv-sid'], "")){
				exit("<div class='failed'>Błąd: Zły SID</div>");
			 }
		
		
			$NewLang = parse_ini_string($_POST['newlang']);
			$LangToSave = array_merge($_POST['language'], $NewLang);
			
			$LangToSave = '<?php'.chr(13).' $Language = array_merge((isset($Language) ? $Language : array() ), '. var_export($LangToSave, true).'); '.chr(13).'?>';
			 
			 file_put_contents($_GET['langfile'], $LangToSave);
				exit("<div class='success'>Zapisano</div>");
			 }
		
		
			exit($Content);

		}
		public function ReadLang($file){
			if (file_exists($_GET['langfile'])) {
				include($_GET['langfile']);
				if(isset($Language)){
				ksort($Language);
				}
				return $Language;
			}
			return array();
		}
	}
	
	
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('xv_admin_lang_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_lang_'.$CommandSecond;
	}else
		$xv_admin_class_name = "xv_admin_lang";

?>