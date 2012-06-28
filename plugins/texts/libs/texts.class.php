<?php
class xv_texts {

	var $XVweb;
	
	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function get_categories($parent){
			$category_list = $this->XVweb->DataBase->prepare("SELECT 
				{TextsIndex:ID} AS ID,
				{TextsIndex:URL} AS URL,
				{TextsIndex:Parent} AS Parent,
				{TextsIndex:Title} AS Title
			FROM
				{TextsIndex}
			WHERE
				{TextsIndex:Parent} = :parent
			ORDER BY
				{TextsIndex:Title} DESC
			");
			$category_list->execute(array(
				":parent" => $parent
			));
		return $category_list->fetchAll(PDO::FETCH_ASSOC);
	}
	public function get_texts_index($url){
		$text_index_val = $this->XVweb->DataBase->prepare("SELECT 
				{TextsIndex:*}
			FROM
				{TextsIndex}
			WHERE
				{TextsIndex:URL} = :url
			LIMIT 1;
			");
		$text_index_val->execute(array(
			":url" => $url
		));
		return $text_index_val->fetch(PDO::FETCH_ASSOC);
	}
	public function convert_title_to_url($title){
			$title = trim($title);
			$title = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
			$title = str_replace(" ", "-", $title);
			$title = str_replace("'", "", $title);
			$title = str_replace("?", "", $title);
			$title = str_replace("/", "", $title);
			$title = str_replace("\\", "", $title);
		return $title;
	}
	
	public function add_new_page($user, $url, $title, $content){
			$insert_texts_index = $this->XVweb->DataBase->prepare("INSERT INTO {TextsIndex} ({TextsIndex:URL}, {TextsIndex:Parent}, {TextsIndex:Title}) VALUES (:url, :parent, :title);");
			$url_parent = str_replace("\\", "/", dirname($url));
			if($url_parent != "/"){
				$url_parent .= "/";
			}
			$insert_texts_index->execute(array(
				":url" => $url,
				":parent" => $url_parent,
				":title" => $title,
			));
		$last_inserted_id = $this->XVweb->DataBase->lastInsertId();
		
		$insert_texts = $this->XVweb->DataBase->prepare("INSERT INTO {Texts} ({Texts:IDS}, {Texts:Date}, {Texts:User}, {Texts:IsActual}, {Texts:Content}) VALUES (:ids, NOW(), :user, 1, :content);");
		$insert_texts->execute(array(
			":ids"=>$last_inserted_id,
			":user"=>$user,
			":content"=> $content,
		));
	return true;
	}
	public function get_all_versions($id_or_url){
		if(is_numeric($id_or_url)){
			$page_id = $id_or_url;
		}else{
			$page_index_data = $this->get_texts_index($id_or_url);
			if(empty($page_index_data))
				return array();
			$page_id = $page_index_data['ID'];
		}
		$get_versions = $this->XVweb->DataBase->prepare("SELECT 
			{Texts:ID} AS ID,
			{Texts:IDS} AS IDS,
			{Texts:Date} AS Date,
			{Texts:User} AS User,
			{Texts:IsActual} AS IsActual,
			{Texts:Changes} AS Changes
		FROM {Texts} WHERE {Texts:IDS} = :page_id ORDER BY {Texts:Date} DESC;");
		$get_versions->execute(array(
			":page_id" => $page_id
		));
		return $get_versions->fetchAll(PDO::FETCH_ASSOC);
	
	}
	public function get_version($id_or_url, $date){
		if(is_numeric($id_or_url)){
			$page_id = $id_or_url;
		}else{
			$page_index_data = $this->get_texts_index($id_or_url);
			if(empty($page_index_data))
				return array();
			$page_id = $page_index_data['ID'];
		}
		$get_version = $this->XVweb->DataBase->prepare("SELECT 
			{Texts:*}
		FROM {Texts} WHERE {Texts:IDS} = :page_id AND {Texts:Date} = :date LIMIT 1;");
		$get_version->execute(array(
			":page_id" => $page_id,
			":date" => $date
		));
		return $get_version->fetch(PDO::FETCH_ASSOC);
	}
	public function add_new_version($user, $id_or_url, $content, $changes= null){
		if(is_numeric($id_or_url)){
			$page_id = $id_or_url;
		}else{
			$page_index_data = $this->get_texts_index($id_or_url);
			if(empty($page_index_data))
				return false;
			$page_id = $page_index_data['ID'];
		}
		$insert_texts = $this->XVweb->DataBase->prepare("INSERT INTO {Texts} ({Texts:IDS}, {Texts:Date}, {Texts:User}, {Texts:IsActual}, {Texts:Content}, {Texts:Changes}) VALUES (:ids, NOW(), :user, 0, :content, :changes);");
		$insert_texts->execute(array(
			":ids"=>$page_id,
			":user"=>$user,
			":content"=> $content,
			":changes"=> $changes,
		));
		
		return true;
	}
	
	public function get_page($url, $date=null){
			$exec_array = array(
				":url"=>$url
			);
			if(!is_null($date)){
				$exec_array[":date"] = $date;
			}
			$get_page = $this->XVweb->DataBase->prepare("SELECT 
				t1.{TextsIndex:URL} AS URL,
				t1.{TextsIndex:Parent} AS Parent,
				t1.{TextsIndex:Title} AS Title,
				t1.{TextsIndex:Blocked} AS Blocked,
				t1.{TextsIndex:Views} AS Views,
				t2.{Texts:ID} AS ID,
				t2.{Texts:IDS} AS IDS,
				t2.{Texts:Date} AS Date,
				t2.{Texts:Content} AS Content,
				t2.{Texts:Changes} AS Changes
			FROM {TextsIndex} AS t1 INNER JOIN {Texts} AS t2 ON t1.{TextsIndex:ID} = t2.{Texts:IDS}  WHERE  t1.{TextsIndex:URL} = :url ".(is_null($date) ? ' AND t2.{Texts:IsActual} = 1 ' : ' AND t2.{Texts:Date} = :date')." ORDER BY t2.{Texts:Date} DESC  LIMIT 1 FOR UPDATE;");
			$get_page->execute($exec_array);
	
		$result_data =  $get_page->fetch(PDO::FETCH_ASSOC);
		if(!empty($result_data)){
			$update_counter = $this->XVweb->DataBase->pquery("UPDATE {TextsIndex} SET {TextsIndex:Views} = {TextsIndex:Views} + 1 WHERE {TextsIndex:ID} = ".$result_data['IDS'].' LIMIT 1;');
		}
		return $result_data;
		
	}
	public function set_version($id_or_url, $date){
		if(is_numeric($id_or_url)){
			$page_id = $id_or_url;
		}else{
			$page_index_data = $this->get_texts_index($id_or_url);
			if(empty($page_index_data))
				return false;
			$page_id = $page_index_data['ID'];
		}
		
		$check_version =  $this->XVweb->DataBase->pquery("SELECT  {Texts:ID} AS ID FROM {Texts}  WHERE {Texts:IDS} = ".$page_id.' AND  {Texts:Date} = '.$this->XVweb->DataBase->quote($date).' LIMIT 1;')->fetch(PDO::FETCH_ASSOC);
		if(empty($check_version))
			return false;
			
		$this->XVweb->DataBase->pquery("UPDATE {Texts} SET  {Texts:IsActual} = 0 WHERE {Texts:IDS} = ".$page_id.';');
		
		$this->XVweb->DataBase->pquery("UPDATE {Texts} SET  {Texts:IsActual} = 1 WHERE {Texts:IDS} = ".$page_id.' AND  {Texts:Date} = '.$this->XVweb->DataBase->quote($date).' LIMIT 1;');
		
		return true;
		
	}
}
?>