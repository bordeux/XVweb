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


class xv_admin_xvauctions_delcat{ // delete categories
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		
		try {
			$DeleteCategory = $XVweb->DataBase->prepare('DELETE FROM {AuctionCategories} WHERE {AuctionCategories:Category} = :catd OR {AuctionCategories:Category} LIKE  :catl;');
			$DeleteCategory->execute(array(
			":catd"=> $_POST['delcat']['category'],
			":catl"=> $_POST['delcat']['category']."%"
			));
			
			$DeleteCategory = $XVweb->DataBase->prepare('DELETE FROM {AuctionFields} WHERE {AuctionFields:Category} = :catd OR {AuctionFields:Category} LIKE  :catl;');
			$DeleteCategory->execute(array(
			":catd"=> $_POST['delcat']['category'],
			":catl"=> $_POST['delcat']['category']."%"
			));
			
			
		}catch(Exception $e) {
			exit("<div class='failed'>Error: ".$e->getMessage()."</div>");
		}
		
		exit("<div class='success'>Category deleted!</div>");
	}
}

?>