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

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}


class XV_Admin_xvauctions_editcatoptions{
	var $style = "min-height: 400px; width: 90%;";
	var $title = "Auctions - Edit options";
	var $URL = "";
	var $id = "";
	var $content = "";
	public function __construct(&$XVweb){
		$CatUNIQ = substr(md5($_GET['cat']), 28);
		$this->id = "xv-xvauctions-editoptions-".$CatUNIQ;
		$this->URL = "XVauctions/EditOptions/?cat=".urlencode($_GET['cat']);
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/xvauctions/icons/main.png';
		include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
		$XVauctions = &$XVweb->InitClass("xvauctions");

		$this->content = "
<div  style='overflow-y:scroll; max-height: 600px;'>
<div class='auction-editoptions-{$CatUNIQ}'> </div>
	<div style='text-align:center; font-size: 16px; height: 20px;'> Now edit: <b>{$_GET['cat']}</b></div>
		<form method='post'	action='{$GLOBALS['URLS']['Script']}Administration/get/XVauctions/SaveOptions/' class='xv-form' data-xv-result='.auction-editoptions-{$CatUNIQ}'>
		<input type='hidden' value='{$XVweb->Session->GetSID()}' name='xv-sid' />";
		if($_GET['cat'] == "/"){
			include(ROOT_DIR.'plugins/xvauctions/config/default.php');
			$category_url = '/';
		}else{
			$all_cats = $XVauctions->get_category_tree($_GET['cat']);
			$actual_cat = end($all_cats);
			$xva_config = $actual_cat['Options'];
			$category_url = $actual_cat['Category'];
		}
		
		$this->content .= " <input type='hidden' value='".htmlspecialchars($category_url)."' name='category' />";
		foreach($xva_config as $key=>$val){
			$this->content .= "	<div style='float:left; width: 150px;'><label style='width: 300px;' for='auction-{$key}-{$CatUNIQ}'> {$key} <a href='http://xvauctions.bordeux.net/wiki/Category_options_fields#{$key}' target='_blank'>[?]</a>:</label> </div> <div style='float:left; margin-right: 30px;'><textarea id='auction-{$key}-{$CatUNIQ}' name='options[{$key}]' style='height:14px;'>".htmlspecialchars($val)."</textarea></div>";
		}
		
		$this->content .=	"<div style='clear:both;'>
	<input type='submit' value='".xv_lang("Save")."' />
		</form>
	<div style='clear:both;'>
</div>";
	}
}
?>