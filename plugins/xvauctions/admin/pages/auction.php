<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

class XV_Admin_xvauctions_auction{
	var $style = "height: 500px; width: 60%;";
	var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
	var $URL = "XVauctions/Auctions/";
	var $content = "";
	var $id = "xva-auction-window";
	var $title = "Edit Auction";
	var $Date;
	public function __construct(&$XVweb){
		global $PathInfo;
		$auction_id =(int) strtolower($XVweb->GetFromURL($PathInfo, 5));

		$this->title = "Edit Auction ID: ".$auction_id;
		$this->content = '<div class="xva-auction-edit-result">
		<table style="width: 100%;">
			<tr>
				<td style="width: 60%">'.$this->edit_auction($XVweb, $auction_id).'</td>
				<td>
					'.$this->end_auction($XVweb, $auction_id).'
					'.$this->move_to_archive($XVweb, $auction_id).'
					'.$this->delete_auction($XVweb, $auction_id).'
				</td>
			</tr>
		</table>
		</div>
		';
		$this->URL = "XVauctions/Auction/".$auction_id.'/';
		$this->id = "xva-auction-window-".$auction_id;
		$this->icon = $GLOBALS['URLS']['Site'].'admin/data/xvauctions/icons/auction.png';
		
		if(!empty($_POST)){
			exit($this->content );
		}
	}
	
	public function delete_auction(&$XVweb){
	global $URLS,$xva_wiki_page;
		return '<fieldset>
						<legend>Delete from database [<a href="'.$xva_wiki_page.'Delete_from_database" target="_blank">?</a>]</legend>
						<form action="'.$URLS['Script'].'Administration/Get/XVauctions/Auction/'.$auction_id.'/?mode=delete" method="post" class="xv-form" data-xv-result=".xva-auction-edit-result">
							<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
							<input type="submit" value="Delete from database" />
						</form>
					</fieldset>';
	}
	
	public function move_to_archive(&$XVweb, $auction_id){
	global $URLS, $xva_wiki_page;
	$result = '';
	if(ifsetor($_GET['mode'], '') == "move_to_archive"){
		include_once(ROOT_DIR.'/plugins/xvauctions/libs/class.xvauctions.php');
		$XVauctions = &$XVweb->InitClass("xvauctions");
		$result = xvp()->move_auction_to_archive($XVauctions, $auction_id);
		if($result){
			$result = '<div class="success">Moved to the archive</div>';
		}else{
			$result = '<div class="error">Error: You can\'t move this auction to archive - meybe is active</div>';
		}
	}
		return '<fieldset>
						<legend>Move to archive [<a href="'.$xva_wiki_page.'Move_to_archive" target="_blank">?</a>]</legend>
						'.$result.'
						<form action="'.$URLS['Script'].'Administration/Get/XVauctions/Auction/'.$auction_id.'/?mode=move_to_archive" method="post" class="xv-form" data-xv-result=".xva-auction-edit-result">
							<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
							<input type="submit" value="Move to archive" />
						</form>
					</fieldset>';
	}
	public function end_auction(&$XVweb, $auction_id){
	global $URLS, $xva_wiki_page;
	$result = '';
	if(ifsetor($_GET['mode'], '') == "end_auction"){
		include_once(ROOT_DIR.'/plugins/xvauctions/libs/class.xvauctions.php');
		$XVauctions = &$XVweb->InitClass("xvauctions");
		$result = xvp()->end_auction($XVauctions, $auction_id, true);
		if($result){
			$result = '<div class="success">Auction finished</div>';
		}else{
			$result = '<div class="error">Error: You can\'t end this auction</div>';
		}
	}
		return '<fieldset>
						<legend>Finish auction [<a href="'.$xva_wiki_page.'Finish_auction" target="_blank">?</a>]</legend>
							'.$result.'
						<form action="'.$URLS['Script'].'Administration/Get/XVauctions/Auction/'.$auction_id.'/?mode=end_auction" method="post" class="xv-form" data-xv-result=".xva-auction-edit-result" >
							<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
							<input type="submit" value="Finish auction now!" />
						</form>
					</fieldset>';
	}
	public function edit_auction(&$XVweb, $auction_id){
		include_once($GLOBALS['XVwebDir'].'libraries/formgenerator/formgenerator.php');
		$form=new Form(); 
		$form->set("title", "Edit Auction");
		$form->set("name", "xva_auction_form");        
		$form->set("linebreaks", false);       
		$form->set("errorBox", "error");    
		$form->set("class", " xv-form");            
		$form->set("attributes", " data-xv-result='.xva-auction-edit-result' ");     
		$form->set("errorClass", "error");       
		$form->set("divs", true);    
		$form->set("action",$GLOBALS['URLS']['Script'].'Administration/Get/XVauctions/Auction/'.$auction_id.'/?mode=edit');
		$form->set("errorTitle", $Language['Error']);    
		$form->set("errorPosition", "before");		
		$form->set("submitMessage", "Zapisano");
		$form->set("showAfterSuccess", true);
		$form->JSprotection($XVweb->Session->GetSID());
		$form_html = $form->display(xvLang("Save"), "xva_auction_submit", false);
		$result=($form->getData());
		
		if($result){
			$form_html = "<div class='success'>Saved</div>".$form_html;
		}
		
		$form_html = '<div class="xva-auction-form">'.$form_html.'</div>';
	return $form_html;
	}
}

?>