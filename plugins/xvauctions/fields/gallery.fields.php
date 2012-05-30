<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_gallery extends xvauction_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
			"caption" => "Gallery",
			"caption_desc" => "Gallery for auction",
			"error" => "Zle dane podales!",
			"error_filetype" => "Error: Invalid file type! Supported: png, jpg, jpeg, gif",
			"error_upload" => "Error: Upload error!",
			"drag_here" => "Drag your images here",
			"delete" => "Delete",
			"preview" => "Preview",
		);
		
		return ($array);

	}


	function add_form(&$field, $fail= false){
	global $URLS, $XVwebEngine;
	$gallery = $XVwebEngine->Session->Session('xvauctions_gallery');
	
	xv_append_js($URLS['Site'].'admin/data/themes/default/js/html5_uploader.jquery.js');
	xv_append_js($URLS['Site'].'plugins/xvauctions/data/js/gallery_uploader.js');
	xv_append_header("
	<style type='text/css' media='all'>
		.xva-gallery-drop {
			font-size: 30px;
			font-weight:bold;
			text-align:center;
			height: 120px;
			line-height: 110px;
			background: #DFF2BF;
			border-radius: 10px;
			border: 2px dashed #4F8A10;
		}
		.xva-gallery-drop-hover {
			background: yellow;
		}
		.xvauction-gallery-list {
			margin-top:20px;
		}
		.xvauction-gallery-list .xvauction-gallery-file {
			width: 130%;
			min-height: 100px;
			background: #EBF5FF;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			padding: 10px;
			margin-top: 10px;
		}
		.xvauction-gallery-file-img {
			float:left;
			height: 110px;
			width: 110px;
			text-align:center;
			margin-right: 20px;
		}		
		.xvauction-gallery-file-img img {
			height: 100px;
			width: 100px;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
		}
		.xvauction-gallery-file-details {
			
		}
		.xvauction-gallery-file-details h1 {
			font-size: 16px;
			line-height: 16px;
			
		}
		.xvauction-gallery-file-progress {
			margin-left: 120px;
			padding-top: 10px;
		}
		.xvauction-gallery-list-template {
			display: none;
		}
	</style>");
	
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? "" : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 		
						<div class="xva-gallery-drop" data-upload-url="'.$URLS['AuctionsAdd'].'?step=worker&amp;class='.get_class().'">
						  '.$field['FieldOptions']['drag_here'].'
						</div>
						<div class="xvauction-gallery-list-template">
							<div class="xvauction-gallery-file">
								<div class="xvauction-gallery-file-img">
									<img src="'.$URLS['Theme'].'xvauctions/img/no_picture.png" />
								</div>
								<div class="xvauction-gallery-file-details">
									<h1></h1>
										<div>
											Type: <span class="xvauction-gallery-file-details-type"></span>
											File size: <span class="xvauction-gallery-file-details-filesize">0</span>kb
										</div>
										<div class="xvauction-gallery-file-progress">
											<div></div>
										</div>
								</div>
							</div>
						</div>
						<div class="xvauction-gallery-list">';
					if(is_array($gallery[$field['Name']])){
							foreach($gallery[$field['Name']] as $file){
							$Result .= '<div class="xvauction-gallery-file">
									<div class="xvauction-gallery-file-img">
										<a href="'.$URLS['Site'].$file['location'].'" target="_blank"><img src="'.$URLS['Site'].$file['location'].'" /></a>
									</div>
									<div class="xvauction-gallery-file-details">
										<h1>'.$file['file_name'].'</h1>
											<div>
												Type: <span class="xvauction-gallery-file-details-type">'.$file['file_type'].'</span>
												File size: <span class="xvauction-gallery-file-details-filesize">'.($file['fle_size']/1024).'</span>kb
											</div>
											<div class="xvauction-gallery-file-info">
												<a href="'.$URLS['AuctionsAdd'].'?step=worker&amp;class='.get_class().'&amp;delete='.urlencode($file['file_new_name']).'" class="xvauction-gallery-file-delete"  target="_blank">'.$field['FieldOptions']['delete'].'</a> <a href="'.$URLS['Site'].$file['location'].'" target="_blank">'.$field['FieldOptions']['preview'].'</a>
										</div>
									</div>
							</div>';
							}
						}
						
						
					$Result .=	'</div>
					</div>

	
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	
	public function valid(&$field){
		return true;
	}
	public function insert(&$field, $auction_id){
	global $XVwebEngine;
	$gallery = $XVwebEngine->Session->Session('xvauctions_gallery');
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  count($gallery[$field['Name']]),
				":fieldID" => $field['ID']
			));
			
		
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionGallery} 
			({AuctionGallery:Field} , {AuctionGallery:Auction}, {AuctionGallery:FileName}, {AuctionGallery:FileSize}, {AuctionGallery:FileType} , {AuctionGallery:FileNewName}     ) 
		VALUES 
			(:field, :auction, :filename, :filesize, :filetype, :newname)
		;');
					
		foreach($gallery[$field['Name']] as $file){
			$insert_query->execute(array(
				":field" => $field['ID'],
				":auction" => $auction_id,
				":filename"=>$file['file_name'],
				":filesize"=>$file['file_size'],
				":filetype"=>$file['file_type'],
				":newname"=>$file['file_new_name'],

			));
		}

	return true;
	}
		
	public function clear_data($field, $auction_id){
		$delete_query = $this->XVweb->DataBase->prepare('DELETE FROM {AuctionValues} WHERE {AuctionValues:IDS} = :fieldID AND {AuctionValues:Auction} =  :auctionID ;');
		$delete_query->execute(array(
			":auctionID" => $auction_id,
			":fieldID" =>  $field['ID'],
		));		
		$delete_query = $this->XVweb->DataBase->prepare('DELETE FROM {AuctionGallery}  WHERE {AuctionGallery:Field} = :field AND {AuctionGallery:Auction} =  :auctionID ;');
		$delete_query->execute(array(
			":auctionID" => $auction_id,
			":field" =>  $field['ID'],
		));
	return true;
	}


	public function worker($field, $auction_id = null){
		global $URLS, $XVwebEngine;
		
		$gallery = $XVwebEngine->Session->Session('xvauctions_gallery');
		if(isset($_GET['delete'])){
			foreach($gallery[$field['Name']] as $key=>$val){
				if($_GET['delete'] == $val['file_new_name']){
					@unlink(ROOT_DIR.$val['location']);
					unset($gallery[$field['Name']][$key]);
					echo "ok";
				}
			
			}
			$XVwebEngine->Session->Session('xvauctions_gallery', $gallery);
			exit;
		}
		$files_dir = ROOT_DIR.'plugins/xvauctions/gallery/'.$field['Name'];
		if (!is_dir($files_dir)) {
			mkdir($files_dir);
		}
		if(empty($_FILES)){
			echo "<div class='error'>Error: file not send!</div>";
			exit;
		}
		foreach ($_FILES["upload"]["error"] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["upload"]["tmp_name"][$key];
					$new_file_name = md5_file($tmp_name);
					$file_extension = strtolower(pathinfo($_FILES["upload"]["name"][$key], PATHINFO_EXTENSION));
					if(!in_array($file_extension, array("png", "jpg","jpeg", "gif"))){
						echo "<div class='error'>".$field['FieldOptions']['error_filetype']."</div>";
					exit;
					}
					move_uploaded_file($tmp_name, $files_dir.'/'.$new_file_name.'.'.$file_extension);
					$url_to_orginal_file = $URLS['Site'].'plugins/xvauctions/gallery/'.$field['Name'].'/'.$new_file_name.'.'.$file_extension;
					$gallery[$field['Name']][] = array(
						"location"=> 'plugins/xvauctions/gallery/'.$field['Name'].'/'.$new_file_name.'.'.$file_extension,
						"file_name" => $_FILES["upload"]["name"][$key],
						"file_new_name" => $new_file_name.'.'.$file_extension,
						"file_size" => $_FILES["upload"]["size"][$key],
						"file_type" => $_FILES["upload"]["type"][$key],
					);
					 $XVwebEngine->Session->Session('xvauctions_gallery', $gallery);
					 
					echo "<div class='xvauction-gallery-file-info'>
						".
						'<a href="'.$URLS['AuctionsAdd'].'?step=worker&amp;class='.get_class().'&amp;delete='.urlencode($new_file_name.'.'.$file_extension).'" class="xvauction-gallery-file-delete" target="_blank">'.$field['FieldOptions']['delete'].'</a>'
						." <a href='{$url_to_orginal_file}' target='_blank'>".$field['FieldOptions']['preview']."</a>
					</div>";
					exit;
				}
			}
			echo "<div class='error'>".$field['FieldOptions']['error_upload']."</div>";
		exit;
	}
	public function footer($field, $val, $auction_id){
	global $URLS;
	$select_query = $this->XVweb->DataBase->prepare('SELECT {AuctionGallery:*} FROM {AuctionGallery}  WHERE {AuctionGallery:Field} = :field AND {AuctionGallery:Auction} =  :auctionID ;');
	$select_query->execute(array(
			":auctionID" => $auction_id,
			":field" =>  $field['ID'],
		));
	$gallery_files = $select_query->fetchAll(PDO::FETCH_ASSOC);
		if(empty($gallery_files)){
			return null;
		}
		xv_append_header("
	<style type='text/css' media='all'>
		.xvauction-gallery {
			min-height: 100px;
			margin-top: 20px;
			text-align:center;
		}
		.xvauction-gallery > a {
			padding: 10px;
			width: 130px;
			height: 100px;
			text-align:center;
		}
		.xvauction-gallery > a > img {
			height: 100px;
		}
	</style>
	<link rel='stylesheet' href='".$URLS['Site']."plugins/xvauctions/data/js/slimbox/css/slimbox2.css' type='text/css' media='screen' />
	<script type='text/javascript' src='".$URLS['Site']."plugins/xvauctions/data/js/slimbox/js/slimbox2.js'></script>
	");
	
		$result =  '<div class="xvauction-gallery">
			
		';
		foreach($gallery_files as $file){
			 $file_url = $URLS['Site'].'plugins/xvauctions/gallery/'.$field['Name'].'/'.$file['FileNewName'];
			 $file_th_url = $URLS['Site'].'plugins/xvauctions/gallery/th/base64/height/100/'.base64_encode($file_url).'.jpg';
			$result .= "<a href='{$file_url}' rel='lightbox-photos' target='_blank'><img src='{$file_th_url}' alt='co jest?' /></a>";
		}
		
			$result .='</div>'; 
		return $result;
	}
	public function session($field, $auction_id = null){
		return array("xvauctions_gallery");
	}

}

?>