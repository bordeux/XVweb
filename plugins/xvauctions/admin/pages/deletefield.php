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


class xv_admin_xvauctions_deletefield{ 
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		
		$FieldsDelete = $XVweb->DataBase->prepare('
			DELETE FROM
				{AuctionFields}
			WHERE
				{AuctionFields:ID} = :ID
			LIMIT 1;
		');
		
		$FieldsDelete->execute(array(
		":ID" =>$_POST['field-id']
		));
		$FieldsDelete = $XVweb->DataBase->prepare('
			DELETE FROM
				{AuctionValues}
			WHERE
				{AuctionValues:IDS} = :ID
		');
		
		$FieldsDelete->execute(array(
		":ID" =>$_POST['field-id']
		));
		
		exit("<div class='success'>Field deleted!</div>");
	}
}

?>