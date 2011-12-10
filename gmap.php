<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
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
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}

$MapsID = $XVwebEngine->GetFromURL($PathInfo, 2);
$Command = $XVwebEngine->GetFromURL($PathInfo, 3);



class XV_GMap {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function AddMarker($User, $Data){
	$AddMarker = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {GMap} ( {GMap:Category}, {GMap:Description}, {GMap:URL}, {GMap:Latitude}, {GMap:Longitude}, {GMap:User}) VALUES (:Category, :Desc, :URL, :Lat, :Lon, :User);');
		$AddMarker->execute(array(
				':Category' => $Data['category'],
				':Desc' => "",
				':URL' => $Data['url'],
				':Lat' => $Data['lat'],
				':Lon' => $Data['lng'],
				':User' => $User,
			));
		return false;
	}
	public function getXML($MapsID, $Data){
			$GetArticles = $this->Date['XVweb']->DataBase->prepare('SELECT {GMap:*} FROM  {GMap} 
			WHERE
			'.($MapsID == "All" ? "#" : '').' {GMap:Category} = :MapID  AND
			({GMap:Latitude} BETWEEN :LatStart AND :LatEnd)
			AND
			({GMap:Longitude} BETWEEN :LongStart AND :LongEnd)
			LIMIT 100
			;');
			$GetArticles->execute(array(
				':MapID' => $MapsID,
				':LatStart' => $Data['minlat'],
				':LatEnd' => $Data['maxlat'],
				':LongStart' => $Data['minlng'],
				':LongEnd' => $Data['maxlng'],
			));
			echo '<markers>';
			foreach($GetArticles->fetchAll(PDO::FETCH_ASSOC) as $Poi){
				  echo '<marker ';
				  echo 'id="' . ($Poi['ID']) . '" ';
				  echo 'category="' . ($Poi['Category']) . '" ';
				  echo 'lat="' . $Poi['Latitude'] . '" ';
				  echo 'lng="' . $Poi['Longitude'] . '" ';
				  echo 'url="' .htmlspecialchars($Poi['URL']). '" ';
				  echo 'parsedurl="' .htmlspecialchars(substr(str_replace(" ", '_', $this->Date['XVweb']->URLRepair($Poi['URL'])), 1)). '" ';
				  echo '>';
				  echo htmlspecialchars($Poi['Description']);
				  echo '</marker>';
			}
			echo '</markers>';
	}
}
if(isset($_POST['gmap'])){
	$XVwebEngine->InitClass("XV_GMap")->AddMarker($XVwebEngine->Session->Session('Logged_User'), $_POST['gmap']);
	echo "<div class='success'><h1>Dodano marker</h1></div>";
	exit;
}
header("Content-type: text/xml"); 
$XVwebEngine->InitClass("XV_GMap")->getXML($MapsID, $_GET);
exit;

?>