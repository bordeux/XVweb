<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}

$panel_prefix = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
$panel_prefix = strtolower($panel_prefix);
$panel_prefix = str_replace(array("/", ".", "\\"), '', $panel_prefix);

if(strlen($panel_prefix) < 1){
	header("location: ".$URLS['AuctionPanel'].'/bought/');
	exit;
}

$Smarty->assignByRef('panel_mode', $panel_prefix);

if (file_exists(dirname(__FILE__).'/panel/'.$panel_prefix.'.php')) {
	include(dirname(__FILE__).'/panel/'.$panel_prefix.'.php');
}else{
	include(ROOT_DIR.'/pages/articles.php');
exit;
}


?>