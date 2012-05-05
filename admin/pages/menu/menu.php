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
	class xv_admin_menu_save{
		var $Date;
		public function __construct(&$XVweb){
		if(isset($_POST['XMLMenu'])){
			libxml_use_internal_errors(true);
			$doc = new DOMDocument();
			$doc->loadXML($_POST['XMLMenu']);
			$errors = libxml_get_errors();
			$error = $errors[ 0 ];
			if(empty($errors) or $error->level < 3){
				include_once($GLOBALS['RootDir'].'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'BeautyXML.class.php');
					$bc = new BeautyXML();
					file_put_contents($GLOBALS['RootDir']."config/menu.xml", '<?xml version="1.0" encoding="utf-8"?>'.chr(13).$bc->format($doc->saveXML()));
				$XVweb->Cache->clear("XMLParse");
				echo "<div class='success xv-menu-save-result'>Zapisano</div>";
			}else{
			$lines = explode("r", $xml);
			$line = $lines[($error->line)-1];

			$message = $error->message.' at line '.$error->line.':<br />'.htmlentities($line);
			echo "<div class='error xv-menu-save-result'>".$Language['Error'].": Syntax error ".$message." ".$message."</div>";

			}
			
			echo "<script type='text/javascript'>
					($('#menu-visual-window .content, #menu-text-window .content').css('max-height', 100).css('min-height', 100).css('height', 100));
					setTimeout(function(){
						$('#menu-visual-window .xv-window-close, #menu-text-window .xv-window-close').click();
					},2000)
				</script> ";
			exit;
		}

		}
	}
	
	class xv_admin_menu_visual{
		var $style = "height: 500px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
		var $URL = "Menu/Visual/";
		var $content = "";
		var $id = "menu-visual-window";
		var $Date;
		public function __construct(&$XVweb){
			$this->title =  "Menu - Visual editor";
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/menu.png';
			$this->content .= '<div id="VisualEditor">	
				<div id="DrawMenu">
				</div>
				<div id="MenuVisualForm" style="clear:both;" >
						<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Menu/Save/" method="post" id="SaveMenuXML" name="SaveMenuXML" class="xv-form" data-xv-result=".content" >
							<textarea name="XMLMenu" id="MenuXML" style="display:none;">'.htmlspecialchars( $XVweb->Config('menu') ).'</textarea>
							<input type="submit" value="'.$GLOBALS['Language']['Save'].'" />
						</form>
				</div>
			</div>
			<script type="text/javascript" src="'.$GLOBALS['URLS']['JSCatalog'].'js/menu.js" charset="UTF-8"> </script>

			';
		}
	}
	class xv_admin_menu_text{
		var $style = "height: 500px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
		var $URL = "Menu/Text/";
		var $content = "";
		var $id = "menu-text-window";
		var $Date;
		public function __construct(&$XVweb){
			$this->title =  "Menu - Text editor";
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/menu.png';
			$this->content .= '
				<div id="TextEditor">
					<div style="clear:both; padding-right:20px; background:rgb(254, 252, 245);">
						<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Menu/Save/" method="post" class="xv-form" data-xv-result=".content">
							<textarea id="XMLMenuCode" style="width:100%; height:400px;" name="XMLMenu" class="codexml">'.htmlspecialchars( $XVweb->Config('menu') ).'</textarea>
							<input type="submit" value="'.$GLOBALS['Language']['Save'].'" />
						</form>
					</div>
				</div>
			<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/lib/codemirror.css"> 
			<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/xml/xml.css"> 
			<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/javascript.css"> 
			<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/css/css.css"> 
			<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/lib/codemirror.js"></script> 
			<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/xml/xml.js"></script>  
			<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/javascript.css"></script>  
			<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/css.js"></script>  
			<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/htmlmixed.js"></script>  
			<script type="text/javascript">
			$(function() {
						$(".codexml").each(function(){
								  var editor = CodeMirror.fromTextArea(this, {
								  lineNumbers: true,
								  mode: "text/html"
								  
								  });

							});	
				
			});
			</script>
			';
		}
	}
	
	
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('xv_admin_menu_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_menu_'.$CommandSecond;
	}else
		$xv_admin_class_name = "xv_admin_menu_text";

?>