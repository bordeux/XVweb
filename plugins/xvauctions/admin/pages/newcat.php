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


class xv_admin_xvauctions_newcat{ // get categories
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		
		$Depth = 1;
		$Parent = "/";
		if($_POST['addcat']['parent'] != "/"){
			$SelectCategory = $XVweb->DataBase->prepare('SELECT
					{AuctionCategories:*} 	
			FROM 
				{AuctionCategories}
			WHERE
				{AuctionCategories:Category} = :Category 
			ORDER BY  {AuctionCategories:Name} ASC
			LIMIT 1
			');
			$SelectCategory->execute(array(
			":Category" => $_POST['addcat']['parent'],
			));
			$SelectCategory = $SelectCategory->fetchObject();
			if(!isset($SelectCategory->ID)){
				exit("<div class='failed'>Parent category doesn't exist!</div>");
			}
			$Depth = $SelectCategory->Depth+1;
			$Parent = $SelectCategory->Category;
		}

		$CatURL  = string_to_url($_POST['addcat']['name']);
		if(empty($CatURL)){
			exit("<div class='failed'>Category name can't be empty!</div>");
		}
		try {
			$AddCategory = $XVweb->DataBase->prepare('INSERT INTO {AuctionCategories} ({AuctionCategories:ID}, {AuctionCategories:Name}, {AuctionCategories:Title}, {AuctionCategories:Category}, {AuctionCategories:Parent}, {AuctionCategories:Options}, {AuctionCategories:Use}, {AuctionCategories:Depth}) VALUES (NULL, :name, :title, :category, :parent, :options, :use, :depth); ');
			$AddCategory->execute(array(
			":name"=> $_POST['addcat']['name'],
			":title"=> $_POST['addcat']['name'],
			":category" => $Parent.string_to_url($CatURL).'/',
			":parent" => $Parent,
			":depth" => $Depth,
			":use" => 0 ,
			":options" => "",
			));
		}catch(Exception $e) {
			exit("<div class='failed'>Error: ".$e->getMessage()."</div>");
		}
		exit("<div class='success'>Category added!</div>");
	}
}




?>