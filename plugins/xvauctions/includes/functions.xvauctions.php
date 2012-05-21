<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

/**
 * xvauctions_operations
 * Klasa z przydatnymi funkcjami
 */
class xvauctions_operations {
	/**
	 * Funkcja, która pobiera listę klas, według prefixu
	 * @param $prefix STRING - prefix, którym zaczynają się klasy
	 * @return ARRAY() - lista klas
	 */
	function getClassesByPrefix($prefix){
		$result = array();

		$className = strtolower( $prefix );
		$PrefixLen = strlen($prefix);
		foreach ( get_declared_classes() as $c ) {
			if ( $className == substr(strtolower($c), 0, $PrefixLen) ) {
				$result[] = $c;   
			}
		}

		return $result;
	}
	/**
	 * Pobieranie rodziców kategorii
	 @code
		get_category_parents("/1111/2222/333/444/"); //result array("/1111/", "/1111/2222/", "/1111/2222/333/");
	 @endcode
	 * @param $cats - kategoria
	 * @return STRING
	 */
	function get_category_parents($cats){
		$exploded = explode("/", $cats);
		$ParentsCategories = array();
		foreach($exploded as $cat){
			
			$ParentsCategories[] =  end($ParentsCategories).$cat.'/';
		}
		unset($ParentsCategories[count($ParentsCategories)-1]);
		return $ParentsCategories;
	}
	/**
	 * Pobieranie rodzica kategori
	 @code
	 get_category_parent("/111/222/333/"); //result "/111/222/"
	 @endcode
	 * @param $category STRING - kategoria
	 * @return STRING - rodzic
	 */
	public function get_category_parent($category){
		return str_replace(array("//", "\\/"), '/', dirname($category).'/');
	}
	/**
	 * Usuwa znaki między narodowe, zostawiając te, które są akceptowane w adresie URL
	 * @param $string STRING - adres url
	 * @return STRING
	 */
	function string_to_url($string){
		$string = iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $string); 
		$string = str_replace(' ', '_', $string);
		$string = preg_replace('#[^a-zA-Z0-9_\/]+#', '', $string);
		return $string;
	}
}
?>