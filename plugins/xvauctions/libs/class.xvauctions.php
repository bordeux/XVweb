<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/


header("Cache-Control: no-cache, must-revalidate");
include_once(dirname(__FILE__)."/../includes/functions.xvauctions.php");

/**
 * xvauctions
 * Główna klasa, zawierająca niezbędne funkcję do poprawnego funkcjonowania systemu.
 * @note Do tej klasy, w konstruktorze musi być przekazany objekt XVweb
 */
class xvauctions {
	/**
	 * Zmienna przechowywująca dane klasy, w szczególności $this->Data['XVweb']
	 */
	var $Data;
	
	/**
	 * Kontruktor xvauction
	 * @param $Xvweb XVweb - referencja do obiektu XVweb
	 * @return void
	 */
	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;

		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	/**
	 * Pobierane są pola dla danej kategorii
	 * @param $category STRING Adres kategori rozpoczynający się i kończący slashem "/"
	 * @param $add BOOLEAN - Domyślnie jest FALSE. Gdy jest ustawione na FALSE sortuje pola według kolumny AuctionFields:Priority, natomiast ustawione na TRUE sortuje według AuctionFields:AddPriority
	 * @return array() - Wynikiem jest tablica, z wartościami wedle pół z pliku db.xml dla tabeli AuctionFields
	 */
	public function get_fields($category, $add = false){
		$category_parents = xvauctions_operations::get_category_parents($category);
		
		foreach($category_parents as &$item){
			$item = $this->Data['XVweb']->DataBase->quote($item);
		}
		
		
		$fields_parent = $this->Data['XVweb']->DataBase->prepare('SELECT
				{AuctionFields:*}
		FROM 
			{AuctionFields}
		WHERE
			{AuctionFields:Category} IN ('.implode(",", $category_parents).') 
		ORDER BY 
			{AuctionFields:'.($add == true ? "Add" : "").'Priority} DESC ,
			{AuctionFields:Category} ASC
		');
		
		$fields_parent->execute();
		
		$fields_parent = $fields_parent->fetchAll(PDO::FETCH_ASSOC);
		foreach($fields_parent as &$item){
			$item['FieldOptions'] = unserialize($item['FieldOptions']);
		}
		
		return $fields_parent;
	}
	/**
	 * Pobierane są kategorie
	 * @param $category STRING Adres kategori rozpoczynający się i kończący slashem "/"
	 * @param $params ARRAY - parametry wyświetlania. Obecnie można ustawić na puste tablicę, dzięki czemu wyniki są zachowywane w CACHE. Natomiast gdy nie jest pusta, wyniki są pobierane wprost z bazy danych
	 * @return array() - Wynikiem jest tablica, z wartościami wedle AuctionCategories:* + (isSelected - zwraca 1 dla kategori wybranej) + (isChild - zwraca 1 gdy kategoria jest rodzicem obecnej)  + (AuctionsCount - liczba aukcji w kategorii)
	 */
	public function get_categories($category, $params){
		if(empty($params)){
			if($this->Data['XVweb']->Cache->exist("auctions_get_categories",$category))
			return  $this->Data['XVweb']->Cache->get();
		}
		$subauctions_count = 'SELECT COUNT(*) FROM {AuctionAuctions} AS AB WHERE {AuctionAuctions:Enabled} = 1 AND 
						AB.{AuctionAuctions:Category} LIKE CONCAT(AA.{AuctionCategories:Category}, "%")';
		$categories_list = $this->Data['XVweb']->DataBase->prepare('SELECT
					{AuctionCategories:*:prepend:AA.},
					(CASE WHEN {AuctionCategories:Category} = :category THEN 1 ELSE 0 END) AS `isSelected`,
					'. ($category == '/' ? ' 0  AS `isChild` ' : ' (CASE WHEN {AuctionCategories:Parent} = :category THEN 1 ELSE 0 END) AS `isChild`').',
					('.$subauctions_count.') AS `AuctionsCount`
				FROM 
					{AuctionCategories} AS AA
				WHERE
					(
						{AuctionCategories:Parent} = :category 
						OR
						{AuctionCategories:Parent} = :parent
					)
				AND
				(
						AA.{AuctionCategories:AlwaysShow} = 1 
					OR
					('.$subauctions_count.') > 0
				)
				ORDER BY  
					AA.{AuctionCategories:Category} ASC,
					AA.{AuctionCategories:Name} ASC
			'
		);
		$categories_list->execute(array(
		":category" => $category,
		":parent" => xvauctions_operations::get_category_parent($category)
		));
		
		$categories_list = $categories_list->fetchAll(PDO::FETCH_ASSOC);
		foreach($categories_list as &$item){
			$item['Options'] = unserialize($item['Options']);
		}
		if(empty($params)){
			return $this->Data['XVweb']->Cache->put("auctions_get_categories",$category, ($categories_list));
		}
		return ($categories_list);
	}
	/**
	 * Pobierane drzewka kategorii
	 * @param $category STRING Adres kategori rozpoczynający się i kończący slashem "/"
	 * @return array() - Wynikiem jest tablica posortowania według Rodzica do Dziecka. Dla każdej kategori są pobierane wszystkie pola wedle {AuctionCategories:*} 
	 */
	public function get_category_tree($category){
		$ParentsCategories = xvauctions_operations::get_category_parents($category);
		foreach($ParentsCategories as &$item){
			$item = $this->Data['XVweb']->DataBase->quote($item);
		}
		if(empty($category))
		return array();
		
		$CategoryTree = $this->Data['XVweb']->DataBase->prepare('
		SELECT
					{AuctionCategories:*} 	
			FROM 
				{AuctionCategories}
			WHERE
				{AuctionCategories:Category} IN ('.implode(",", $ParentsCategories).') 
			ORDER BY  {AuctionCategories:Category} ASC
		');
		
		$CategoryTree->execute();
		$CategoryTree = $CategoryTree->fetchAll(PDO::FETCH_ASSOC);
		include(dirname(__FILE__).'/../config/default.php');
		foreach($CategoryTree as &$item){
			$options_tmp = unserialize($item['Options']);
			$item['Options'] = $xva_config = array_merge($xva_config, (is_array($options_tmp) ? $options_tmp : array()));
		}
		return $CategoryTree;
	}
	/**
	 * Pobierane informacji o kategorii
	 * @param $category STRING Adres kategori rozpoczynający się i kończący slashem "/"
	 * @return array() - Wynikiem jest tablica z wartościami {AuctionCategories:*}
	 */
	public function get_category($category){
		
		$Category = $this->Data['XVweb']->DataBase->prepare('
		SELECT
					{AuctionCategories:*} 	
			FROM 
				{AuctionCategories}
			WHERE
				{AuctionCategories:Category} = :category
			LIMIT 1;
		');
		
		$Category->execute(array(
		":category" => $category
		));
		$Category = $Category->fetch(PDO::FETCH_ASSOC);
		return $Category;
	}
	/**
	 * Tworzy nową aukcje w indexie (w tabeli {AuctionAuctions} )
	 * @param $params ARRAY Parametry w postaci tablicy. Przykładowa tablica:
	@code
	$params = array(
			":category" => "/kategoria/kategoria2/",
			":title" => "Tytuł aukcji",
			":pieces" => "32", // liczba sztuk
			":type" => "buynow", //typ aukcji, do wyboru - [buynow, dutch, both, auction]
			":buynow" => "42.42", // kwota w postaci DECIMAL(10,2) . Obowiązkowe dla typu^ buynow, dutch, both
			":auction" => "42.42", // kwota w postaci DECIMAL(10,2) . Obowiązkowe dla typu^ dutch, both, auction
			":start" => date("Y-m-d H:i:s", time()), // Czas startu aukcji
			":end" =>  date("Y-m-d H:i:s", strtotime("+14 day")), // Czas zakończenia aukcji
			":auctionmin" =>  number_format(0, 2, '.', ''), // Wartość minimalna dla typu dutch
			":auctiondutch" =>  number_format(0, 2, '.', ''), // cena początkowa dla typu dutch
			":seller" => $XVwebEngine->Session->Session('user_name'), //Sprzedający
			":premium" => 0, //czy ma byc na poczatku listy - premium
		)
	@endcode
	 * @return INT - Wynikiem jest ID utworzonego rekordu.
	 */
	public function create_auction($params){
		
		$add_auction = $this->Data['XVweb']->DataBase->prepare('INSERT INTO {AuctionAuctions} ({AuctionAuctions:Category}, {AuctionAuctions:Title}, {AuctionAuctions:Type}, {AuctionAuctions:BuyNow}, {AuctionAuctions:Auction}, {AuctionAuctions:AuctionsCount}, {AuctionAuctions:Start}, {AuctionAuctions:End}, {AuctionAuctions:AuctionMin}, {AuctionAuctions:AuctionDutch}, {AuctionAuctions:Seller}, {AuctionAuctions:Pieces}, {AuctionAuctions:Enabled}, {AuctionAuctions:Premium}  '.(isset($params[':id']) ? ', {AuctionAuctions:ID}' : '').' '.(isset($params[':views']) ? ', {AuctionAuctions:Views}' : '').') VALUES (:category , :title, :type, :buynow, :auction, 0, :start, :end, :auctionmin, :auctiondutch, :seller, :pieces, 1, :premium '.(isset($params[':id']) ? ' , :id' : '').' '.(isset($params[':id']) ? ' , :views' : '').');');
		$add_auction->execute($params);
		
		return $this->Data['XVweb']->DataBase->lastInsertId();
		
	}	
	/**
	 * Zapisywanie sesji z wartościami pól
	 * @param $auction_id INT - ID aukcji
	 * @param $val ARRAY - Tablica z wartościami
	 * @return TRUE
	 */
	public function save_session($auction_id, $val){
		$add_auction = $this->Data['XVweb']->DataBase->prepare('INSERT INTO {AuctionSessions} ({AuctionSessions:Auction} , {AuctionSessions:Val}) VALUES (:auction , :val );');
		$add_auction->execute(array(
		":auction" => $auction_id,
		":val" => serialize($val),
		));
		
		return true;
		
	}
	/**
	 * Pobiera sesje zapisanej aukcji, poprzez save_session
	 * @param $auction_id INT - ID aukcji
	 * @return ARRAY
	 */
	public function get_session($auction_id){
		$get_auction = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionSessions:Val} AS session FROM {AuctionSessions} WHERE {AuctionSessions:Auction} = :auction LIMIT 1;');
		$get_auction->execute(array(
		":auction" => $auction_id,
		));
		$get_auction = $get_auction->fetch(PDO::FETCH_ASSOC);
		return unserialize(isset($get_auction['session']) ? $get_auction['session'] : null);
		
	}
	/**
	 * Pobieranie listy aukcji
	 * @param $category STRING - adres aktualnej kategorii, np. "/" dla głównej
	 * @param $params ARRAY - tablica z wartościami dla zapytania SQL w postaci
	 @code
		array(
			0 => array(
					0 => "( f.{AuctionFields:Name} = :change AND v.{AuctionValues:Val} = :change )",
					1 => array(
							":change" => "wartosc"
						)
				)
		)
	 @endcode
	 Zapytania generowane są przez klasy pól aukcji
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, offers, start, end, views],
			'sort' => "ASC", // do wyboru [ASC, DESC],
			'type' => "buynow", // wyświetlenie aukcji według typu
			'seller' => "admin", // wyświetlenie aukcji użytkownika
			'cost_to' => "200.00", // wyświetlenie aukcji do ceny 200.00
			'cost_form' => "10.00", // wyświetlenie aukcji od ceny 10.00
			
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit INT - ilość wyników na strone
	 * @return ARRAY() - dwuelementowa tablica, gdzie tab[0] to tablica wynikow , a tab[1] - to liczba wyszukanych rekordów
	 */
	public function get_auctions($category, $params, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$execute_parms = array();
		$execute_parms[":category"] = $category.'%';
		$search_queries = array();
		foreach($params as $parm){
			if(!empty($parm[0]))
			$search_queries[] = $parm[0];
			if( is_array($parm[1]) ){
				foreach($parm[1] as $execKey=>$execVal){
					$execute_parms[$execKey] = $execVal;
				}
				
			}
		}
		$WhereSQL = '';
		$SortBy = "";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "id":
				$SortBy = ', {AuctionAuctions:ID} '.$Sort;
				break;		
			case "title":
				$SortBy = ', {AuctionAuctions:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = ', {AuctionAuctions:BuyNow} '.$Sort;
				break;
			case "offers":
				$SortBy = ', {AuctionAuctions:AuctionsCount} '.$Sort;
				break;	
			case "start":
				$SortBy = ', {AuctionAuctions:Start} '.$Sort;
				break;	
			case "end":
				$SortBy = ', {AuctionAuctions:End} '.$Sort;
				break;	
			case "views":
				$SortBy = ', {AuctionAuctions:Views} '.$Sort;
				break;
			}
		}
		if(isset($display_options['type'])){
			if(is_array($display_options['type'])){
				foreach($display_options['type'] as &$val){
					if($val == "buynow")
						$val = "both";
					$val = $this->Data['XVweb']->DataBase->quote($val);
				}
				$WhereSQL .= 'AND ({AuctionAuctions:Type} IN ('.implode( ",", $display_options['type']).')) ';
			}else{
				if($display_options['type'] =="buynow"){
					$WhereSQL .= 'AND ({AuctionAuctions:Type} = :a_type OR {AuctionAuctions:Type} = "both") ';
				}else{
					$WhereSQL .= 'AND {AuctionAuctions:Type} = :a_type ';
				}
				$execute_parms[':a_type'] = $display_options['type'];
			}
		}
		if(isset($display_options['seller'])){
			$WhereSQL .= 'AND {AuctionAuctions:Seller} = :a_seller ';
			$execute_parms[':a_seller'] = $display_options['seller'];
		}
		if(isset($display_options['cost_to'])){
			$WhereSQL .= 'AND {AuctionAuctions:BuyNow} < :a_c_to ';
			$execute_parms[':a_c_to'] = $display_options['cost_to'];
		}
		if(isset($display_options['cost_from'])){
			$WhereSQL .= 'AND {AuctionAuctions:BuyNow} > :a_c_from ';
			$execute_parms[':a_c_from'] = $display_options['cost_from'];
		}	
		
		if(isset($display_options['search'])){
			$search_string = str_replace(array("'", '"', '-'), ' ', $display_options['search']);
			$terms_search = explode(" ", $search_string);
			foreach($terms_search as $word_search){
				$word_search = trim($word_search);
				if(strlen($word_search) > 1){
					$uniqid_tmp = ":s_".uniqid();
					$WhereSQL .=  'AND {AuctionAuctions:Title} LIKE  '.$uniqid_tmp.' ';
					$execute_parms[$uniqid_tmp] = '%'.$word_search.'%';
				}
			}
	
		}

		$count_queries = count($search_queries);
		
		$query_search = 'AND {AuctionAuctions:ID} IN (SELECT 
	v.{AuctionValues:Auction}
FROM 
	{AuctionValues} v 
	LEFT JOIN {AuctionFields} f ON f.{AuctionFields:ID} = v.{AuctionValues:IDS}
WHERE 
	'.implode(" OR ", $search_queries).'
GROUP BY 
	{AuctionValues:Auction}
HAVING 
	COUNT({AuctionValues:Auction}) = '.$count_queries.')';

		
		$auctions =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
{AuctionAuctions:*:prepend:a.},
NOW() AS `NowTime`
FROM  
{AuctionAuctions} a
WHERE 
	{AuctionAuctions:Enabled} = 1
	AND
{AuctionAuctions:Category} LIKE :category 
'.$WhereSQL.'
'.($count_queries == 0 ? "" : $query_search).' 

ORDER BY {AuctionAuctions:Premium}  DESC '.$SortBy.'
LIMIT '.$formLimit.','.$PageLimit.'
');
		$auctions->execute($execute_parms);

		return array($auctions->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}
	/**
	 * Pobieranie wartości dla konkretnego pola z tabeli {AuctionValues}
	 * @param $field_id INT - ID pola
	 * @param $auction INT - ID aukcji
	 * @return STRING
	 */
	public function get_field_value($field_id, $auction){
		$select_field = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionValues:Val} as val FROM {AuctionValues} WHERE {AuctionValues:IDS} = :ids AND {AuctionValues:Auction} = :auction LIMIT 1;');
		$select_field->execute(array(
			":ids" => $field_id,
			":auction" => $auction,
		));
		$select_field = $select_field->fetch(PDO::FETCH_ASSOC);
		return (isset($select_field['val']) ? $select_field['val'] : null);
	}
	/**
	 * Pobieranie wartości dla wszystkich pól z aukcji z tabeli {AuctionValues}
	 * @param $auction INT - ID aukcji
	 * @return ARRAY()
	 */
	public function get_fields_values($auction){
		$select_field = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionValues:*} FROM {AuctionValues} WHERE  {AuctionValues:Auction} = :auction;');
		$select_field->execute(array(
			":auction" => $auction,
		));
		$select_field = $select_field->fetchAll(PDO::FETCH_ASSOC);
		$to_result = array();
		foreach($select_field as $val)
			$to_result[$val['IDS']] = $val;
			
		return $to_result;
		
	}
	/**
	 * Pobieranie danych aukcji z tabeli {AuctionAuctions:*}
	 * @param $id INT - ID aukcji
	 * @param $check BOOLEAN - TRUE - sprawdza czy aukcja jest aktywna, FALSE - nie sprawdza
	 * @param $refresh_auctions BOOLEAN - TRUE - odświeża aukcje
	 * @return ARRAY()
	 */
	public function get_auction($id, $check = false, $refresh_auctions = true){
		$Acution = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionAuctions:*} FROM {AuctionAuctions} WHERE {AuctionAuctions:ID} = :ID '.($check ? 'AND {AuctionAuctions:Enabled} = 1 AND {AuctionAuctions:Start} < NOW() AND {AuctionAuctions:End} > NOW() ' : '' ).' LIMIT 1;');
		$Acution->execute(array(
		":ID" => $id,
		));
		$result =   $Acution->fetch(PDO::FETCH_ASSOC);
		if(empty($result))
			return null;
			
		$auction_time_end = date_create_from_format('Y-m-d H:i:s', $result['End'])->getTimestamp();
		$now_time = time();
		if($refresh_auctions && $result['Enabled'] && ($auction_time_end < $now_time)){
			xvp()->refresh_auctions($this);
		}
		if($refresh_auctions && $result['Type'] == "dutch"){
			xvp()->update_dutch_auctions($this, $result['ID']);
		}
		$AcutionViews = $this->Data['XVweb']->DataBase->prepare('UPDATE {AuctionAuctions} SET {AuctionAuctions:Views} = {AuctionAuctions:Views}+1 WHERE {AuctionAuctions:ID} = :ID LIMIT 1;');
		$AcutionViews->execute(array(
		":ID" => $id,
		));
		return $result;
	}
	/**
	 * Pobieranie tekstu z tabeli {AuctionTexts} gdzie są przechowywane opisy aukcji
	 * @param $id INT - ID aukcji
	 * @param $name STRING - nazwa pola. Dla opisu aukcji to wartość "description"
	 * @return STRING - wynikiem jest text
	 */
	public function get_auction_description($id, $name = "description") {
		$Acution = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionTexts:Text} AS `Text`  FROM {AuctionTexts} WHERE {AuctionTexts:Auction} = :ID AND {AuctionTexts:Name} = :name LIMIT 1;');
		$Acution->execute(array(
		":ID" => $id,
		":name" => $name
		));
		$Acution = $Acution->fetch(PDO::FETCH_ASSOC);
		if(empty($Acution))
		return null;
		
		return $Acution['Text'];
	}
	/**
	 * Pobieranie ofert dla danej aukcji
	 * @param $auction_id INT - ID aukcji
	 * @return ARRAY - wynikiem są tablice z wartościami wedle {AuctionOffers:*}
	 */
	public function get_offers($auction_id){
		$offers = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionOffers:*}   FROM {AuctionOffers} WHERE {AuctionOffers:Auction} = :ID ORDER BY {AuctionOffers:Date} DESC;');
		$offers->execute(array(
			":ID" => $auction_id,
		));
		return $offers->fetchAll(PDO::FETCH_ASSOC);
	}
	/**
	 * Kończy aukcje, zmieniając {AuctionAuctions:Enabled} na 0 oraz {AuctionAuctions:End} na NOW()
	 * @param $auction_id INT - ID aukcji
	 * @param $now_end BOOLEAN - ustawione na true, zmienia {AuctionAuctions:End} na NOW()
	 * @return TRUE
	 */
	public function end_auction($auction_id, $now_end = true){
		$end_auction = $this->Data['XVweb']->DataBase->prepare('
		UPDATE 
			{AuctionAuctions} 
		SET 
			{AuctionAuctions:Enabled} = 0 
			 '.($now_end ? ',{AuctionAuctions:End} = NOW()' :  '').' 
		WHERE 
			{AuctionAuctions:ID} = :ID 
		LIMIT 1;');
		$end_auction->execute(array(
			":ID" => $auction_id
		));
		return true;
	}
	/**
	 * Edytuje wartości dla aukcji w tabeli {AuctionAuctions} 
	 * @param $auction_id INT - ID aukcji
	 * @param $params ARRAY -  tablica z danymi na temat zmiany pól, przykład
	 @code
		array(
			"Title"=>"Nowy tytuł" // klucz musi być kluczem z tabeli {AuctionAuctions}
		)
	 @endcode
	 * @return TRUE
	 */
	public function edit_auction($auction_id, $params){
		$sql_parms = array();
		foreach($params as $key=>$parm){
			$sql_parms[] = " {AuctionAuctions:".$key."} = ".$this->Data['XVweb']->DataBase->quote($parm)." ";
		}
		if(empty($sql_parms))
		return true;
		
		$end_auction = $this->Data['XVweb']->DataBase->prepare('UPDATE {AuctionAuctions} SET '.implode("," , $sql_parms).' WHERE {AuctionAuctions:ID} = :ID LIMIT 1;');
		$end_auction->execute(array(
		":ID" =>$auction_id
		));
		return true;
	}
	/**
	 * Tworzenie nowej oferty dla aukcji
	 * @param $auction_id INT - ID aukcji
	 * @param $user STRING - nazwa użytkownika
	 * @param $type STRING - typ aukcji
	 * @param $cost DECIMAL(10,2) - koszt za sztuke
	 * @param $pieces INT - ilość sztuk
	 * @return INT - ID dodanej oferty
	 */
	public function create_offer($auction_id, $user,$type,$cost,$pieces){
		$offer_add = $this->Data['XVweb']->DataBase->prepare('INSERT INTO {AuctionOffers} ({AuctionOffers:ID}, {AuctionOffers:Auction}, {AuctionOffers:User}, {AuctionOffers:Type}, {AuctionOffers:Date}, {AuctionOffers:Cost}, {AuctionOffers:Pieces}) VALUES (NULL, :auction , :user, :type, NOW(), :cost, :pieces);');
		
		$offer_add->execute(array(
		":auction" =>$auction_id,
		":user" => $user,
		":type"=> $type,
		":cost" => $cost,
		":pieces" =>$pieces,
		));
		
		return $this->Data['XVweb']->DataBase->lastInsertId(); 
	}
	/**
	 * Tworzenie nowego zakupu
	 * @param $auction_id INT - ID aukcji
	 * @param $user STRING - nazwa użytkownika
	 * @param $seller STRING - nazwa sprzedającego
	 * @param $type STRING - typ aukcji
	 * @param $cost DECIMAL(10,2) - koszt za sztuke
	 * @param $pieces INT - ilość sztuk
	 * @param $title STRING - tytuł aukcji
	 * @param $th STRING - thumbnail aukcji
	 * @return INT - ID dodanej oferty
	 */
	public function create_bought($auction_id, $user, $seller, $type,$cost,$pieces, $title, $th){
	
			// tutaj trzeba sprawdzić czy wcześniej zakupił i czy zaplacil
		$result_check = $this->Data['XVweb']->DataBase->pquery("SELECT {AuctionBought:ID} as id FROM {AuctionBought} WHERE {AuctionBought:Auction} = ".((int) $auction_id)." AND {AuctionBought:Paid} = 0 LIMIT 1; ")->fetch();
		if(isset($result_check['id'])){
			$this->Data['XVweb']->DataBase->pquery("UPDATE {AuctionBought} SET {AuctionBought:Pieces} = {AuctionBought:Pieces} + ".((int) $pieces)." WHERE {AuctionBought:ID} = ".$result_check['id'].";");
			return $result_check['id'];
		}else{
			$bought_add = $this->Data['XVweb']->DataBase->prepare('INSERT INTO {AuctionBought} ({AuctionBought:Auction}, {AuctionBought:User}, {AuctionBought:Seller}, {AuctionBought:Type}, {AuctionBought:Date}, {AuctionBought:Cost}, {AuctionBought:Pieces}, {AuctionBought:Title}, {AuctionBought:Thumbnail}) VALUES (:auction , :user, :seller, :type, NOW(), :cost, :pieces, :title, :thumbnail)  ON DUPLICATE KEY UPDATE {AuctionBought:Pieces} = {AuctionBought:Pieces} + '.((int) $pieces).' ;');
			
			$bought_add->execute(array(
			":auction" =>$auction_id,
			":user" => $user,
			":type"=> $type,
			":cost" => $cost,
			":pieces" =>$pieces,
			":title" => $title,
			":thumbnail" => $th,
			":seller" => $seller,
			));
		}
		return $this->Data['XVweb']->DataBase->lastInsertId(); 
	}
	/**
	 * Pobiera listę zakupionych przedmiotów
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, pieces, date, id, type],
			'sort' => "ASC", // do wyboru [ASC, DESC],
			'by_seller' => false, // wartość true oznacza że wyszukuje wyniki według {AuctionBought:Seller} = $user
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionBought:*}, COUNT({AuctionBought:*}))
	 */
	public function get_bought($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionBought:Date} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionBought:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionBought:Cost} '.$Sort;
				break;
			case "pieces":
				$SortBy = '{AuctionBought:Pieces} '.$Sort;
				break;	
			case "date":
				$SortBy = '{AuctionBought:Date} '.$Sort;
				break;	
			case "id":
				$SortBy = '{AuctionBought:Auction} '.$Sort;
				break;	
			case "type":
				$SortBy = '{AuctionBought:Type} '.$Sort;
				break;
			}
		}
		$bought_by = "{AuctionBought:User}";
		if(isset($display_options['by_seller']) && $display_options['by_seller']){
			$bought_by = "{AuctionBought:Seller}";
		}

		$boughts =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionBought:*}
		FROM  
		{AuctionBought}
		WHERE 
			{AuctionBought:HiddenForBuyer} = 0
			AND
			'.$bought_by.' = :user
		ORDER BY '.$SortBy.' 
		LIMIT '.$formLimit.', '.$PageLimit.'
	');

		$boughts->execute(array(
		":user" => $user
		));

		return array($boughts->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}
	
	/**
	 * Pobiera listę licytowanych przedmiotów
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, id, end, seller],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionAuctions:*}, COUNT({AuctionAuctions:*}))
	 */
	public function get_bid($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionAuctions:Start} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionAuctions:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionAuctions:BuyNow} '.$Sort;
				break;
			case "id":
				$SortBy = '{AuctionAuctions:ID} '.$Sort;
				break;	
			case "end":
				$SortBy = '{AuctionAuctions:End} '.$Sort;
				break;		
			case "seller":
				$SortBy = '{AuctionAuctions:Seller} '.$Sort;
				break;
			}
		}
		

		$bids =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionAuctions:*:prepend:AA.}
		FROM  
			{AuctionAuctions} AS AA
		INNER JOIN
			{AuctionOffers} AS AB
		ON
			AB.{AuctionOffers:Auction} = AA.{AuctionAuctions:ID}
		WHERE
			AA.{AuctionAuctions:Enabled} = 1
		AND
			AA.{AuctionAuctions:End} > NOW()
		AND
			AB.{AuctionOffers:User} = :user
		AND
			AB.{AuctionOffers:Type} = :auction
		GROUP BY 
			AA.{AuctionAuctions:ID}
		ORDER BY 
			'.$SortBy.' 
		LIMIT 
			'.$formLimit.', '.$PageLimit.'
	');
		$bids->execute(array(
		":user" => $user,
		":auction" => "auction",
		));

		return array($bids->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}

	/**
	 * Pobiera listę niewygranych licytacji
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, id, offers, seller],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionAuctions:*}, COUNT({AuctionAuctions:*}))
	 */
	public function get_no_bought($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionAuctions:Start} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionAuctions:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionAuctions:BuyNow} '.$Sort;
				break;
			case "id":
				$SortBy = '{AuctionAuctions:ID} '.$Sort;
				break;	
			case "offers":
				$SortBy = '{AuctionAuctions:AuctionsCount} '.$Sort;
				break;	
			case "seller":
				$SortBy = '{AuctionAuctions:Seller} '.$Sort;
				break;
			}
		}
		

		$bids =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionAuctions:*:prepend:AA.}
		FROM  
			{AuctionAuctions} AS AA
		INNER JOIN
			{AuctionOffers} AS AB
		ON
			AB.{AuctionOffers:Auction} = AA.{AuctionAuctions:ID}
		WHERE
			AA.{AuctionAuctions:Enabled} = 0
		AND
			AA.{AuctionAuctions:End} < NOW()
		AND
			AB.{AuctionOffers:User} = :user
		AND
			AB.{AuctionOffers:Type} = :auction
		AND
			AA.{AuctionAuctions:ID} 
				NOT IN
					(SELECT {AuctionBought:Auction} FROM {AuctionBought} WHERE  {AuctionBought:User} = :user)
		GROUP BY 
			AA.{AuctionAuctions:ID}
		ORDER BY 
			'.$SortBy.' 
		LIMIT 
			'.$formLimit.', '.$PageLimit.'
	');
		$bids->execute(array(
		":user" => $user,
		":auction" => "auction",
		));

		return array($bids->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}

	/**
	 * Pobiera listę niesprzedanych przedmiotów
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, id, offers, seller],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionAuctions:*}, COUNT({AuctionAuctions:*}))
	 */
	public function get_no_selled($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionAuctions:Start} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionAuctions:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionAuctions:BuyNow} '.$Sort;
				break;
			case "id":
				$SortBy = '{AuctionAuctions:ID} '.$Sort;
				break;	
			case "end":
				$SortBy = '{AuctionAuctions:End} '.$Sort;
				break;	
			case "start":
				$SortBy = '{AuctionAuctions:Start} '.$Sort;
				break;
			}
		}
		

		$sql_query =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionAuctions:*:prepend:AA.}
		FROM  
			{AuctionAuctions} AS AA
		WHERE
			AA.{AuctionAuctions:HiddenBySeller} = 0	
		AND
			AA.{AuctionAuctions:Enabled} = 0
		AND
			AA.{AuctionAuctions:End} < NOW()
		AND
			AA.{AuctionAuctions:Seller} = :user
		AND
			AA.{AuctionAuctions:ID} 
				NOT IN
					(SELECT {AuctionBought:Auction} FROM {AuctionBought})
		GROUP BY 
			AA.{AuctionAuctions:ID}
		ORDER BY 
			'.$SortBy.' 
		LIMIT 
			'.$formLimit.', '.$PageLimit.'
	');
		$sql_query->execute(array(
		":user" => $user,
		));

		return array($sql_query->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}

	/**
	 * Pobiera listę przemiotów czekających na wystawienie
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, id, offers, seller],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionAuctions:*}, COUNT({AuctionAuctions:*}))
	 */
	public function get_to_add($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionAuctions:Start} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionAuctions:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionAuctions:BuyNow} '.$Sort;
				break;
			case "id":
				$SortBy = '{AuctionAuctions:ID} '.$Sort;
				break;	
			case "end":
				$SortBy = '{AuctionAuctions:End} '.$Sort;
				break;	
			case "start":
				$SortBy = '{AuctionAuctions:Start} '.$Sort;
				break;
			}
		}
		

		$sql_query =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionAuctions:*:prepend:AA.}
		FROM  
			{AuctionAuctions} AS AA
		WHERE
			AA.{AuctionAuctions:Enabled} = 0
		AND
			AA.{AuctionAuctions:Start} > NOW()
		AND
			AA.{AuctionAuctions:Enabled} = 0
		AND
			AA.{AuctionAuctions:Seller} = :user
		ORDER BY 
			'.$SortBy.' 
		LIMIT 
			'.$formLimit.', '.$PageLimit.'
	');
		$sql_query->execute(array(
		":user" => $user,
		));

		return array($sql_query->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}

	/**
	 * Pobiera listę transakcji, gdzie nie wystawiono komentarzy
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [title, cost, id, offers, seller],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki według array({AuctionBought:*}, COUNT({AuctionBought:*}))
	 */
	public function get_comments_to_insert($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionBought:Auction} DESC";
		$exec_array = array(
			":user" => $user,
		);
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{AuctionBought:Title} '.$Sort;
				break;
			case "cost":
				$SortBy = '{AuctionBought:Cost} '.$Sort;
				break;
			case "id":
			case "auction":
				$SortBy = '{AuctionBought:Auction} '.$Sort;
				break;	
			case "date":
				$SortBy = '{AuctionBought:Date} '.$Sort;
				break;	
			case "contractor":
				$SortBy = '`Contractor` '.$Sort;
				break;
			}
		}
		$sql_query =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionBought:*} ,
			( CASE WHEN {AuctionBought:Seller} = :user THEN {AuctionBought:User} ELSE {AuctionBought:Seller} END) AS `Contractor`
		FROM  
			{AuctionBought}
		WHERE
			( {AuctionBought:CommentedSeller} = 0 AND {AuctionBought:Seller} = :user )
		OR
			( {AuctionBought:CommentedBuyer} = 0 AND {AuctionBought:User} = :user )
		ORDER BY 
			'.$SortBy.' 
		LIMIT 
			'.$formLimit.', '.$PageLimit.'
	');
		$sql_query->execute($exec_array);

		return array($sql_query->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}
	public function set_hidden($table, $field, $where = array(
		"user_field" => "{field:User}",
		"user" => "",
		"auctions" => array(),
		"auctions_field" => "field",
	)){

	foreach($where['auctions'] as &$val)
		$val = $this->Data['XVweb']->DataBase->quote($val);

		$this->Data['XVweb']->DataBase->prepare('UPDATE '.$table.' SET '.$field.' = 1 WHERE '.$where['user_field']. ' = '.$this->Data['XVweb']->DataBase->quote($where['user']).' AND '.$where['auctions_field']. ' IN ('.implode(", ",$where['auctions']).') ;')->execute();
		return true;
	}
	/**
	 * Ukrywa dla użytkownika transakcje
	 * @param $user STRING - nazwa użytkownika
	 * @param $auctions ARRAY - tablica z ID transakcji , wedle array(11111,22222,3333)
	 * @return BOOLEAN
	 */
	public function set_hidden_boguht($user, $auctions){
		return $this->set_hidden("{AuctionBought}", "{AuctionBought:HiddenForBuyer}", array(
				"user_field" => "{AuctionBought:User}",
				"user" => $user,
				"auctions" => $auctions,
				"auctions_field" => "{AuctionBought:ID}",
			));
	}
	
	/**
	 * Ustawia transakcje jako transakcje sfinalizowaną (użytkownik dokonał zapłaty)
	 * @param $id INT - ID transakcji
	 * @param $tid INT - ID przelewu
	 * @return BOOLEAN
	 */
	public function set_done_boguht($id, $tid){
		$update = $this->Data['XVweb']->DataBase->prepare('UPDATE {AuctionBought} SET {AuctionBought:Paid} = :tid WHERE {AuctionBought:ID} = :id LIMIT 1;');
		$update->execute(array(
			":id"=>$id,
			":tid" =>$tid
		));
		return true;
	}
	/**
	 * Ukrywa dla użytkownika przedmioty, których nie sprzedał
	 * @param $user STRING - nazwa użytkownika
	 * @param $auctions ARRAY - tablica z ID transakcji , wedle array(11111,22222,3333)
	 * @return BOOLEAN
	 */
	public function set_hidden_no_selled($user, $auctions){
		return $this->set_hidden("{AuctionAuctions}", "{AuctionAuctions:HiddenBySeller}", array(
				"user_field" => "{AuctionAuctions:Seller}",
				"user" => $user,
				"auctions" => $auctions,
				"auctions_field" => "{AuctionAuctions:ID}",
			));
	}
	
	/**
	 * Pobieranie informacji o zakupie
	 * @param $id INT - id zakupu
	 * @return ARRAY - dane według {AuctionBought:*}
	 */
	public function get_bought_item($id){

		$boughts =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionBought:*}
		FROM  
		{AuctionBought}
		WHERE 
			{AuctionBought:ID} = :id
		LIMIT 1;
	');

		$boughts->execute(array(
			":id" => $id
		));

		return $boughts->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Tworzenie nowej o transakcji
	 * @param $user STRING - nazwa użytkownika
	 * @param $auction INT - id aukcji
	 * @param $type ENUM('positive', 'negative', 'neutral') - rodzaj komentarza
	 * @param $opinion STRING(255) - komentarz do transakcji
	 * @param $r_compatibility INT - ocena za zgodność opisu z przedmiotem
	 * @param $r_contact INT - ocena za kontakt z użytkownikiem
	 * @param $r_realization INT - ocena za czas realizacji
	 * @param $r_shipping INT - ocena za koszt przesyłki
	 * @param $seller SRING - nazwa sprzedawcy
	 * @param $buyer SRING - nazwa kupującego
	 * @return INT - id komentarza
	 */
	public function create_opinion($user, $auction, $type, $opinion,$r_compatibility,$r_contact, $r_realization, $r_shipping, $seller, $buyer){
		$opinion_add = $this->Data['XVweb']->DataBase->prepare('INSERT INTO {AuctionOpinions} (
		{AuctionOpinions:User},
		{AuctionOpinions:Auction},
		{AuctionOpinions:Type},
		{AuctionOpinions:Opinion},
		{AuctionOpinions:Compatibility},
		{AuctionOpinions:Contact},
		{AuctionOpinions:Realization},
		{AuctionOpinions:Shipping},
		{AuctionOpinions:Seller},
		{AuctionOpinions:Buyer},
		{AuctionOpinions:Date}
		
		) VALUES (
			:user,
			:auction,
			:type,
			:opinion,
			:r_compatibility,
			:r_contact,
			:r_realization,
			:r_shipping,
			:seller,
			:buyer,
			NOW()
		);');
		
		$opinion_add->execute(array(
			":user" =>$user,
			":auction" =>$auction,
			":type" =>$type,
			":opinion" =>$opinion,
			":r_compatibility" =>$r_compatibility,
			":r_contact" =>$r_contact,
			":r_realization" =>$r_realization,
			":r_shipping" =>$r_shipping,
			":seller" =>$seller,
			":buyer" =>$buyer,
		));
		
		return $this->Data['XVweb']->DataBase->lastInsertId();; 
	}
	
	/**
	 * Pobiera listę komentarzy
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlenia, format
	 @code
		array(
			'sortby' => "title" , // sortowanie według pola title - do wyboru [id, auction, opinion, seller, buyer, date],
			'sort' => "ASC", // do wyboru [ASC, DESC],
		)
	 @endcode
	 * @param $page INT - numer aktualnej strony
	 * @param $PageLimit - limit wyników na stronę
	 * @return ARRAY() - wyniki array({AuctionAuctions:*}, COUNT({AuctionAuctions:*}))
	 */
	public function get_comments($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{AuctionOpinions:Date} DESC";
		$exec_array = array(
			":user" => $user
		);
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "id":
				$SortBy = '{AuctionOpinions:ID} '.$Sort;
				break;
			case "auction":
				$SortBy = '{AuctionOpinions:Auction} '.$Sort;
				break;
			case "opinion":
				$SortBy = '{AuctionOpinions:Opinion} '.$Sort;
				break;	
			case "seller":
				$SortBy = '{AuctionOpinions:Seller} '.$Sort;
				break;	
			case "buyer":
				$SortBy = '{AuctionOpinions:Buyer} '.$Sort;
				break;	
			case "date":
				$SortBy = '{AuctionOpinions:Date} '.$Sort;
				break;
			}
		}

		$c_type = false;
		if(isset($display_options['type']) && in_array($display_options['type'], array("positive", "neutral", "negative"))){
			$c_type = true;
			$exec_array[":c_type"] = $display_options['type'];
		}

		$comments =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{AuctionOpinions:*}
		FROM  
		{AuctionOpinions}
		WHERE 
			{AuctionOpinions:User} = :user
		'.($c_type ? ' AND {AuctionOpinions:Type} = :c_type' : '').'
		ORDER BY '.$SortBy.' 
		LIMIT '.$formLimit.', '.$PageLimit.'
	');

		$comments->execute($exec_array);

		return array($comments->fetchAll(PDO::FETCH_ASSOC), $this->Data['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count );
	}
	
	/**
	 * Pobiera informacje o użytkowniku
	 * @param $user STRING - nazwa użytkownika
	 * @return ARRAY - wedle {AuctionUsers:*}
	 */
	public function get_user_data($user){
		$user_info =	$this->Data['XVweb']->DataBase->prepare('SELECT {AuctionUsers:*} FROM {AuctionUsers} WHERE {AuctionUsers:User} = :user ORDER BY {AuctionUsers:Date} DESC LIMIT 1;');
		$user_info->execute(array(
			":user"=> $user
		));
	return $user_info->fetch();
		
	}
	/**
	 * Zapisywanie danych użytkownika do tabeli {AuctionUsers} 
	 * @param $user STRING - nazwa użytkownika
	 * @param $fields ARRAY - tablica z polami, formatu
	 @code
		array(
			"account_City" => "Ulica" // gdzie account_<Nazwa_pola_z_tabeli_{AuctionUsers}>
		);
	 @endcode
	 * @return INT - ID utworzonego rekordu w {AuctionUsers} 
	 */
	public function save_user_data($user, $fields){
		$sql_fields = array();
		$sql_values = array();
		
		foreach($fields as $key=>$val){
			if(substr($key, 0, 8) == "account_"){
				$key = htmlspecialchars($key, ENT_QUOTES);
				$sql_fields[] = " {AuctionUsers:".substr($key, 8)."}";
				$sql_values[] = $this->Data['XVweb']->DataBase->quote(htmlspecialchars($val, ENT_QUOTES));
			}
		}
		if(empty($sql_fields) || empty($sql_values) || empty($user))
			return false;
			
		$sql_fields[] = " {AuctionUsers:Date}";
		$sql_values[] = ' NOW() ';		
		
		$sql_fields[] = " {AuctionUsers:User}";
		$sql_values[] = $this->Data['XVweb']->DataBase->quote($user);
		$sql_query = 'INSERT INTO {AuctionUsers} 
			('.implode(", ", $sql_fields).')
			VALUES ( '.implode(", ", $sql_values).' )
			';
		$user_info =	$this->Data['XVweb']->DataBase->prepare($sql_query);
		$user_info->execute();
			
			
	return $this->Data['XVweb']->DataBase->lastInsertId();;
	
	}
	/**
	 * Sprawdzanie, czy użytkownik ma dostęp do informacji zamieszkania drugiego użytkownika - sprawdzanie, czy doszło do transakcji między użytkownikami.
	 * @param $user STRING - nazwa użytkownika
	 * @param $user2 STRING - nazwa użytkownika
	 * @return BOOLEAN
	 */
	public function check_perm_to_user_data($user, $user2){
		$check_status = $this->Data['XVweb']->DataBase->prepare("SELECT {AuctionBought:ID} AS ID FROM {AuctionBought} WHERE
			({AuctionBought:User} = :user	AND {AuctionBought:Seller} = :2user )
			OR
			({AuctionBought:User} = :2user	AND {AuctionBought:Seller} = :user ) LIMIT 1;");
		$check_status->execute(array(
			":2user" =>$user,
			":user" =>$user2
		));
		$check_status = $check_status->fetch();

		if(isset($check_status['ID']))
			return true;
			
		return false;
	}
	/**
	 * Pobieranie listy kategorii dla modułu dodawania aukcji
	 * @param $category STRING - aktualna kategoria
	 * @return ARRAY - res[sub] - subkategorie, res[info] - informacje o kategorii, res[parent] - rodzic kategorii
	 */
	public function get_api_categories($category){
		$Parent = (isset($category) ?  $category  : "/");
		$SelectCategories = $this->Data['XVweb']->DataBase->prepare('SELECT
				AA.{AuctionCategories:ID} as `ID`,
				AA.{AuctionCategories:Title} as `Title`,
				AA.{AuctionCategories:Name} as `Name`,
				AA.{AuctionCategories:Category} as `Category`,
				AA.{AuctionCategories:Parent} as `Parent`,
				AA.{AuctionCategories:Depth} as `Depth`,
				AA.{AuctionCategories:Use} as `Use`,
				(SELECT COUNT(*) FROM {AuctionCategories} AB WHERE AB.{AuctionCategories:Parent} =  AA.{AuctionCategories:Category} ) as `Childrens`
				
		FROM 
			{AuctionCategories} AA
		WHERE
			{AuctionCategories:Parent} = :Parent 
		ORDER BY  {AuctionCategories:Name} ASC
		');
		
		$SelectCategories->execute(array(
		":Parent" => $Parent,
		));	
		
		$SelectCategory = $this->Data['XVweb']->DataBase->prepare('SELECT
				{AuctionCategories:Category} AS `Category`,
				{AuctionCategories:Use} AS `Use`
				
		FROM 
			{AuctionCategories}
		WHERE
			{AuctionCategories:Category} = :Category 
		ORDER BY  {AuctionCategories:Name} ASC
		LIMIT 1;
		');
		
		$SelectCategory->execute(array(
		":Category" => $Parent,
		));
		$CatInfo = $SelectCategory->fetch(PDO::FETCH_ASSOC);
		if(empty($CatInfo)){
			$CatInfo = array("Category" => "/", "Use" =>0);
		}
		
		
		return (array("sub"=>$SelectCategories->fetchAll(PDO::FETCH_ASSOC), "info" => $CatInfo,  "parent"=> xvauctions_operations::get_category_parent($Parent)));
	}
	
	/**
	 * Przenosi aukcje do archiwum, oraz usuwa z tabeli {AuctionAuctions} oraz {AuctionValues}
	 * @return TRUE
	 */
	public function move_auction_to_archive($auction_id){
		if(!is_numeric($auction_id))
			return false;
			
		$data_auction = xvp()->get_auction($this, $auction_id, false, false);
		if(ifsetor($data_auction['Enabled'], 0) == 1){
			return false;
		}
		$data_fields = xvp()->get_fields_values($this, $auction_id);
		$data_offers = xvp()->get_offers($this, $auction_id);
		
		$data_texts = $this->Data['XVweb']->DataBase->pquery('SELECT {AuctionTexts:*}  FROM {AuctionTexts} WHERE {AuctionTexts:Auction} =  "'.$auction_id.'" ;')->fetchAll(PDO::FETCH_ASSOC);
		
		
	$sql_data = array(
		"auction" => $data_auction,
		"id" => $auction_id,
		"fields" => $data_fields,
		"offers" => $data_offers,
		"texts" => $data_texts,
	);
	
		try{
			$add_to_archive = $this->Data['XVweb']->DataBase->prepare('
			INSERT INTO {AuctionArchive} ({AuctionArchive:ID}, {AuctionArchive:Data}) 
			VALUES (:id, :data)
			');
			$add_to_archive->execute(array(
				":id" => $auction_id,
				":data" => serialize($sql_data)
			));
			
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionAuctions} WHERE  {AuctionAuctions:ID} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionValues} WHERE  {AuctionValues:Auction} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionTexts} WHERE  {AuctionTexts:Auction} = '".$auction_id."'; ");
		 
		} catch(Exception $e){
			return false;
		}
		return true;
	}
	
	public function delete_auction_data($auction_id){
	
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionAuctions} WHERE  {AuctionAuctions:ID} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionValues} WHERE  {AuctionValues:Auction} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionTexts} WHERE  {AuctionTexts:Auction} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionArchive} WHERE  {AuctionArchive:ID} = '".$auction_id."'; ");
		 $this->Data['XVweb']->DataBase->pquery("DELETE FROM {AuctionGallery} WHERE  {AuctionGallery:Auction} = '".$auction_id."'; ");
		return true;
	}
	
	/**
	 * Pobiera aukcje z archiwum
	 * @param $auction_id INT - ID aukcji
	 * @return ARRAY or NULL
	 */
	public function get_from_archive($auction_id){
	$get_from_archive = $this->Data['XVweb']->DataBase->prepare('SELECT {AuctionArchive:*} FROM {AuctionArchive} WHERE {AuctionArchive:ID} = :id LIMIT 1;');
	$get_from_archive->execute(array(
		":id"=>$auction_id
	));
	
	$get_from_archive = $get_from_archive->fetch(PDO::FETCH_ASSOC);
	if(empty($get_from_archive))
		return null;
		
		return unserialize($get_from_archive['Data']);
	}
	/**
	 * Metoda pobiera niezakończone aukcje i zaznacza ich koniec. Dla licytacji wyłania zwycięzców. Dla CRONa
	 * @return TRUE
	 */
	public function refresh_auctions(){
		$list_auctions = $this->Data['XVweb']->DataBase->prepare("
		SELECT 
			{AuctionAuctions:*}
		FROM 
			{AuctionAuctions}
		WHERE
			{AuctionAuctions:Enabled} = 1
		AND
			{AuctionAuctions:End} < NOW()
		");
		
		$list_auctions->execute();
		$list_auctions  = $list_auctions->fetchAll(PDO::FETCH_ASSOC);
		foreach($list_auctions as $auction){
			if($auction['Type'] == "auction" || $auction['Type'] == "'both" ){
				$auction_offers = xvp()->get_offers($this, $auction['ID']);
				if(isset($auction_offers[0]) && ($auction_offers[0]['Cost'] >=  $auction['AuctionMin'])){
					$bought_id = xvp()->create_bought($this, $auction['ID'], $auction_offers[0]['User'], $auction['Seller'], $auction['Type'], $auction_offers[0]['Cost'],  $auction_offers[0]['Pieces'], $auction['Title'], $auction['Thumbnail']);
				}
			}
			xvp()->end_auction($this, $auction['ID'], false);
			
		}
		
		return true;
	}
	
	/**
	 * Metoda aktulizuje ceny dla aukcji holenderskich. Dla CRONa, najlepiej co pare minut.
	 * @param $auction_id INT - ID aukcji. Domyślnie false, co oznacza update wszystkich aukcji.
	 * @return TRUE
	 */
	public function update_dutch_auctions($auction_id = false){
		$by_time = "SECOND";
		$this->Data['XVweb']->DataBase->pquery('UPDATE {AuctionAuctions} SET {AuctionAuctions:BuyNow} = ({AuctionAuctions:Auction} - ((({AuctionAuctions:Auction} - {AuctionAuctions:AuctionMin})/TIMESTAMPDIFF('.$by_time.', {AuctionAuctions:Start}, {AuctionAuctions:End}))*(TIMESTAMPDIFF('.$by_time.', {AuctionAuctions:Start}, NOW())))) WHERE {AuctionAuctions:Type} = "dutch"
			'.($id !== false && is_numeric($id) ? ' AND {AuctionAuctions:ID} = "'.$auction_id.'" ' : '').'
		');
	return true;
	}
	/**
	 * Czyszczenie danych aukcji - z AuctionAuctions oraz AuctionSessions
	 * @param $auction_id INT - ID aukcji. Domyślnie false, co oznacza update wszystkich aukcji.
	 * @return TRUE
	 */
	public function clear_auction_data($auction_id){
		$delete_auction = $this->Data['XVweb']->DataBase->prepare('DELETE FROM {AuctionAuctions} WHERE {AuctionAuctions:ID} = :id LIMIT 1 ;');
		$delete_auction->execute(array(
			":id" => $auction_id
		));	
		
		$delete_session = $this->Data['XVweb']->DataBase->prepare('DELETE FROM {AuctionSessions} WHERE {AuctionSessions:Auction} = :id LIMIT 1 ;');
		$delete_session->execute(array(
			":id" => $auction_id
		));
	return true;
	}
	
	/**
	 * Pobieranie statystyk dla użytkownika
	 * @param $user String - nazwa użytkownika
	 * @return ARRAY
	 */
	public function get_user_stats($user){
		$stats_query = $this->Data['XVweb']->DataBase->prepare('SELECT
			(SELECT COUNT(*) FROM  {AuctionOpinions} WHERE {AuctionOpinions:Seller} = :user AND {AuctionOpinions:Type} = :positive ) AS positive,
			(SELECT COUNT(*) FROM  {AuctionOpinions} WHERE {AuctionOpinions:Seller} = :user AND {AuctionOpinions:Type} = :neutral ) AS neutral,
			(SELECT COUNT(*) FROM  {AuctionOpinions} WHERE {AuctionOpinions:Seller} = :user AND {AuctionOpinions:Type} = :negative ) AS negative,
			(SELECT COUNT(*) FROM  {AuctionOpinions} WHERE {AuctionOpinions:Seller} = :user ) AS `all`
 		');
		$stats_query->execute(array(
			":user" => $user,
			":positive" => "positive",
			":neutral" => "neutral",
			":negative" => "negative",
		));
		$stats_data  = $stats_query->fetch(PDO::FETCH_ASSOC);
		$only_good = $stats_data['all']-$stats_data['neutral'];
		if($only_good){
			$stats_data['percent'] = round((($only_good-$stats_data['negative'])/$only_good)*100);
		}else{
			$stats_data['percent'] = 0;
		}
		return $stats_data;
	}
	/**
	 * Sprawdzanie, czy użytkownik ma dostęp do pobrania wiadomości od użytkownika - tylko gdy wygrał aukcje
	 * @param $user STRING - nazwa użytkownika
	 * @param $auction_id INT - id aukcji
	 * @return BOOLEAN
	 */
	public function check_perm_to_get_message($user, $auction_id){
		$check_status = $this->Data['XVweb']->DataBase->prepare("SELECT {AuctionBought:ID} AS ID FROM {AuctionBought} WHERE
			{AuctionBought:User} = :user	AND {AuctionBought:Auction} = :auction_id 
			LIMIT 1;");
		$check_status->execute(array(
			":auction_id" =>$auction_id,
			":user" =>$user
		));
		$check_status = $check_status->fetch();

		if(isset($check_status['ID']))
			return true;
			
		return false;
	}

}

?>