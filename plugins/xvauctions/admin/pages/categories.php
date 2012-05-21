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
class xv_admin_xvauctions_categories{
	var $style = " width: 100%;";
	var $title = "Auction Categories";
	var $URL = "XVauctions/Categories/";
	var $content = "";
	var $id = "xv-xvauctions-categories";

	public function __construct(&$XVweb){
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/categories.png';
		$this->content = "";
		
		$this->content .= '<link rel="stylesheet" href="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/styles/categories.css"> ';
		$this->content .= '<script type="text/javascript" src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/js/categories.js" charset="UTF-8"> </script>';
		
		
		$this->content .= '
			
			
			
<div class="xvauction-main">
			<div class="xv-auction-list" data-start="'.(isset($_GET['cat']) ? $_GET['cat']  : '/').'">
				<ul>
					<li><img src="'.$GLOBALS['URLS']['Theme'].'img/wait.gif" alt="Please wait..." /></li>
				</ul>
			</div>
			<div class="xv-auction-edit">
				<fieldset>
					<legend>Add category here</legend>
						<div class="auction-newcat-result"></div>
					<form method="post" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/NewCat/" class="xv-form" data-xv-result=".auction-newcat-result">
					<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
							<div><label for="xvauction-newcat-loc">Parent Category:</label> <input type="text" id="xvauction-newcat-loc" class="auction-cur-dir" readonly="true" name="addcat[parent]" value="/" style="width: 300px;" /></div>
							<div><label for="xvauction-newcat-name">Category Name:</label> <input id="xvauction-newcat-name" type="text" name="addcat[name]" /></div>
							<div><input type="submit" value="Add" /></div>
					</form>
				</fieldset>
				
				<fieldset>
					<legend>Delete Category</legend>
					<div class="auction-delcat-result"></div>
					<form method="post" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/DelCat/" class="xv-form" data-xv-result=".auction-delcat-result">
					<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
						<div>
							<label for="xvauction-delcat-loc">Do you want delete this category:</label> <input type="text" id="xvauction-delcat-loc" class="auction-cur-dir" readonly="true" name="delcat[category]" value="/" style="width: 300px;" />
						</div>
						<div><input type="submit" onclick=" return confirm(\'Do you really want delete this cat?\');" value="Yes" style="width:100%;"/></div>
					</form>
				</fieldset>	
	<div style="clear:both" ></div>
				<fieldset>
					<legend>Edit Category</legend>
					<div class="auction-editcat-result"></div>
					<form method="post" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/EditCat/" class="xv-form" data-xv-result=".auction-editcat-result">
					<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
						<div><label for="xvauction-editcat-loc">Category:</label> <input type="text" id="xvauction-editcat-loc" class="auction-current-Category" readonly="true" name="editcat[category]" value="/" style="width: 300px;" /></div>
							<div><label for="xvauction-editcat-caturl">Category URL:</label> <input id="xvauction-editcat-caturl" type="text" name="editcat[caturl]" class="auction-current-CatURL" /></div>
							<div><label for="xvauction-editcat-name">Category Name:</label> <input id="xvauction-editcat-name" type="text" name="editcat[name]" class="auction-current-Name" /></div>
							<div><label for="xvauction-editcat-title">Category Title:</label> <input id="xvauction-editcat-title" type="text" name="editcat[title]" class="auction-current-Title" /></div>
							<div title="Set to 1 if you want allow to add to this category auctions. if not, set 0"><label for="xvauction-editcat-use">Category Use:</label> <input id="xvauction-editcat-use" type="number" name="editcat[use]" class="auction-current-Use" /> <br />  </div>
							<div><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/EditCatOptions/?cat=/" class="xv-get-window auction-edit-options">Edit options for this category</a></div>
							<div><input type="submit" value="Save" /> </div>
						
					</form>
				</fieldset>
				<fieldset>
					<legend>Edit fields for this category</legend>
					
						<div><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/EditFields/?cat=/" class="xv-get-window auction-edit-fields"><input type="button" value="Edit fields" /></a></div>
						<p>Parents fields for this category</p>
						<ul style="margin-left: 30px;" class="auction-fields-ul"><img src="'.$GLOBALS['URLS']['Theme'].'img/wait.gif" alt="Please wait..." /></ul>
						
				</fieldset>
				
				<fieldset>
					<legend>Edit options for this category</legend>
						<div><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/EditOptions/?cat=/" class="xv-get-window auction-edit-options"><input type="button" value="Edit options" /></a></div>
				</fieldset>
				
			</div>
			<div style="clear:both"></div>
</div>
<div style="clear:both"></div>

';
	}
}




?>