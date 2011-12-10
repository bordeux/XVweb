<?php


class SearchClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function Search($String, $ActualPage = 0, $EveryPage =30){
			$LLimit =   0;
			$RLimit = $EveryPage;

			if(!is_numeric($LLimit) or !is_numeric($RLimit))
			return false;
			$match = '`AA`.{Articles:Topic} ,`AA`.{Articles:Contents} ';

			$OneVersion  = 'AND `AA`.{Articles:Version} = `IA`.{ListArticles:ActualVersion}';
			if(!$this->Date['XVweb']->SearchInVersion)
			$OneVersion  = '';
			$LLimit = ($ActualPage*$EveryPage);
			
			$SearchSQL = $this->Date['XVweb']->DataBase->prepare('SELECT  SQL_CALC_FOUND_ROWS
	`AA`.{Articles:Version} as `Version`,
	'.($this->get("noContent") == true ?  '' : '`AA`.{Articles:Contents} as `Contents`,' ).'
	`AA`.{Articles:AdressInSQL} as `AdressInSQL`,
	`AA`.{Articles:Topic} as `Topic`,	
	MATCH('.$match.') AGAINST( :SearchExecute ) AS `Relevance`,
	IA.{ListArticles:URL} as `URL`
FROM 
	{Articles} AS `AA`
INNER JOIN 
	{ListArticles} AS `IA` ON (`AA`.{Articles:AdressInSQL} =  `IA`.{ListArticles:AdressInSQL})
WHERE
MATCH ('.$match.') AGAINST (:SearchExecute)
AND 
	IA.{ListArticles:Accepted} = "yes"
	'.(is_numeric($this->get("SearchExcept")) ?  'AND IA.{ListArticles:ID} <> "'.$this->get("SearchExcept").'" '  :  "").'
'.$OneVersion.'
'.($this->get("Group") == true ?  'GROUP BY `IA`.{ListArticles:AdressInSQL} ' : '' ).'
ORDER BY `Relevance` DESC
LIMIT '.$LLimit.' , '.$EveryPage.''
			);
		
			$SearchSQL->execute(array(
			':SearchExecute' => $String
			));
			$return = $SearchSQL->fetchAll();
			if($this->get("noContent") != true){
				 foreach ($return as $key => $value) {
					$return[$key]['Lenght'] =  strlen($value['Contents']);
					$return[$key]['StrByte'] =  $return[$key]['Lenght']*8;
					$return[$key]['Contents'] = $this->SearchTextExtract($String, $value['Contents']);
				} 
			}
			
			$this->Date['XVweb']->Date['SearchResultCount'] = $this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `SearchCount`;')->fetch(PDO::FETCH_OBJ)->SearchCount;



			return $return;
	}

	var $text_ary = array();

	function BlodSearch($content)
	{
		static $pattern_ary = array();
		static $replacement_ary = array();

		if ( !count($pattern_ary) )
		{
			foreach ( $this->text_ary as $index => $word )
			{
				$pattern_ary[]     = "/\b" . preg_quote($this->text_ary[$index]) . "\b/i";
				$replacement_ary[] = '<span style="font-weight: bold;">\\0</span>';
			}
		}
		return (preg_replace($pattern_ary, $replacement_ary, $content));
	}
	public function set($var, $val){
		return ($this->Date[$var] = $val);
	}
	public function get($var){
		return isset($this->Date[$var]) ? $this->Date[$var] : null;
	}

	function SearchTextExtract($keyword, $content)
	{

		$drop_char_match = array('--', '\'', ',', '@', '\\',);
		$keyword = str_replace($drop_char_match, '', $keyword);
		preg_match_all('/(^| |\+|\-)"(.*?)"/', $keyword, $match_ary);

		foreach ( $match_ary[0] as $word_id => $word )
		{
			$this->text_ary = $word;

			$keyword = str_replace($word, '', $keyword);
		}
		$this->text_ary = array_merge($this->text_ary, array_unique(preg_split('#\s+#', $keyword)));
		for ( $i = 0; $i < count($this->text_ary); $i++ )
		{
			if ( strlen($this->text_ary[$i]) < 3 )
			{
				unset($this->text_ary[$i]);
				continue;
			}
		}


		if ( ($sizeof = sizeof($this->text_ary)) > 5 )
		{
			$sizeof = 5;
		}
		foreach ( $this->text_ary as $index => $word )
		{
			$this->text_ary[$index] = trim(str_replace(array('"', '+', '-'), '', $this->text_ary[$index]));
		}
		$word_countS = count($this->text_ary);
		$keyword = implode(' ', $this->text_ary);
		if ( !$keyword )
		{
			return array(substr(htmlspecialchars($content), 0, 255), 0);
		}
		$content = strip_tags($content);

		$word_count = 0;
		$output = '';

		foreach ( $this->text_ary as $index => $word )
		{
			if($this->text_ary[$index])
			$word_count += substr_count($content, $this->text_ary[$index]);
			$output .= ' ...'.substr($content, stripos($content, $this->text_ary[$index]), (255 / $word_countS)) . '... ';
		}
		//, $word_count)
		
		return $this->BlodSearch($output);
	}


}

?>