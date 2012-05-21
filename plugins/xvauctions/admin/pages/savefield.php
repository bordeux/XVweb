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

class xv_admin_xvauctions_savefield{ 
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		
		$FieldsUpdate = $XVweb->DataBase->prepare('
			UPDATE
				{AuctionFields}
			SET
				{AuctionFields:FieldOptions} = :options
			WHERE
				{AuctionFields:ID} = :ID
			LIMIT 1;
		');
		
		$FieldsUpdate->execute(array(
		":options" =>serialize($_POST['field']),
		":ID" =>$_POST['field-id']
		));
		
		exit("<div class='success'>Field updated!</div>");
	}
}


?>