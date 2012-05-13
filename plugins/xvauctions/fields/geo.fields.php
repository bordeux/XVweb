<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_geo extends xvauction_fields {
var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function options(){
		$array = array(
		"caption" => "Adres: ",
		"quick_caption" => "Miejsce ",
		"input_description" => "Liczba może zawierać od 0 do 50 znaków.",
		"caption_description" => "Change",
		"error" => "Zle podales adres!",
		
		"defaultLat" => "52.173931692568",
		"defaultLng" => "18.8525390625",
		"required" => "1",
		"detail_caption" => "Caption",
		"detail_enable" => 0,
		"detail_show_map" => 0,
		);
		return ($array);

	}
	
	function quick(&$field){
		$Result = "
			<div class='auction-search-quick-item'>
				<fieldset>
					<legend><label for='".$field['Name']."_city'>".$field['FieldOptions']['quick_caption']."</label></legend>
				od <input type='text' class='xva-pick-map' style='width:70px' value='".ifsetor( $_GET[$field['Name'].'_city'] ,'')."' value='' name='".$field['Name']."_city'id='".$field['Name']."_city' data-lnt='#".$field['Name']."_lnt' data-lng='#".$field['Name']."_lng'>
				<input type='hidden' value='".ifsetor( $_GET[$field['Name'].'_lnt'] ,'')."' name='".$field['Name']."_lnt' id='".$field['Name']."_lnt' />
				<input type='hidden' value='".ifsetor( $_GET[$field['Name'].'_lng'] ,'')."' name='".$field['Name']."_lng' id='".$field['Name']."_lng' /> 
				do : <input type='number' style='width: 40px;' min='1' name='".$field['Name']."_to'  value='".ifsetor( $_GET[$field['Name'].'_to'] ,'10')."' /> km
				</fieldset>
			</div>
			
		".'<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/data/js/jquery.pickermap.js"></script>';
		return $Result;
	}

	function advanced($field){
		return null;
	}

	function query($field){
		$UniqID = uniqid();
		if(strlen($_GET[$field['Name'].'_city']) < 1 || strlen($_GET[$field['Name'].'_lnt']) < 3 || strlen($_GET[$field['Name'].'_lng']) < 3 || !is_numeric($_GET[$field['Name'].'_to'])){
			unset($_GET[$field['Name'].'_lnt']);
			unset($_GET[$field['Name'].'_lng']);
			unset($_GET[$field['Name'].'_to']);
			unset($_GET[$field['Name'].'_city']);
			return null;
		}
		
		$ExecuteArray = array();
		$Result = '(f.{AuctionFields:Name} = :'.$UniqID .'FieldName ';
							$ExecuteArray[':'.$UniqID .'FieldName'] = $field['Name'];
						
			$Result .= ' AND (GLength(GeomFromText(CONCAT("LINESTRING(", SUBSTRING_INDEX(  v.{AuctionValues:Val}  ,  "|", 1 ) , "," , :'.$UniqID .'lnt , " ", :'.$UniqID .'lng, ")")))) <  :'.$UniqID .'FieldValFrom/69.1/1.6 )';
			$ExecuteArray[':'.$UniqID .'lnt'] = $_GET[$field['Name'].'_lnt'];
			$ExecuteArray[':'.$UniqID .'lng'] = $_GET[$field['Name'].'_lng'];
			$ExecuteArray[':'.$UniqID .'FieldValFrom'] = $_GET[$field['Name'].'_to'];
		
			return array($Result, $ExecuteArray);
		}
	function add_form($field, $fail= false){
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
			 	<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_description'] == "" ? : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_description'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 
					<input id="addresspicker_map-'.$field['Name'].'" name="add['.$field['Name'].'][adress]" placeholder="&lt;street&gt;, &lt;area-code&gt; &lt;city&gt;, &lt;country&gt;" value="'.ifsetor($_POST['add'][$field['Name']]['adress'], "").'" />
					</div>
					<div style="clear:both;" ></div>
							<div style="padding:20px;">
								<div style="float:left; width: 300px;">
									<table>
												
										<tr>
											<td><label>Locality: </label></td>
											<td><input id="locality-'.$field['Name'].'" name="add['.$field['Name'].'][locality]"  value="'.ifsetor($_POST['add'][$field['Name']]['locality'], "").'" readonly="readonly"></td>
										</tr>										
										<tr>
											<td><label>Country: </label></td>
											<td><input id="country-'.$field['Name'].'" name="add['.$field['Name'].'][country]"  value="'.ifsetor($_POST['add'][$field['Name']]['country'], "").'" readonly="readonly"></td>
										</tr>
										<tr>
											<td><label>Lat: </label></td>
											<td><input id="lat-'.$field['Name'].'" name="add['.$field['Name'].'][lat]"  value="'.ifsetor($_POST['add'][$field['Name']]['lat'], "").'" readonly="readonly"></td>
										</tr>									
										<tr>
											<td><label>Lng: </label></td>
											<td><input id="lng-'.$field['Name'].'"  name="add['.$field['Name'].'][lng]"  value="'.ifsetor($_POST['add'][$field['Name']]['lng'], "").'" readonly="readonly"></td>
										</tr>
									</table>
								</div>
								<div style="float:left; width: 500px; height: 300px; " id="map-'.$field['Name'].'">
								
							</div>
								<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
								<script type="text/javascript" src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/data/js/jquery-ui-1.8.16.custom.min.js"></script>
								
								<script type="text/javascript" src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/data/js/jquery.ui.addresspicker.js"></script>
									<script>
										$(function() {
				
											var addresspickerMap = $( "#addresspicker_map-'.$field['Name'].'" ).addresspicker({
												mapOptions: {
													  zoom: 5, 
													  center: new google.maps.LatLng('.ifsetor($_POST['add'][$field['Name']]['lat'], $field['FieldOptions']['defaultLat']).', '.ifsetor($_POST['add'][$field['Name']]['lng'], $field['FieldOptions']['defaultLng']).'), 
													  scrollwheel: true,
													  mapTypeId: google.maps.MapTypeId.ROADMAP
													},
											  elements: {
												map:      "#map-'.$field['Name'].'",
												lat:      "#lat-'.$field['Name'].'",
												lng:      "#lng-'.$field['Name'].'",
												locality: "#locality-'.$field['Name'].'",
												country:  "#country-'.$field['Name'].'"
											  }
											});
											//alert(google.Load);
											var gmarker = addresspickerMap.addresspicker( "marker");
											gmarker.setVisible(true);
											addresspickerMap.addresspicker( "updatePosition");
											
										});
									</script>
							
							</div>
							<div style="clear:both;"></div>
						

						'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
						
						'.($field['FieldOptions']['input_description'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_description'].'</div>' ).'
				
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid($field){
		if(!((int) $field['FieldOptions']['required']))
			return true;
			
		if(strlen(ifsetor($_POST['add'][$field['Name']]['lat'],'')) < 3)
			return false;		
		if(strlen(ifsetor($_POST['add'][$field['Name']]['lng'],'')) < 3)
			return false;	
		if(strlen(ifsetor($_POST['add'][$field['Name']]['locality'],'')) < 3)
			return false;		
		if(strlen(ifsetor($_POST['add'][$field['Name']]['adress'],'')) < 3)
			return false;	
		if(strlen(ifsetor($_POST['add'][$field['Name']]['country'],'')) < 3)
			return false;
		
		return true;
	}
	public function insert($field, $auction_id){
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
			function removesperator($t){
				return str_replace("|", ' ', $t);
			}
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  (removesperator((ifsetor($_POST['add'][$field['Name']]['lat'],'0').' '.ifsetor($_POST['add'][$field['Name']]['lng'],''))).
				'|'.removesperator(ifsetor($_POST['add'][$field['Name']]['adress'],'')).'|'.
				removesperator(ifsetor($_POST['add'][$field['Name']]['locality'],'')).'|'.
				removesperator(ifsetor($_POST['add'][$field['Name']]['country'],''))), 
				":fieldID" => $field['ID']
			));
	return true;
	}
	
		
	public function remove_filter(&$field){
		if(strlen($_GET[$field['Name'].'_city']) < 1 || strlen($_GET[$field['Name'].'_lnt']) < 3 || strlen($_GET[$field['Name'].'_lng']) < 3 || !is_numeric($_GET[$field['Name'].'_to'])){
			unset($_GET[$field['Name'].'_lnt']);
			unset($_GET[$field['Name'].'_lng']);
			unset($_GET[$field['Name'].'_to']);
			return null;
		}
		
		return array(
			"link"=> $this->XVweb->add_get_var(array(
				($field['Name'].'_lnt') => '',
				($field['Name'].'_lng') => '',
				($field['Name'].'_to') => '',
				($field['Name'].'_city') => '',
			), true),
			"caption" => $field['FieldOptions']['caption'].' do '.htmlspecialchars(ifsetor($_GET[$field['Name'].'_to'], '')).' km'
		);
	}
	public function detail($field, $val){
	if(!$field['FieldOptions']['detail_enable'])
		return null;
	if(empty($val['Val']))
		return null;
	$location_info = explode("|", $val['Val']);
		
		return array(
			"caption" => ifsetor($field['FieldOptions']['detail_caption'], '') ,
			"val" => "<span>".htmlspecialchars($location_info[1])."</span>".( ifsetor($field['FieldOptions']['detail_show_map'],  0) == 1 ? '
			<div><iframe style="height: 350px; width: 100%;"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.pl/maps?q='.str_replace(" ", "+", $location_info[1]).'&amp;ie=UTF8&amp;t=m&amp;vpsrc=0&amp;z=14&amp;output=embed"></iframe></div>' : ''),
		);
	}
}

?>