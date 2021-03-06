<?php
class xv_api_ajax {

     var $counter = 1;
	 
	/**
	 * List of category: category_list, by LIKE %pattern%
	 * Usage : category_list("/aaa/bb/")
	 * Example : <a href='json/?category_list=["/aaa/bbb/"]'>json/?hello=["world"]</a>
	 * Example : <a href='xml/?category_list=["/aaa/bbb/"]'>xml/?hello=["world"]</a>
	 * Example : <a href='serialize/?category_list=["/aaa/bbb/"]'>serialize/?hello=["world"]</a>
	 * 
	 * @param string $url
	 * @return array
	 */	
	function category_list($url){
		global $XVwebEngine;
			$GetArticles = $XVwebEngine->DataBase->prepare('SELECT {Text_Index:URL} AS `URL` FROM {Text_Index} WHERE {Text_Index:URL} LIKE :URLSearch ORDER BY {Text_Index:URL} ASC LIMIT 30');
			$GetArticles->execute(array(':URLSearch' => '%'.($URL).'%'));
			return ($GetArticles->fetchAll(PDO::FETCH_ASSOC));
	}	

	
	/**
	 * Search function
	 * Usage : quick_search("test", 0)
	 * Example : <a href='json/?get_comment=[1]'>json/?hello=[10]</a>
	 * Example : <a href='xml/?get_comment=[1]'>xml/?hello=[10]</a>
	 * Example : <a href='serialize/?get_comment=[1]'>serialize/?hello=[10]</a>
	 * 
	 * @param string $search
	 * @param int $page
	 * @return array
	 */	

	public function quick_search($search, $page){
		$RecordsLimit = 30;
		$RecordsLimit = is_numeric($RecordsLimit) ? $RecordsLimit : 6;
		$SearchClass = &$XVwebEngine->module('SearchClass', 'SearchClass');
		$SearchClass->set("noContent", true);
		$SearchResult =  $SearchClass->Search($search, ifsetor($page, 0), $RecordsLimit);
		return $SearchResult;
	}	
	
    
    public function __wakeup(){
       
    }

	
}
