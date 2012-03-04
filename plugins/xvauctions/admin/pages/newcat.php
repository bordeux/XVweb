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


class XV_Admin_xvauctions_newcat{ // get categories
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
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