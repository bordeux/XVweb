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


class xv_admin_xvauctions_editmainfield{ 
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		
		$FieldsUpdate = $XVweb->DataBase->prepare('
			UPDATE
				{AuctionFields}
			SET
				{AuctionFields:AddPriority} = :AddPriority,
				{AuctionFields:Priority} = :Priority,
				{AuctionFields:Search} = :Search
				
			WHERE
				{AuctionFields:ID} = :id
			LIMIT 1;
		');

		$FieldsUpdate->execute(array(
		":id" =>$_POST['edit']["ID"],
		":AddPriority" =>$_POST['edit']["AddPriority"],
		":Priority" =>$_POST['edit']["Priority"],
		":Search" =>$_POST['edit']["Search"],
		));
		
		exit("<div class='success'>Field updated!</div>");
	}
}


?>