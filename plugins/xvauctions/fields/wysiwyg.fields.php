<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_wysiwyg extends xvauction_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function options(){
		$array = array(
			"caption" => "Descripion",
			"input_desc" => "Here you can use HTML tags",
			"error" => "Wrong data!",
			"show_templates" => "1",
		);
		return ($array);

	}
	
	function quick(){
		return "";
	}

	function advanced(){
		return '';
	}

	function query(){
		return null;
	}
	
	function add_form($field, $fail=false){
	global $URLS;
	xv_append_js($URLS['Site'].'plugins/xvauctions/tinymce/jscripts/tiny_mce/jquery.tinymce.js', "tinymce");
	xv_append_js($URLS['Site'].'plugins/xvauctions/tinymce/tinymce.js', "tinymce_js");
	
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<b>'.$field['FieldOptions']['caption'].' </b>
					<hr />
					<div class="xvauction-templates">
						<a href="#" class="xvauction-templates-show">Show free templates</a>
					</div>
';
					
					$Result .= "<textarea name='add[".$field['Name']."]'  style='width: 100%; min-height: 500px;' class='tinymce'>".htmlspecialchars($_POST['add'][$field['Name']])."</textarea>";

				$Result .=	($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
					'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid($field){
		return true;
	}
	public function convert_html($html){
		global $URLS;
		/*
	$config = HTMLPurifier_Config::createDefault();
	$config->set('Core.Encoding', 'UTF-8');
	$config->set('HTML.Doctype', 'XHTML 1.1');
	$config->set('HTML.Allowed', '*[style|alt|title|src|href|height|width|cellspacing|cellpadding|border|colspan|background|bgcolor|align|valign|shape|coords|usemap],h1,h2,h3,h4,h5,h6,b,i,a,ul,li,ol,pre,hr,blockquote,img,table,td,tr,th,caption,br,center,col,colgroup,fieldset,legend,dd,dl,sub,sup,u,span,strong,font,strike,s,div');
	$config->set('CSS.AllowedProperties', 'margin,width,height,min-width,min-height,max-height,max-width,text-decoration,color,backgrond,font-size,display,font-family,font-size,font-weight,line-height,list-style-image,list-style-position,list-style-type,margin-bottom,margin-left,margin-right,margin-top,padding-bottom,padding-left,padding-right,padding-top,padding,text-align,visibility');
	$config->set('URI.Base', $GLOBALS['URLS']['Site']);
	$config->set('Attr.EnableID', true);


	$purifier = new HTMLPurifier($config);
*/
		include_once(ROOT_DIR.'plugins/xvauctions/libs/htmlpurifier/HTMLPurifier.auto.php');
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Attr.EnableID', true);
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
		$config->set('HTML.TidyLevel', 'heavy');
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('Attr.IDPrefix', 'auction_');
		$config->set('HTML.TargetBlank', true);
		$config->set('HTML.SafeIframe', true);
		$config->set('URI.MakeAbsolute', true);
		$config->set('URI.Base', $URLS['Site']);
		$config->set('URI.SafeIframeRegexp','%^(http|https|ftp)://(www\.|)(youtube.com/embed/|player.vimeo.com/video/|dailymotion.com/embed/)%');
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($html);
	}
	public function insert($field, $auction_id){

	
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionTexts} ({AuctionTexts:Auction}, {AuctionTexts:Name}, {AuctionTexts:Text}) VALUES (:auctionID , :name, :text );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":name" =>  $field['Name'],
				":text" => $this->convert_html($_POST['add'][$field['Name']])
			));
		
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  $field['Name'],
				":fieldID" => $field['ID']
			));
			
	return true;
	}
	public function remove_filter(&$field){
		return null;
	}
	public function detail($field){
		
		return null;
	}
	
	public function clear_data($field, $auction_id){
		$delete_query = $this->XVweb->DataBase->prepare('DELETE FROM {AuctionValues} WHERE {AuctionValues:IDS} = :fieldID AND {AuctionValues:Auction} =  :auctionID ;');
		$delete_query->execute(array(
			":auctionID" => $auction_id,
			":fieldID" =>  $field['ID'],
		));		
		$delete_query = $this->XVweb->DataBase->prepare('DELETE FROM {AuctionTexts} WHERE {AuctionTexts:Name} = :name AND {AuctionTexts:Auction} =  :auctionID ;');
		$delete_query->execute(array(
			":auctionID" => $auction_id,
			":name" =>  $field['Name'],
		));
	return true;
	}
}

?>