<?php
if(!isset($NPSConfig)){
	$NPSConfig = array("Category"=>"/Filmy/Online/");
}
class AddVideoMod
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		$this->Date['LastArticles'] = array();
		$this->Date['HTMLMode'] = false;
		$this->Date['Categories'] = "";
		$this->Date['BuildArticle'] = "";
		$this->Date['ArticleLink'] = "";
		
		$this->Date['Options'] = array("Template"=>"news_contents.tpl", "Parse"=>false, "CharsLimit"=>0, "ActualPage"=>(int)$_GET['NewsPage'], "Category"=>"/News/", "EveryPage"=> (int) ifsetor($this->Date['XVweb']->Config("config")->find('config pagelimit news')->text(), 30));
	}
	
	public function SetPrepare(){
	$this->Date['HTMLMode'] = true;

	
	$Links = array("youtube"=>array("http://www.youtube.com/watch?v=wBv7W2n9src"));
	
	foreach($Links  as $key=> $val){
		foreach($val as $linkVideo)
			$this->Date['BuildArticle'] .= '<center><'.$key.'>'.trim($linkVideo).'</'.$key.'></center>'.chr(13);
	}
	$this->Date['BuildArticle'] .= $_POST['addmod']['description'];
	$this->Date['ArticleLink'] = $this->Date['Options']['Category'].$_POST['addmod']['category'].'/'.$_POST['addmod']['title'].'/';
	}
	public function &Prepare($Date= array()){

		$this->Date['Options']= array_merge($this->Date['Options'],$Date);
		if(isset($_GET['AddMod']) && isset($_POST['addmod']))
			$this->SetPrepare($Date);
		
		$Categories = ($this->Date['XVweb']->GetDivisions($this->Date['Options']['Category']));
		foreach($Categories as $Article){
		 $this->Date['Categories'][] =  $Article['Topic'];
		}
		return $this;
		
	}
	public function gethtml(){
	$HTML = '';
	if($this->Date['HTMLMode']){
	$HTML .= '<fieldset>
	<legend>Podgląd</legend>';
	$HTML .= '<div>';
		$this->Date['XVweb']->IncludeParseHTML();
	$HTML .=  ($this->Date['XVweb']->ParserMyBBcode->set("Blocked", false)->SetText($this->Date['BuildArticle'])->Parse()->ToHTML());
	
	$HTML .= '</div>';
	

	$HTML .= '</fieldset>';
	
	$HTML .= '<form action="'.$GLOBALS['URLS']['Script'].'Write/?save=true" method="post">';
	$HTML .= '234234';
	
	$HTML .= '<input type="hidden" name="xv-path" value="'.htmlspecialchars($this->Date['ArticleLink']).'" />';
	$HTML .= '<textarea style="display:none;" name="EditArtPost">'.htmlspecialchars($this->Date['BuildArticle']).'</textarea>';
	$HTML .= '<div style="text-align:center"><input type="submit" value="OK, Wyślij"  style="font-size:16px; font-weight:bold; margin-bottom:20px;"/>';
	
	
	$HTML .= '</form>';
	
	}
	
	$HTML .= '<fieldset>
	<legend>Dodaj film</legend>
	<form action="?AddMod=true" method="post">';
	
	$HTML .='<div class="table">';
	
	$HTML .='<div class="table-row">
		<div class="table-cell">
		Kategoria i tytuł filmu: 
		</div>
		<div class="table-cell">
		<select name="addmod[category]">
		';
	foreach($this->Date['Categories'] as $CatName)
	$HTML .= '<option value="'.$CatName.'">'.$CatName.'</option>'.chr(13);
	
	$HTML .='</select><input type="text" name="addmod[title]" value="'.htmlspecialchars(ifsetor($_POST['addmod']['title'],"")).'"/>
	</div>

	</div>
	';
	
	$HTML .='<div class="table-row">
		<div class="table-cell">
		Linki do playlisty/filmu<br />
		(do youtube, vimeo, kazdy w osobnej lini): 
		</div>
		<div class="table-cell">
			<textarea name="addmod[links]" style="width:300px; height:100px;">'.htmlspecialchars(ifsetor($_POST['addmod']['links'],"")).'</textarea>
		</div>
		</div>';
		$HTML .='<div class="table-row">
		<div class="table-cell">
		Opis filmu: 
		</div>
		<div class="table-cell">
			<textarea name="addmod[description]" style="width:300px; height:100px;">'.htmlspecialchars(ifsetor($_POST['addmod']['description'],"")).'</textarea>
		</div>
		</div>';
		$HTML .='<div class="table-row">
		<div class="table-cell"> 
		</div>
		<div class="table-cell"> 
		<input type="submit" value="Podgląd" style="font-size:16px;" />
		</div>
		</div>';
	
	$HTML .='</div></form></fieldset>';
	
	
	
	return $HTML;
	
	}
}

echo $GLOBALS['XVwebEngine']->InitClass('AddVideoMod')->Prepare($NPSConfig)->gethtml();

?>