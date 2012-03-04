<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

/**
 * xvauction_fields
 * Klasa jest szablonem dla pól aukcji. Jeśli chcesz dodać nowy typ pola do formularza, należy w folderze XVweb/xvauctions/fields/
 * utworzyć plik o nazwie NAZWA_POLA.fields.php a w nim utworzyć klasę
 @code
 class xvauction_fields_NAZWA_POLA extends xvauction_fields {
 }
 @endcode
 
 Następnie w klasie podmieniać poniższe metody
 */
class xvauction_fields {
	/**
	 * Tutaj zaznaczamy, jaki typ danych to będzie - potrzebne do optymalizacji bazy danych. Masz do wyboru integer lub string
	 */
	var $Type = "integer";
	/**
	 * Obiekt z klasą XVweb
	 */
	var $XVweb = null;
	/**
	 * Kontruktor. Zapisujemy parametry do klasy, oraz logujemy użycie klasy
	 * @return void
	 */
	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	/**
	 * Tutaj uzupełniamy tablicę według
	 @code
	 array(
		"klucz"=>"wartość"
	 )
	 @endcode
	 Tutaj zapisujemy ustawienia dla poszczególnego pola
	 * @return ARRAY - tablica musi być 1D - jednowymiarowa, asocjacyjna
	 */
	function options(){
		$array = array();
		return ($array);
	}
	/**
	 * Tutaj generujemy input dla formularza, dla mini-wyszukiwarki, która jest po boku strony
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @return STRING - format text/html
	 */
	function quick(&$field){
		return null;
	}
	/**
	 * Tutaj generujemy input dla formularza, dla wyszukiwarki, która jest zaawansowana.
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @return STRING - format text/html
	 */
	function advanced(&$field){
		return null;
	}
	/**
	 * Tutaj generujemy zapytanie SQL dla wyszukiwarki.
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @return ARRAY - musimy zwrócić tablicę dwuelementową w postaci
	 @code
		array(
			"ZAPYTANIE_SQL" , //zapytanie SQL
			array(
				":xvyz" => "tresc", // Parametry, które bedą dodane do execute, w celu ochront przed SQL injection
			)
		)
	 @endcode
	 */
	function query(&$field){
		return null;
	}
	
	/**
	 * Tutaj generujemy input dla formularza dodawania aukcji
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @param $fail BOOLEAN - TRUE oznacza tryb nieprawidłowy, kiedy nie przeszedł walidacji z metodą valid(). W kodzie podświetl input na kolor czerwony, by zasygnalizować użytkownikowi błąd. 
	 * @return STRING - input w postaci text/html. Najlepiej ułożony w styl tego kodu
	 @code
	 return	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					Caption
					<div class="xvauction-add-name-desc">UnderCaption</div>
					</div>
					<div class="xvauction-add-input"> 		
						<input type="textt" name="add['.$field['Name'].']" value="'.htmlspecialchars($_POST['add'][$field['Name']]).'"  />
						'.($fail ? '<div class="xvauction-add-input-error">Bad value</div>'  : '' ).'
						<div class="xvauction-add-input-desc">Input Description</div>
					</div>
					<div class="clear"></div>
				</div>'	;		
	 @endcode
	 */
	function add_form(&$field, $fail= false){
		return null;
	}
	/**
	 * Tutaj sprawdzamy czy dane pole jest prawidłowo uzupełnione.
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @return BOOLEAN - TRUE oznacza wszystko OK, FALSE oznacza zatrzymanie formularza i oczekiwanie na prawidłową wartość
	 */
	public function valid(&$field){
		return true;
	}
	
	/**
	 * Metoda wyłowywana podczas dodawania auckji
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @param $auction_id INT - ID aukcji
	 * @return BOOLEAN
	 */
	public function insert($field, $auction_id){
		return true;
	}
	/**
	 * Metoda wyłowywana podczas wyszukiwania. Są to ikonki filtru. Po naciśnięciu tej ikonki, powinny być usunięte zmienne GET z adres URL z tego pola. (adres pozbawiony parametrów wyszukiwań według tego pola)
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @return ARRAY() - w formacie
	 @code
		return array(
			"link"=> $this->XVweb->AddGet(array(
				($field['Name']) => ''	
			), true), // domyślnie
			"caption" => "Opis : Wartosc"
		)
	 @endcode
	 */
	public function remove_filter(&$field){
		return null;
	}
	
	/**
	 * Metoda wyłowywana na stronie aukcji. Metoda jest odpowiedzialna o sczegóły aukcji - tableka z szczegółami o przedmiocie nad opisem, pod tytułem
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @param $val MIXED - wartość pola
	 * @return ARRAY - tablica w formacie
	 @code
		array(
			"caption" => "caption" ,
			"val" => "value"
		)
	 @endcode
	 */
	public function detail($field, $val){
		return null;
	}
	
	/**
	 * Metoda wyłowywana w trakcjie edycji aukcjii
	 * @param $field ARRAY - Dane według {AuctionFields}, gdzie FieldOptions jest już unserialize
	 * @param $auction_id - ID aucji
	 * @param $auction_info - Informacje o aukcji
	 * @return null - void
	 */
	public function edit_trigger($field, $auction_id, $auction_info){
		return null;
	}
	
	public function clear_data($field, $auction_id){
		$delete_query = $this->XVweb->DataBase->prepare('DELETE FROM {AuctionValues} WHERE {AuctionValues:IDS} = :fieldID AND {AuctionValues:Auction} =  :auctionID ');
		$delete_query->execute(array(
			":auctionID" => $auction_id,
			":fieldID" =>  $field['ID'],
		));
	return true;
	}	
	
	public function worker($field, $auction_id = null){
		
		return true;
	}
	public function footer($field, $val){
	
		return null;
	}
	public function session($field, $auction_id = null){
		return null;
	}
}

?>