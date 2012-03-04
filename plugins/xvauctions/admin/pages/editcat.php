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



class XV_Admin_xvauctions_editcat { // delete categories
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid'] ){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		if($_POST['editcat']['category'] == "/"){
			exit("<div class='failed'>Error: You can't edit root directory - '/'</div>");
		}
		
		try {
			
			$SelectCategory = $XVweb->DataBase->prepare('SELECT
				{AuctionCategories:*} 
				
		FROM 
			{AuctionCategories}
		WHERE
			{AuctionCategories:Category} = :Category 
		ORDER BY  {AuctionCategories:Name} ASC
		LIMIT 1;
		');
			
			$SelectCategory->execute(array(
			":Category" => $_POST['editcat']['category'],
			));
			$CatInfo = $SelectCategory->fetch(PDO::FETCH_ASSOC);
			$CatInfo['CatURL'] = $XVweb->ReadTopicArticleFromUrl($CatInfo['Category']);

			$NewCatURL = string_to_url($_POST['editcat']['caturl']);
			
			
			$UpdateCat = $XVweb->DataBase->prepare('UPDATE {AuctionCategories} SET {AuctionCategories:Name} = :name, {AuctionCategories:Title} = :title, {AuctionCategories:Use} = :use WHERE {AuctionCategories:Category} = :category  ');
			$UpdateCat->execute(array(
			":name" =>$_POST['editcat']['name'],
			":title" =>$_POST['editcat']['title'],
			":use" => (int) $_POST['editcat']['use'],
			":category" => $_POST['editcat']['category']
			
			));
			
			if( $CatInfo['CatURL'] != $NewCatURL && !empty($NewCatURL)){
				$NewCatURL = str_replace( '/'.$CatInfo['CatURL'].'/',  '/'.$NewCatURL.'/' ,$CatInfo['Category']);
				$ChangeCat = $XVweb->DataBase->prepare('UPDATE {AuctionCategories} SET {AuctionCategories:Parent} = REPLACE({AuctionCategories:Parent} ,:fromReplace, :toReplace), {AuctionCategories:Category} = REPLACE({AuctionCategories:Category} ,:fromReplace, :toReplace) WHERE {AuctionCategories:Category} LIKE :search OR {AuctionCategories:Parent} LIKE :search;');
				
				$ChangeCat->execute(array(
				":fromReplace" => $CatInfo['Category'],
				":search" => $CatInfo['Category'].'%',
				":toReplace" => $NewCatURL,
				));
			}
			
			
		}catch(Exception $e) {
			exit("<div class='failed'>Error: ".$e->getMessage()."</div>");
		}
		
		exit("<div class='success'>Updated category!</div>");
	}
}


?>