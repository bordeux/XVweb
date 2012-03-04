<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

$auction_id =  strtolower($XVwebEngine->GetFromURL($PathInfo, 2));

$categories = xvp()->get_categories($XVauctions, $auction_category, array());

$Smarty->assignByRef('auctions_categories', $categories);
$Smarty->display('xvauctions_theme/auction_index_show.tpl');

?>