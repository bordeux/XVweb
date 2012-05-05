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


class xv_admin_xvauctions_delcat{ // delete categories
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
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