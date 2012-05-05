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


class xv_admin_xvauctions_deletefield{ 
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
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