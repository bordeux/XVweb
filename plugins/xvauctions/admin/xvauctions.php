<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
$xva_wiki_page = "http://xvauctions.bordeux.net/wiki/";
xv_load_lang('xvauctions');
include_once(ROOT_DIR.'plugins/xvauctions/includes/functions.xvauctions.php');
function getClassesByPrefix($prefix){
	$result = array();

	$className = strtolower( $prefix );
	$PrefixLen = strlen($prefix);
	foreach ( get_declared_classes() as $c ) {
		if ( $className == substr(strtolower($c), 0, $PrefixLen) ) {
			$result[] = $c;   
		}
	}

	return $result;
}
function getCategoryParents($cats){
	$exploded = explode("/", $cats);
	$ParentsCategories = array();
	foreach($exploded as $cat){
		
		$ParentsCategories[] =  end($ParentsCategories).$cat.'/';
	}
	unset($ParentsCategories[count($ParentsCategories)-1]);
	return $ParentsCategories;
}

function string_to_url($string){
	$string = iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $string); 
	$string = str_replace(' ', '_', $string);
	$string = preg_replace('#[^a-zA-Z0-9_\/]+#', '', $string);
	return $string;
}


class xv_admin_xvauctions{
	var $style = "width: 80%;";
	var $title = "Auctions menager";
	var $URL = "XVauctions/";
	var $content = "";
	var $id = "xv-xvauctions-main";
	public function __construct(&$XVweb){
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/main.png';
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
	if (class_exists('xv_admin_xvauctions_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_xvauctions_'.$CommandSecond;
	}else{
	$xv_admin_class_name = "xv_admin_xvauctions";
	}
}else{
$xv_admin_class_name = "xv_admin_xvauctions";
}

?>