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

/**
 * xvpayments 
 * Klasa do zarządzania funduszem użytkownika
 */
class xvpayments {
	/**
	 * Zmienna przechowywująca dane klasy, w szczególności $this->Data['XVweb']
	 */
	var $Data;
	/**
	 * Kontruktor xvpayments
	 * @param $Xvweb XVweb - referencja do obiektu XVweb
	 * @return void
	 */
	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;

		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	/**
	 * Pobierane ilości pieniędzy na koncie użytkownika.
	 * @param $user STRING - nazwa użytkownika
	 * @return INT - kwota w groszach
	 */
	public function get_user_amount($user){
		$payments_sum = $this->Data['XVweb']->DataBase->prepare('SELECT
					SUM({Payments:Amount}) AS Amount
			FROM 
				{Payments}
			WHERE
				{Payments:User} = :user
		');
		$payments_sum->execute(array(
			":user"=> $user
		));
		$payments_sum = $payments_sum->fetch();
		
	return ifsetor($payments_sum['Amount'], 0);
	
	}
	/**
	 * Tworzenie nowej transakcji
	 * @param $user STRING - nazwa użytkownika
	 * @param $amount INT - kwota transakcji - może być dodania lub ujemna
	 * @param $type STRING - typ transakcji
	 * @param $title STRING - tytuł transakcji
	 * @param $info ARRAY - informacje o transakcji
	 * @param $uniqid STRING - unikalny ID transakcji
	 * @param $auction INT - numer licytacji
	 * @return INT - ID transakcji
	 */
	public function add_transaction($user, $amount, $type, $title, $info, $uniqid = null, $auction = null){
	$amount = (int) preg_replace('/[^0-9\-]/i', '', $amount);
	if(is_null($uniqid))
		$uniqid = uniqid();
		
		$payments_add = $this->Data['XVweb']->DataBase->prepare('
			INSERT INTO 
			{Payments} 
				({Payments:ID}, {Payments:Title}, {Payments:Amount}, {Payments:Type}, {Payments:User}, {Payments:Date}, {Payments:Info}, {Payments:Auction}, {Payments:UniqID}) 
			VALUES 
				(NULL, :title, :amount, :type, :user, NOW(), :info, :auction, :uniqid)
				ON DUPLICATE KEY UPDATE {Payments:ID} = {Payments:ID} ;
		');
		$payments_add->execute(array(
			":title"=> $title,
			":amount"=> $amount,
			":type"=> $type,
			":user"=> $user,
			":info"=> serialize($info),
			":auction"=> $auction,
			":uniqid" => $uniqid
		));
		$last_id =  $this->Data['XVweb']->DataBase->lastInsertId();
		$this->update_session($user);
	
	return $last_id;
	}
	/**
	 * Odświeżenie sesji użytkownia, na temat ilości funduszy na koncie
	 * @param $user STRING - nazwa użytkownika
	 * @return TRUE
	 */
	public function update_session($user){
			$user_amount = $this->get_user_amount($user);
		return $this->Data['XVweb']->Session->update_user_session($user, "xv_payments_method_amount", $user_amount);
	}
	/**
	 * Pobierane listy płatności użytkownika
	 * @param $user STRING - nazwa użytkownika
	 * @param $display_options ARRAY - opcje wyświetlania, postać
	 @code
		array(
			"sort" => "ASC" , // do wyboru [ASC, DESC]
			"sortby" => "title" , // do wyboru [title, amount, id, auction, date]
		)
	 @endcode
	 * @param $page INT - aktualna strona
	 * @param $PageLimit INT - limit rekordów na stronę
	 * @return ARRAY - lista płatności wedle {Payments:*}  + (DecAmount - kwota w złotówkach)
	 */
	public function get_payments($user, $display_options = array(), $page = 0, $PageLimit = 30){
		$formLimit = $PageLimit*$page;
		$SortBy = "{Payments:ID} DESC";
		if(!empty($display_options) && isset($display_options['sortby'])){
			$Sort = ($display_options['sort'] == "asc" ? "ASC" : "DESC");
			switch (strtolower($display_options['sortby'])) {
			case "title":
				$SortBy = '{Payments:Title} '.$Sort;
				break;
			case "amount":
				$SortBy = '{Payments:Amount} '.$Sort;
				break;
			case "id":
				$SortBy = '{Payments:ID} '.$Sort;
				break;			
			case "auction":
				$SortBy = '{Payments:Auction} '.$Sort;
				break;	
			case "date":
				$SortBy = '{Payments:Date} '.$Sort;
				break;	
			}
		}
		

		$sql_query =	$this->Data['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{Payments:*} ,
			CAST(({Payments:Amount}/100) AS decimal(10,2)) AS DecAmount
		FROM  
			{Payments}
		WHERE
			{Payments:User} = :user 
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
}

?>