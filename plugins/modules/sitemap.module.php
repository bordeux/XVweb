<?php
class SiteMapXML
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		$this->Date['SiteLinks'] = array();
	}
	public function &Prepare(){
	$this->Date['SiteLinks'] =  $AddFileSQL = $this->Date['XVweb']->DataBase->pquery('SELECT 
		{ListArticles:URL} AS `URL`,
		{ListArticles:Date} AS `Date`,
		{ListArticles:Topic} AS `Topic`
	'.$Select.' FROM {ListArticles} WHERE {ListArticles:Accepted} = "yes" ORDER BY {ListArticles:Date} DESC ;')->fetchAll(PDO::FETCH_ASSOC);
	return $this;
	}
	
	public function get($txt = false){
	global $URLS;
	
	if($txt){
		$result = "";
		foreach($this->Date['SiteLinks'] as $value){
			$result .= $URLS['Script'].$this->Date['XVweb']->URLRepair(substr(str_replace(" ", "_", $value['URL']),1))."\n";
		}
	return $result;
	}
	$result ='<?xml version=\'1.0\' encoding=\'UTF-8\'?>
	<?xml-stylesheet type="text/xsl" href="'.$URLS['Site'].'plugins/data/sitemap/sitemap.xsl"?> 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		foreach($this->Date['SiteLinks'] as $value){
		
		$result .= '
		<url>
			<loc>'.$URLS['Script'].$this->Date['XVweb']->URLRepair(substr(str_replace(" ", "_", $value['URL']),1)).'</loc>
			<lastmod>'.substr($value['Date'], 0, 10).'</lastmod>
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>';
		
		}
		$result .="</urlset>";
		return $result;
	}
}
if(isset($SiteTXT)){
	header ("content-type:  text/plain");
	echo  $GLOBALS['XVwebEngine']->InitClass('SiteMapXML')->Prepare()->get(true);
}else{
	header ("content-type: text/xml");
	echo  $GLOBALS['XVwebEngine']->InitClass('SiteMapXML')->Prepare()->get();
}
?>