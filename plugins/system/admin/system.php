<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
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

//TODO ?dir=../ problem

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}


class XV_Admin_xvauctions{
	var $style = "width: 80%;";
	var $title = "System";
	var $URL = "System/";
	var $content = "";
	var $id = "xv-system-main";
	public function __construct(&$XVweb){
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/xvauctions/icons/main.png';
		$xva_admin_menu = array();
		foreach (glob(dirname(__FILE__).'/menu/*.xva_menu.php') as $filename) 
			include($filename);
		
		$this->content = "<div class='xva-menu'>";
		foreach($xva_admin_menu as $menu_item){
			$this->content .= "
				<a href='".$GLOBALS['URLS']['Script'].$menu_item['link']."' class='xv-get-window' style='float:left; height: 80px; width: 70px; display:block; text-align:center; margin:10px;'>
					<div><img src='".$menu_item['image']."' style='width:64px; height:64px;'></div>
					<div>".$menu_item['caption']."</div>
					<div style='clear:both;'></div>
				</a>
			";
		
		}
		$this->content .= "
		<div style='clear:both;'></div>
		</div>";
	}
}





$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (file_exists(dirname(__FILE__).'/pages/'.$CommandSecond.'.php')) {
	include_once(dirname(__FILE__).'/pages/'.$CommandSecond.'.php');
	if (class_exists('XV_Admin_system_'.$CommandSecond)) {
		$XVClassName = 'XV_Admin_system_'.$CommandSecond;
	}else{
	$XVClassName = "XV_Admin_system";
	}
}else{
$XVClassName = "XV_Admin_system";
}

?>