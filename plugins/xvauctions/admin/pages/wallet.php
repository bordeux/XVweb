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
class xv_admin_xvauctions_wallet {
	var $style = "width: 60%;";
	var $title = "";
	var $URL = "";
	var $content = "";
	var $id = "";
	public function __construct(&$XVweb){
	global $URLS, $PathInfo;
		$user_wallet = strtolower($XVweb->GetFromURL($PathInfo, 5));
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/payments.png';
		$this->URL = "XVauctions/Wallet/".$user_wallet.'/'.(empty($_SERVER['QUERY_STRING']) ? "" : "?".$XVweb->add_get_var(array(), true));
		$this->content = $user_wallet;
		$this->title = "XVauctions: Wallet for ". $user_wallet;
		$this->id ="xv-wallet-".$user_wallet."-main";
		return true;
	}

}

?>