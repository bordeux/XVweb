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
	class XV_Admin_options_background{
		var $style = "height: 500px; width: 80%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
		var $URL = "Options/Background/";
		var $content = "";
		var $id = "background-window";
		var $Date;
		public function __construct(&$XVweb){
			$this->title = "Zmień tło";
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/backgrounds.png';
			foreach(glob(realpath(ADMIN_ROOT_DIR.'data/themes/'.$GLOBALS['xv_theme_name'].'/backgrounds').DIRECTORY_SEPARATOR."{*.gif,*.jpg,*.png,*.jpeg}", GLOB_BRACE) as $image){
				$this->content .= '<a class="xv-change-background" href="'.$GLOBALS['URLS']['Site'].'admin/data/themes/'.$GLOBALS['xv_theme_name'].'/backgrounds/'.basename($image).'" data-background="url('.$GLOBALS['URLS']['Site'].'admin/data/themes/'.$GLOBALS['xv_theme_name'].'/backgrounds/'.basename($image).')"><img src="'.$GLOBALS['URLS']['Script'].'Administration/get/Options/Background_view/'.basename($image).'?th" style="width:256px; height:256px;"></a> ';
			}
			$this->content .= '<script type="text/javascript">
				$(function(){
					$(".xv-change-background").click(function(){
					var tbghandle = this;
						 $("<img/>")[0].src = $(tbghandle).data("background");
						$("html").fadeTo(1000, 0.3, function () {
							$(this).css("background-image", $(tbghandle).data("background"));
							$(this).fadeTo(1000, 1);
						});
						ThemeClass.SetUserConfig({
							"administration":{
								"background": $(tbghandle).data("background")
							}
						});
					return false;
					});
					
				});
			</script>';
		}
	}
	
	class XV_Admin_options_setconfig{
		public function __construct(&$XVweb){
			if((isset( $_POST['xv-sid']) && $XVweb->Session->GetSID() == $_POST['xv-sid']) || (isset( $_GET['xv-sid']) && $XVweb->Session->GetSID() == $_GET['xv-sid'])){
				$this->result = $XVweb->user_config( $XVweb->Session->Session('Logged_User'), (isset($_POST) ? $_POST : null));
			}else{
				header("HTTP/1.0 403 Not allowed");
				header("Status: 403 Not allowed");
			 exit;
			}
		}
	}
	
	class XV_Admin_options_background_view{
		var $Date;
		public function __construct(&$XVweb){
			
			$ImageOrg = basename(strtolower($XVweb->GetFromURL($GLOBALS['PathInfo'], 5)));
			$ImageSRC = realpath(ADMIN_ROOT_DIR.'data/themes/'.$GLOBALS['xv_theme_name'].'/backgrounds/'.$ImageOrg);
			if (!file_exists($ImageSRC)) {
				header("Status: 404 Not Found");
				exit("404 error");
			}
			include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ResizeImage.class.php');
			header('Content-Type: image/jpeg');
						$image = new SimpleImage();
						$image->load($ImageSRC);
						$image->resizeToHeight(256);
						$image->output();	
					exit;
			
		}
	}
	
	class XV_Admin_options{
		var $style = "height: 500px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
		var $URL = "Options/";
		var $content = "";
		var $id = "options-window";
		var $Date;
		public function __construct(&$XVweb){
			$this->title = $GLOBALS['Language']['Options'];
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/logs.png';
			foreach(glob(realpath(ADMIN_ROOT_DIR.'data/themes/'.$GLOBALS['xv_theme_name'].'/backgrounds/')."{*.gif,*.jpg,*.png,*.jpeg}") as $image){
				$this->content .= $image;
			}
			$this->content .= '';
		}
	}
	
	
	
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('XV_Admin_options_'.$CommandSecond)) {
		$XVClassName = 'XV_Admin_options_'.$CommandSecond;
	}else
		$XVClassName = "XV_Admin_options";

?>