<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

$auction_id =  strtolower($XVwebEngine->GetFromURL($PathInfo, 2));

$categories = xvp()->get_categories($XVauctions, $auction_category, array());
class xva_index_page extends xv_config{
	public function init_fields(){
		return array(
			"categories" => array()
		);
	}
}
$xva_index_page_config = new xva_index_page();

$Smarty->assignByRef('xva_index_page_categories', $xva_index_page_config->categories);
$Smarty->assignByRef('auctions_categories', $categories);
$Smarty->display('xvauctions/auction_index_show.tpl');

?>