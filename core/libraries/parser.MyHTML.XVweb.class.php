<?php
class ParserMyHTML
{
	/************************************************************************************************/
	const Version = "1.0";
	/************************************************************************************************/
	public $allowedTags = '<h1><h><h2><h3><h4><h5><h6><b><i><a><ul><li><pre><hr><blockquote><img><table><br><button><caption><center><cite><var><code><del><col><colgroup><dd><dl><em><form><input><ins><kbd><label><p><sup><sub><tbody><td><textarea><tfoot><th><thead><tr><tt><u><var><span><strong><font><strike><s><ol><fieldset><legend><nobr><div><php><delphi><cpp><java><java5><css><javascript><code><nohtml><include><vars><file><small>';
	public $stripAttrib = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|onload|onblur|onchange|onfocus|onselect|onsubmit|onunload|absolute|fixed|expression';
	public $text;
	/************************************************************************************************/
	public $SpecialChars= false;
	public $Date=array();
	public $SupportedTags= array("include","php", "delphi","cpp","java","java5","css","javascript", "code", "vars", "file", "[file]", "nohtml", "nobr");
	public $EmotArray = '';
	/************************************************************************************************/
	var $pattern = array(
	"u" =>"<span style=\"text-decoration:underline;\">{match}</span>",
	"b" =>"<span style=\"font-weight: bold;\">{match}</span>",
	"i" =>"<span style=\"font-style: italic;\">{match}</span>",
	"s" =>"<span style=\"text-decoration: line-through;\">{match}</span>",
	"strike" =>"<span style=\"text-decoration: line-through;\">{match}</span>",
	"left" =>"<span style=\"text-align: left;\">{match}</span>",
	"center" =>"<span style=\"text-align: center;\">{match}</span>",
	"right" =>"<span style=\"text-align: right;\">{match}</span>",
	"justify" =>"<span style=\"text-align: justify;\">{match}</span>"
	);
	/************************************************************************************************/
	public function __construct(&$XVweb) {
		$this->Date['XVweb']= &$XVweb;
		$this->Date['Randomize']= rand();
		$this->Date['XVweb']->Date['EngineVars'] = array_merge_recursive((is_array($this->Date['XVweb']->Date['EngineVars'])?$this->Date['XVweb']->Date['EngineVars'] : array()),array(
		"{{version}}"=> constant(get_class($this->Date['XVweb']).'::Version'),
		"{{phpversion}}"=> phpversion(),
		"{{phpos}}"=> PHP_OS,
		"{{artver}}"=> (isset($this->Date['XVweb']->ReadArticleOut['Version']) ? $this->Date['XVweb']->ReadArticleOut['Version'] : "13"),
		"{{artid}}"=> (isset($this->Date['XVweb']->ReadArticleIndexOut['ID']) ? $this->Date['XVweb']->ReadArticleIndexOut['ID'] : "11"),
		"{{arttotalvotes}}"=> (isset($this->Date['XVweb']->ReadArticleIndexOut['AllVotes']) ? $this->Date['XVweb']->ReadArticleIndexOut['AllVotes'] : "0"),
		"{{average}}"=> (isset($this->Date['XVweb']->ReadArticleIndexOut['Votes']) ? $this->Date['XVweb']->ReadArticleIndexOut['Votes'] : "0"),
		"{{artdate}}"=> (isset($this->Date['XVweb']->ReadArticleIndexOut['Data']) ? $this->Date['XVweb']->ReadArticleIndexOut['Data'] : "0000-00-00 00:00:00"),
		"{{artverdate}}"=> (isset($this->Date['XVweb']->ReadArticleOut['Date']) ? $this->Date['XVweb']->ReadArticleOut['Date'] : "0000-00-00 00:00:00"),
		"{{artauthor}}"=> (isset($this->Date['XVweb']->ReadArticleOut['Author']) ? $this->Date['XVweb']->ReadArticleOut['Author'] : "User"),
		"{{counter}}"=> (isset($this->Date['XVweb']->ReadArticleIndexOut['Views']) ? $this->Date['XVweb']->ReadArticleIndexOut['Views'] : 0),
		"{{parserversion}}"=> constant(get_class($this->Date['XVweb']).'::Version'),
		"{{descriptionofchange}}"=> (isset($this->Date['XVweb']->ReadArticleOut['DescriptionOfChange']) ? $this->Date['XVweb']->ReadArticleOut['DescriptionOfChange'] : "None"),
		"{{artverid}}"=> (isset($this->Date['XVweb']->ReadArticleOut['ID']) ? $this->Date['XVweb']->ReadArticleOut['ID'] : 1)

		));
		
		if(is_array($this->Date['XVweb']->Date['EngineFunctions'])){
			foreach($this->Date['XVweb']->Date['EngineFunctions'] as $PLGFunction){
				$this->SupportedTags[] = $PLGFunction['Tag'];
				$this->allowedTags .= '<'.$PLGFunction['Tag'].'>';
				$this->Date['TagsFunctions'][strtolower($PLGFunction['Tag'])] = $PLGFunction;
			}
		}
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	/************************************************************************************************/
	function RepairTidy($html) {
	return $html;
		if(extension_loaded('tidy' )){
			$returned = tidy_repair_string($html, array("show-body-only"=>true, "output-xhtml"=>true), 'UTF8');
			return $returned;
		}
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened) {
			return $html;
		}
		$openedtags = array_reverse($openedtags);
		for ($i=0; $i < $len_opened; ++$i) {
			if (!in_array($openedtags[$i], $closedtags) && (strpos($this->allowedTags, '<'.$openedtags[$i].'>') !==false)){
				$html .= '</'.$openedtags[$i].'>';
			} else {
				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			}
		}
		return $html;
	}
	/************************************************************************************************/
	function OldHtmlToXHTMLFoo($match) {
		if(isset($this->pattern[strtolower($match[1])]))
		return str_replace("{match}", $match[0], $this->pattern[strtolower($match[1])]);
		return $match[0];
	}
	/************************************************************************************************/
	function OldHtmlToXHTML($html) {

		return preg_replace_callback('/<(u|b|i|s|strike|left|center|right|justify)>(.+?)<\/(u|b|i|s|strike|left|center|right|justify)>/si', array($this, "OldHtmlToXHTMLFoo"), $html);
	}
	/************************************************************************************************/
	function strip_tags_except($text, $allowed_tagsHTML, $strip=false) {
		
		if (is_array($allowed_tagsHTML)){
			$allowed_tags =  $allowed_tagsHTML;
		}else{
			$pattern = '/<(.+?)>/si';
			preg_match_all($pattern, $allowed_tagsHTML, $matches);
			$allowed_tags = $matches[1];
		}
		$open = $strip ? '' : '&lt;';
		$close = $strip ? '' : '&gt;';
		preg_match_all('!<\s*(/)?\s*([a-zA-Z]+)[^>]*>!',
		$text, $all_tags);
		array_shift($all_tags);
		$slashes = $all_tags[0];
		$all_tags = $all_tags[1];
		foreach ($all_tags as $i => $tag) {
			if (in_array($tag, $allowed_tags))
			continue;
			$text =
			preg_replace('!<(\s*' . $slashes[$i] . '\s*' .
			$tag . '[^>]*)>!', $open . '$1' . $close,
			$text);
		}
		return $text;
	}

	/************************************************************************************************/
	function PluginFunctions(&$element)
	{
		if(isset($this->Date['TagsFunctions'][$element->tag]['Function']))
		eval($this->Date['TagsFunctions'][$element->tag]['Function']);
	}
	/************************************************************************************************/
	function ChangeEmot($co="", $naco="")
	{
		$co = stripslashes($co);
		return ' <img src="'.$naco.'" title="'.htmlspecialchars($co).'" alt="'.htmlspecialchars($co).'" border="0" /> ';
	}
	/************************************************************************************************/
	function removeEvilTags($source)
	{
		$allowedTagsLocal = $this->allowedTags;
		$source = $this->strip_tags_except($source, $allowedTagsLocal);
		return preg_replace('/<(.*?)>/ie', "'<'.\$this->removeEvilAttributes('\\1').'>'", $source);
	}
	/************************************************************************************************/
	function removeEvilAttributes($tagSource)
	{
		$stripAttribs = $this->stripAttrib;
		return stripslashes(preg_replace("/$stripAttribs/i", 'forbidden', $tagSource));
	}
	/************************************************************************************************/
	function hide_mail($mail)
	{
		$ReturnVar = explode("@", $mail[2]);
		$ReturnVar = $mail[1]."
<script type=\"text/javascript\">   
var    d='".$ReturnVar[1]."', m='@',  s= \"".$ReturnVar[0]."\";
document.write('<a href=\"mailto:'+s+m+d+'\">'+s+m+d+'</a>');
</script>
";
		return $ReturnVar;
	}
	/************************************************************************************************/
	function cut_url($url)
	{
		$url_len = strlen($url);
		if ( $url_len > 50)
		$url = substr($url, 0, 20) . '[...]' . substr($url, $url_len - 20, 20);
		
		return $url;
	}
	/************************************************************************************************/
	function hyperlink($string)
	{
		$patterns[] = '#(?:^|(?<=[][()<>\s]|&gt;|&lt;))(\w+:/{2}.*?(?:[^][ \t\n\r<>")&,\']+|&(?!lt;|gt;)|,(?!\s)|\[])*)#ie';
		$replacements[] = "'<a href=\"$1\">' . cut_url('$1', 70) . '</a>'";
		$patterns[] = '#(?:^|(?<=[][()<>"\'\s]|&gt;|&lt;))(w{3}\.[\w-]+\.[\w.~-]+(?:[^][ \t\n\r<>")&,\']+|&(?!lt;|gt;)|,(?!\s)|\[])*)#ie';
		$replacements[] = "'<a href=\"http://$1\">' . cut_url('$1', 70) . '</a>'";
		$string = preg_replace_callback('#(^|[\n ]|\()([a-z0-9&\-_.]+?@[\w\-]+\.(?:[\w\-\.]+\.)?[\w]+)#i',
		array($this, "hide_mail"), $string);
		$string = preg_replace($patterns, $replacements, $string);
		return $string;
	}
	/************************************************************************************************/
	function EngineVars(&$element){
	echo pq($element)->attr("value");
	exit;
		if(!is_null(pq($element)->attr("value")))
		$varName = pq($element)->attr("value");
		elseif(!is_null(pq($element)->html()))
		$varName = pq($element)->html();
		pq($element)->replaceWith((isset($this->Date['XVweb']->Date['EngineVars']['{{'.$varName.'}}']) ? $this->Date['XVweb']->Date['EngineVars']['{{'.$varName.'}}'] : ""));
	return "";
	}
	/************************************************************************************************/
	public function CommentParse($string){
		$this->Date['Options']['EnablePHP'] = 0;
		$this->Date['Options']['EnableHTML'] = 0;
		return $this->SetText($string)->Parse()->ToHTML();
	}
	/************************************************************************************************/
	public function &set($name, $value){
		$this->Date[$name] = $value;
		return $this;
	}
	/************************************************************************************************/
	function GetIncludeArticle(&$Properies){
			if($this->Date['GIACounter']>20 or !ifsetor($this->Date['Options']['IncludeArticle'], true))
			return "";
			$this->Date['GIACounter'] += 1;
			$ReplaceVars = array();
			foreach(pq($Properies)->attr("*") as $key=>$value)
			$ReplaceVars['{{var:'.$key.'}}'] = $value;
			pq($Properies)->replaceWith(strtr($this->Date['XVweb']->GetOnlyContextArticle(trim(pq($Properies)->html())),$ReplaceVars));
	}
	/************************************************************************************************/
	function GetFile(&$element){
			if($this->Date['GFCounter'] > 100 or ifsetor($this->Date['Options']['DisableFiles'], false)){
				pq($element)->replaceWith("");
				return "";
			}
			
			$this->Date['GFCounter'] += 1;
			
			if(!is_null(pq($element)->attr("id")))
				$FileID = pq($element)->attr("id"); // Pobieranie ID pliku
			
			if(!is_null(pq($element)->attr("file")))
				$FileID= pq($element)->attr("file"); // pobieranie ID pliku z attrybutu file
			
			//pq($element)->removeAttr("file");
			
			$FileID = trim($FileID);
			
			
			if(!is_null(pq($element)->attr("replace")))
				$ReplaceTo = pq($element)->attr("replace"); // z czym zamieniæ
			pq($element)->removeAttr("replace"); // usuniecie niepotrzebnego atrybutu
			
			if(!is_numeric($FileID)){
				pq($element)->replaceWith("Invalid ID File"); // Z³y ID pliku
				return;
			}
			
			if(!isset($this->Date['File'][$FileID])){ // sprawdzanie czy dany plik istnieje w cache
				$this->Date['File'][$FileID] = $this->Date['XVweb']->FilesClass()->GetFile($FileID);
				$this->Date['File'][$FileID]['FileSize'] = $this->Date['XVweb']->Date['FilesClass']->size_comp($this->Date['File'][$FileID]['FileSize']);
			}
			
			$File = &$this->Date['File'][$FileID];
			//Generowanie info o pliku
			$File['Link'] = $this->Date['XVweb']->Date['UrlSite'].'File/'.$File['ID'].'/'.$File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension']);
			$File['HTMLLink'] = "<a href='".$this->Date['XVweb']->Date['UrlSite'].'File/'.$File['ID'].'/'.$File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension'])."'>".$File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension']).'</a>';
			$File['Name'] = $File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension']);
			if($File['Extension'] == "zip")
				$File['StructureZIP'] =  htmlspecialchars($this->Date['XVweb']->Date['FilesClass']->GetStructureZIP($GLOBALS['UploadDir'].$File['MD5File'].$File['SHA1File']));
				
			if(isset($FileID)){
				if(is_null(pq($element)->attr("get"))){
					pq($element)->attr("get", "Link"); // Jesli nie ma parametru get, to pobierz default: link
					if($element->tagName =="file")
						pq($element)->attr("get", "HTMLLink");
				}
				
				if(!is_null(pq($element)->attr("file")) or pq($element)->attr("id") === true){
						if(empty($ReplaceTo)){
							pq($element)->replaceWith((isset($File[pq($element)->attr("get")]) ? $File[pq($element)->attr("get")] : ""));
						} else{
						$ReplaceWith = $ReplaceTo;
						$ReplaceWTo = (isset($File[pq($element)->attr("get")]) ? $File[pq($element)->attr("get")] : "1");

						pq($element)->replaceWith(str_replace(array($ReplaceWith, $this->encode_full_url($ReplaceWith)), $ReplaceWTo, pq($element)->htmlOuter()));
						/*	foreach(pq($element)->attr("*") as $keyattr=>$valattr){
									pq($element)->attr($keyattr,
										str_replace(
											(!empty($ReplaceTo) ? $ReplaceTo : '{{get}}'),  // 1
											(isset($File[pq($element)->attr("get")]) ? $File[pq($element)->attr("get")] : ""), // 2
											$valattr // 3
										)
									) ;
									
							}*/
						}
						return "";
					}
				if(!is_null(pq($element)->attr("get"))){
				$TOGet =  pq($element)->attr("get");
				pq($element)->removeAttr("get");
				if(isset($File[$TOGet]))
					$TOGet =	$File[$TOGet];
					else 
					$TOGet = "";
					pq($element)->replaceWith($TOGet);
					return "";
				}
			}
		pq($element)->replaceWith("<a href='".$this->Date['XVweb']->Date['UrlSite'].'File/'.$File['ID'].'/'.$File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension'])."'>".$File['FileName'].(empty($File['Extension']) ? '': '.'.$File['Extension']).'</a>');
			return;
	}
	/************************************************************************************************/
	function &Geshi(){
		if(empty($this->Date['Geshi'])){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'geshi.php');
			$this->Date['Geshi'] = new GeSHi();
			$this->Date['Geshi']->set_encoding("utf-8"); 
		}
		return $this->Date['Geshi'];
	}
	/************************************************************************************************/
	public function GeshiText($Code, $Lang){
		if(ifsetor($this->Date['Options']['DisableGeshi'], false))
		return $Code;
		
		$this->Geshi()->set_source($Code);
		$this->Geshi()->set_language($Lang);
		return $this->Geshi()->parse_code();
	}
	/************************************************************************************************/
	public function &SetText($text){
	if(ifsetor($this->Date['Options']['DisableParser'], false)){
		$this->text = ($text);
		return $this;
	}
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'phpQuery'.DIRECTORY_SEPARATOR.'phpQuery.php');
		$this->text = phpQuery::newDocumentPHP($text);
		foreach($this->text['include'] as $element)
		$this->GetIncludeArticle($element);
		
		return $this;
	}
	/************************************************************************************************/
	public function &Parse(){
		if(ifsetor($this->Date['Options']['DisableParser'], false)){
			return $this;
		}
		foreach($this->text['nohtml'] as $element){
			pq($element)->replaceWith(htmlspecialchars(pq($element)->html()));
			}
		
		foreach($this->text['nobr'] as $element){
		
			if(is_null(pq($element)->attr("all"))){
				pq($element)->replaceWith(str_replace(chr(13), 'bs'.($this->Date['Randomize']), pq($element)->html()));
			}else{
				$this->Date['Options']['DisableBreakLine'] = 1;
				pq($element)->replaceWith(pq($element)->html());
				}
			
		}
		
		foreach($this->text['info'] as $element){
		
			if(!is_null(pq($element)->attr("hidden")) && pq($element)->attr("hidden") == "true"){
					pq($element)->replaceWith("");
			}else{
					pq($element)->replaceWith(pq($element)->html());
				}
			
		}
		foreach($this->text['include'] as $element)
			$this->GetIncludeArticle($element);	
		
		foreach($this->text['vars'] as $element)
			$this->EngineVars($element);
		
		
		foreach($this->text['file, *[file]'] as $element)
			$this->GetFile($element);
		
		foreach($this->text['code, php, delphi, cpp, java, java5, javascript, css'] as $element){
				pq($element)->replaceWith($this->GeshiText( pq($element)->php() , (strtolower($element->tagName) == "code" ? pq($element)->attr('lang') : $element->tagName)));
			}
			if(isset($this->Date['TagsFunctions']) && is_array($this->Date['TagsFunctions'])){
				foreach($this->Date['TagsFunctions'] as $PLGTag){
					foreach($this->text[$PLGTag['Tag']] as $element)
						eval($PLGTag['Function']);
				}
			}


		$this->text = $this->text->php();

		
		if(!(ifsetor($this->Date['Options']['EnableHTML'], 0) or ifsetor($this->Date['EnableHTML'], 0)))
		$this->text = $this->removeEvilTags($this->text);

		if(!ifsetor($this->Date['Options']['DisableBreakLine'], 0)){
			//$this->Date['XVweb']->Date['EngineVars']["\n"] = '<br />'; // test mode
		}
		
		$this->Date['XVweb']->Date['EngineVars']['s'.($this->Date['Randomize'])] = '<';
		$this->Date['XVweb']->Date['EngineVars']['e'.($this->Date['Randomize'])] = '>';
		$this->Date['XVweb']->Date['EngineVars']['bs'.($this->Date['Randomize'])] = chr(13);

		$this->text = strtr($this->text, $this->Date['XVweb']->Date['EngineVars']);

		if(!ifsetor($this->Date['Options']['EnablePHP'], 0))
			$this->text = $this->RepairTidy($this->text);
		

		return $this;
	}
	/************************************************************************************************/
	public function ToHTML(){
		return $this->text;
	}
	/************************************************************************************************/
	public function encode_full_url(&$url) {
		$url = urlencode($url); 
		$url = str_replace("%2F", "/", $url); 
		$url = str_replace("%3A", ":", $url); 
		return $url; 
	}
	
}
?>