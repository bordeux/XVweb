<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_shipment extends xvauction_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
			"caption" => "Koszt przesyłki",
			"input_desc" => "Tytul moze zawierac od 3 do 50 znaków.",
			"caption_desc" => "Koszt przesylki",
			"error" => "Zle dane podales!",
			"methods" => 
"Paczka pocztowa ekonomiczna
Paczka pocztowa priorytetowa
Przesyłka kurierska
List ekonomiczny
List priorytetowy
List polecony ekonomiczny
List polecony priorytetowy
Przesyłka pobraniowa
Przesyłka pobraniowa priorytetowa
Przesyłka kurierska pobraniowa
Odbiór osobisty",
	"column1" => "",
	"column2" => "Metoda przesyłki",
	"column3" => "Koszt wysyłki",
	"column4" => "Dopłata za szt.",

	"detail_enable" => 1,
	"detail_caption" => "Koszt przesylki",
		);
		return ($array);

	}
	
	function quick(&$field){
		return '';
	}

	function advanced(&$field){
		return '';
	}

	function query(&$field){
		return false;
	}
	
	function add_form(&$field, $fail= false){
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? "" : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 
					
					<table id="xva-checkbox-shipment-'.$field['Name'].'">
					<tr style="font-weight:bold;">
						<td style="width: 10px; padding-left: 15px;">'.$field['FieldOptions']['column1'].'</td>
						<td>'.$field['FieldOptions']['column2'].'</td>
						<td style="width: 60px;">'.$field['FieldOptions']['column3'].'</td>
						<td style="width: 60px;" >'.$field['FieldOptions']['column4'].'</t>
					</tr>
					';
					
					$shipment_methods = explode("\n", $field['FieldOptions']['methods']);
						foreach($shipment_methods as $key=>$method){
							$Result .= '<tr>
								<td><input type="checkbox" class="shipment-checkbox" value="true" name="add['.$field['Name'].']['.$key.'][selected]" id="xvacheckbox-'.$key.'"  style="margin: 4px;" '.(ifsetor($_POST['add'][$field['Name']][$key]['selected'], "false") == "true" ? ' checked="checked" ' : '').'/></td>
								<td><label for="xvacheckbox-'.$key.'">'.trim($method).'</label></td>
								<td><input class="shipment-hide" pattern="((([0-9]){0,4})|(([0-9]){0,4}(\.)([0-9]){2}))" type="text"  value="'.(ifsetor($_POST['add'][$field['Name']][$key]['cost'], "false") == "false" ? '0.00' : $_POST['add'][$field['Name']][$key]['cost']).'"  name="add['.$field['Name'].']['.$key.'][cost]" ></td>
								<td><input class="shipment-hide" pattern="((([0-9]){0,4})|(([0-9]){0,4}(\.)([0-9]){2}))" type="text" class="shipment-hide" value="'.(ifsetor($_POST['add'][$field['Name']][$key]['surcharge'], "false") == "false" ? '0.00' : $_POST['add'][$field['Name']][$key]['surcharge']).'" name="add['.$field['Name'].']['.$key.'][surcharge]" ></td>
							</tr>';
						}
						
				$Result .=	'</table>
				
				'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
				
				'.($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
				</div>
					<div class="clear"></div>
					<script type="text/javascript">
						$(function(){

							$("#xva-checkbox-shipment-'.$field['Name'].'").find(".shipment-checkbox").change(function(){
								if($(this).is(":checked")){
									$(this).parents("tr").find(".shipment-hide").show();
								}else{
									$(this).parents("tr").find(".shipment-hide").hide();
								}
							}).change();
						
						});
					</script>
				</div>	';
	return $Result;
	}
	public function valid(&$field){
		if(!isset($_POST['add'][$field['Name']]))
			return false;
		if(!is_array($_POST['add'][$field['Name']]))
			return false;
			$pettern = "/^((([0-9]){0,4})|(([0-9]){0,4}(\.)([0-9]){2}))$/";
		foreach($_POST['add'][$field['Name']] as $key=>$val){
			if(!is_numeric($key))
				return false;
				
			if(ifsetor($val['selected'], "false") == "true"){
				if (!@preg_match($pettern  ,$val['surcharge']) || !@preg_match($pettern  , $val['cost']))
					return false;
			}
		
		}
		return true;
		
	}
	public function insert(&$field, $auction_id){
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$shipment_array = array();
		
		foreach($_POST['add'][$field['Name']] as $key=>$val){
			if(ifsetor($val['selected'], "false") == "true"){
				$cost = empty($val['cost']) ? 0 : $val['cost'];
				$surcharge = empty($val['surcharge']) ? 0 : $val['surcharge'];
				$shipment_array[$key] = array($cost*100, $surcharge*100);
			}
		
		}
		
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  serialize($shipment_array),
				":fieldID" => $field['ID']
			));
	return true;
	}
	public function remove_filter(&$field){
		return null;
	}
	public function detail($field, $val){
	if(!$field['FieldOptions']['detail_enable'])
		return null;
		$shipment_methods = explode("\n", $field['FieldOptions']['methods']);
		
		$options = unserialize($val['Val']);
		$table = "<table>";
		foreach($options as $key=>$val){
		$table .= "<tr>
			<td style='padding-right: 15px;'>".$shipment_methods[$key]."</td>
			<td>".number_format($val[0]/100, 2, '.', ' ')." ".xvLang('xca_coin_type')."</td>
		</tr>" ;
		}
		$table .= "</table>";
		return array(
		"caption" => ifsetor($field['FieldOptions']['detail_caption'], '') ,
		"val" =>  $table,
		);
	}
}

?>