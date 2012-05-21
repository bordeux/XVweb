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



class xv_admin_xvauctions_editcat { // delete categories
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid'] ){
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
			$CatInfo['CatURL'] = $XVweb->read_sufix_from_url($CatInfo['Category']);

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