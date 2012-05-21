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


	class xv_admin_widgets {
		var $style = "height: 400px; width: 100%;";
		var $title = "Widgets";
		var $URL = "Widgets/";
		var $content = "";
		var $id = "widets";
		var $contentAddClass = "";
		public function __construct(&$XVweb){
		$this->title = xv_lang("Widgets");
		$Widgets = array();
		foreach (glob(ADMIN_ROOT_DIR.'data'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'info.widget.php') as $filename) {
			include_once($filename);
		}

	
	
	$this->content .= '<div class="xv-win-widgets-list">';
	foreach($Widgets as $Widget){
		$this->content .= '
		<a class="xv-win-widgets-add" href="#" data-widget-name="'.$Widget['name'].'">
			<div class="xv-wid-widgets-thumbnail"><img src="'.$Widget['thumbnail'].'" ></div>
			<div class="xv-wid-widgets-title">'.$Widget['title'].'</div>
		</a> ';
	}
	
	$this->content .= '
	<div style="clear:both;"></div>
	</div>
	<script type="text/javascript">
	$(function(){
		$(".xv-win-widgets-add").unbind().click(function(){
				WidgetsClass.add($(this).data("widget-name"));
			return false;
		});
	});
	</script>
	<style type="text/css" media="all">
	.xv-win-widgets-add {
		height:90px;
		width:100px;
		text-align:center;
		display:block;
		float:left;
		text-decoration:none;
		color: #000; 
		padding: 10px;
		border: 1px solid rgba(245, 184, 0, 0);
	}
	.xv-win-widgets-add:hover {
	background-color: rgba(245, 184, 0, 0.6);
	border: 1px solid rgb(245, 184, 0);
	}
	.xv-wid-widgets-thumbnail img {
		width:64px;
		height:64px;
	}
	</style>
	';
	
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/widgets.png';
		}
	}
	class xv_admin_widgets_position{
	var $error = false;
	var $result = false;
		public function __construct(&$XVweb){
		$Widgets['administration']['widgets'][$_GET['wid']] = array(
			"top" =>$_GET['top'],
			"left" => $_GET['left'],
			"name" => $_GET['widget'],
			"wid"=> $_GET['wid'],
		);
			if(isset( $_GET['xv-sid']) && $XVweb->Session->get_sid() == $_GET['xv-sid']){
				$this->result = $XVweb->user_config( $XVweb->Session->Session('Logged_User'), $Widgets);
			}else{
				header("HTTP/1.0 403 Not allowed");
				header("Status: 403 Not allowed");
			 exit;
			}
		}
	}
	
	class xv_admin_widgets_close{
	var $error = false;
	var $result = false;
		public function __construct(&$XVweb){
		$UserConfig = $XVweb->user_config($XVweb->Session->Session('Logged_User'));
			if(isset($UserConfig['administration']['widgets'][$_GET['wid']])){
				unset($UserConfig['administration']['widgets'][$_GET['wid']]);
				$this->result = $XVweb->user_config( $XVweb->Session->Session('Logged_User'), $UserConfig, false);
			}
			
			$this->result = true;
		}
	}

	class xv_admin_widgets_get {
	var $error = false;
	var $result = "{}";
		public function __construct(&$XVweb){
		$WidgetLocation = ADMIN_ROOT_DIR.'data'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.basename($_GET['name']).DIRECTORY_SEPARATOR.basename($_GET['name']).'.widget.admin.php';
			header("Content-type: text/html");
			if (!file_exists($WidgetLocation)) 
				exit("<div class='failed'> Widget not found ".basename($_GET['name'])." </div>");
				
			include($WidgetLocation);
		exit;
		}
	}
	
	
		$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('xv_admin_widgets_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_widgets_'.$CommandSecond;
	}else
		$xv_admin_class_name = "xv_admin_widgets";
		
?>