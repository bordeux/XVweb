<?php
extract($GLOBALS);
//SELECT COUNT(1) AS `Count`, DATE_FORMAT(`date`, '%Y-%m-%d') AS `Date` FROM `xv_articleindex` WHERE  `date` > NOW() - INTERVAL 31 DAY GROUP BY DATE_FORMAT(`date`,'%Y-%m-%d')  ORDER BY `date` ASC LIMIT 31
class XVStatistics
{
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		include_once($RootDir.'plugins/data/gchart/gChart.php');
	}
	public function prepare(){
	$StatsQuery  = 'SELECT 
	(SElECT SUM(`views`) FROM {ListArticles} WHERE 1) as `ArticlesViews`,
	(SElECT COUNT(1) FROM {ListArticles} WHERE {ListArticles:Alias} = "no") as `Articles`,
	(SElECT COUNT(1) FROM {ListArticles} WHERE {ListArticles:Alias} = "yes") as `Alias`,
	(SElECT {Articles:Date}  FROM {Articles} ORDER BY  {Articles:Date} ASC  LIMIT 1) as `FirstArticleDate`,
	(SElECT COUNT(1) FROM {Articles} WHERE  1) as `AllArticles`,
	(SElECT COUNT(1) FROM {Bans} WHERE  1) as `Bans`,
	(SElECT COUNT(1) FROM {Bookmarks} WHERE  1) as `Bookmakrs`,
	(SElECT COUNT(1) FROM {Comments} WHERE  1) as `Comments`,
	(SElECT COUNT(1) FROM {Files} WHERE  1) as `Files`,
	(SElECT SUM({Files:FileSize}) FROM {Files} WHERE  {Files:Owner} = 1) as `FilesSize`,
	(SElECT SUM({Files:FileSize}*{Files:Downloads}) FROM {Files} WHERE  1) as `FilesBandwidth`,
	(SElECT SUM(`downloads`) FROM {Files} WHERE  1) as `FilesFownloads`,
	(SElECT COUNT(1) FROM {Messages} WHERE  1) as `Messagess`,
	(SElECT COUNT(1) FROM {Users} WHERE  1) as `Users`,
	(SElECT COUNT(1) FROM {Votes} WHERE  1) as `Votes`,
	(SElECT COUNT(1) FROM {Votes} WHERE   {Votes:Vote} > 0) as `VotesPlus`,
	(SElECT COUNT(1) FROM {Votes} WHERE   {Votes:Vote} < 0 OR {Votes:Vote} = 0) as `VotesMinus`,
	(SELECT `user` FROM {Users} WHERE 1 ORDER BY {Users:Creation} DESC LIMIT 1) as `LastUsers`';
	
	$this->Date['Stats'] = $this->Date['XVweb']->DataBase->pquery($StatsQuery)->fetchObject();

	return true;
}
	public function &get(){
		return $this->Date['Stats'];
	}
	public function GetStatisticsArticle($LastDays = 31){
		$Statistics = array();
		for($i = 1; $LastDays >= $i; $i++ ){
			$Statistics[date('Y-m-d', strtotime('-'.$i.' day'))] = 0;
		}
		$Result = $this->Date['XVweb']->DataBase->pquery("SELECT COUNT(1) AS `Count`, DATE_FORMAT({ListArticles:Date}, '%Y-%m-%d') AS `Date` FROM {ListArticles} WHERE  {ListArticles:Date} > NOW() - INTERVAL ".$LastDays." DAY GROUP BY DATE_FORMAT({ListArticles:Date},'%Y-%m-%d')  ORDER BY {ListArticles:Date} ASC LIMIT ".$LastDays)->fetchAll();
		foreach($Result as $date)
			$Statistics[$date['Date']] = $date['Count'];
			
		return $Statistics;
	}
	public function TopFiles($limit = 15){
		return $this->Date['XVweb']->DataBase->pquery("SElECT {Files:*} FROM {Files} WHERE  {Files:Owner} = 1 ORDER BY {Files:Downloads} DESC LIMIT ".$limit)->fetchAll();
	}
}
 $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->prepare();
xv_appendCSS($URLS['Site'].'plugins/data/statistics/style.css');
?>
<div id="stat_tab_stats" class="tab" style="display: block; ">
      <table border="0" cellspacing="2">
            <tbody>
                  <tr>
                        <td valign="top">
                              <div id="stat_line_all" class="stats_line line" style="display: block; ">
                                    <h3>Artykuły</h3>
									<?php
									$pie3dChart = new gPie3DChart();
	$Labels = array("Aliasów", "Artykułów");
	$pie3dChart->addDataSet(array($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Alias, $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles));
	$pie3dChart->setLegend($Labels);
	$pie3dChart->setLabels($Labels);
	$pie3dChart->setTitle("Przewaga pomiędzy stronami a przekierowań");
	$pie3dChart->setColors(array("E3F3FF", "2a85b3"));
	$pie3dChart->setDimensions(440, 160);
	?>
                                    
                                    <img src="<?php echo $pie3dChart->getUrl(); ?>">
									
									</div>
                              </td>
                              <td valign="top">
                
                                    <div class="wrap_unfloat">
                                          <ul class="no_bullet toggle_display stat_line" id="xv_table" style="display: block; ">
                                                <li>
                                                      <span class="historical_link">Lista artykułów</span>
                                                      <span class="historical_count"><?php echo number_format($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles) ?></span>
                                                </li>
                                                <li>
                                                      <span class="historical_link">Lista aliasów</span>
                                                      <span class="historical_count"><?php echo number_format($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Alias) ?></span>
                                                </li>
                                                <li>
                                                      <span class="historical_link"><b>Razen stron</b></span>
                                                      <span class="historical_count"><?php 
													  $DaysPage =  ceil((time()-strtotime($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->FirstArticleDate))/86400);
													  $AllPages = $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Alias+$GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles;
													  echo number_format($AllPages) ?></span>
													  
													 <?php echo  round($AllPages/$DaysPage, 3); ?> stron na dzień
                                                </li>
                     
                                          </ul>
                                    </div>
                                    <h3>Best day</h3>
                                    <p>
                                          <strong>1</strong>
                                          hit on January 22, 2011. <a href="" class="details" id="more_clicks">Click for more details</a>
                                    </p>
   
                              </td>
                        </tr>
                  </tbody>
            </table>
      </div>
	  
	  
	  <!--- MODYFIKACJE --->
	  
	  
<div id="stat_tab_stats" class="tab" style="display: block; ">
      <table border="0" cellspacing="2">
            <tbody>
                  <tr>
                        <td valign="top">
                              <div id="stat_line_all" class="stats_line line" style="display: block; ">
                                   
									<?php
									$pie3dChart = new gPie3DChart();
	$Labels = array("Artykułów", "Modyfikacji");
	$pie3dChart->addDataSet(array(($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles), (($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->AllArticles - $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles))));
	$pie3dChart->setLegend($Labels);
	$pie3dChart->setLabels($Labels);
	$pie3dChart->setTitle("Przewaga pomiędzy modyfikacjami a stronami");
	$pie3dChart->setColors(array("E3F3FF", "2a85b3"));
	$pie3dChart->setDimensions(440, 160);

	?>
                                    
                                    <img src="<?php echo $pie3dChart->getUrl(); ?>">
									
									</div>
                              </td>
                              <td valign="top">
                              
                                    <div class="wrap_unfloat">
                                          <ul class="no_bullet toggle_display stat_line" id="xv_table" style="display: block; ">
                                                <li>
                                                      <span class="historical_link">Liczba artykułów</span>
                                                      <span class="historical_count"><?php echo number_format($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles) ?></span>
                                                </li>
                                                <li>
                                                      <span class="historical_link">Liczba modyfikacji</span>
                                                      <span class="historical_count"><?php echo number_format(($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->AllArticles - $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Articles)) ?></span>
                                                </li>
                                                <li>
                                                      <span class="historical_link"><b>Razen stron</b></span>
                                                      <span class="historical_count"><?php 
													  echo number_format(($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->AllArticles)) ?></span>
													  
													 <?php echo  round(($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->AllArticles)/$DaysPage, 3); ?> stron na dzień
                                                </li>
                     
                                          </ul>
                                    </div>
                                    <h3>Best day</h3>
                                    <p>
                                          <strong>1</strong>
                                          hit on January 22, 2011. <a href="" class="details" id="more_clicks">Click for more details</a>
                                    </p>
   
                              </td>
                        </tr>
                  </tbody>
            </table>
      </div>	  
	  
 <!--- Statystyki --->
	  
	  
<div id="stat_tab_stats" class="tab" style="display: block; ">
      <table border="0" cellspacing="2">
            <tbody>
                  <tr>
                        <td valign="top">
                              <div id="stat_line_all" class="stats_line line" style="display: block; ">
                                   
									<?php
									
									$Stats = $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->GetStatisticsArticle(31);

$URLChart = "https://chart.googleapis.com/chart?chs=440x225&chxt=x&chg=20,50&chxr=0,1,31,1&cht=ls&chtt=".urlencode("Statystyki dodanych stron w ciągu 31 dni")."&chd=t:20,80&chco=0077CC&chd=t:".implode("," , $Stats);

?>
                                    
                                    <img src="<?php echo $URLChart; ?>" />
									<br />
									
																		<?php
									$pie3dChart = new gPie3DChart();
	$Labels = array("Aliasów", "Artykułów");
	$pie3dChart->addDataSet($Stats);
	$pie3dChart->setLabels(array_flip($Stats));
	$pie3dChart->setTitle("Przewaga dodanych stron w ciągu 31 dni");
	//$pie3dChart->setColors(array("E3F3FF", "2a85b3"));
	$pie3dChart->setDimensions(440, 160);
	?>
                                    
                                    <img src="<?php echo $pie3dChart->getUrl(); ?>">
									
									</div>
                              </td>
                              <td valign="top">
                              
                                    <div class="wrap_unfloat">
                                          <ul class="no_bullet toggle_display stat_line" id="xv_table" style="display: block; ">
                                                <li style="font-weight:bold">
                                                      <span class="historical_link">Data</span>
                                                      <span class="historical_count">Dodanych stron</span>
                                                </li>
												<?php foreach($Stats  as $date=>$count) { ?>
                                                <li>
                                                      <span class="historical_link"><?php echo $date; ?> </span>
                                                      <span class="historical_count"><?php echo number_format($count) ?></span>
                                                </li>
												<?php } ?>
                     
                                          </ul>
                                    </div>
                                    <h3>Best day</h3>
                                    <p>
                                          <strong>1</strong>
                                          hit on January 22, 2011. <a href="" class="details" id="more_clicks">Click for more details</a>
                                    </p>
   
                              </td>
                        </tr>
                  </tbody>
            </table>
      </div> 

<!--- Statystyki plików --->
	  
	  
<div id="stat_tab_stats" class="tab" style="display: block; ">
<h3>Pliki</h3>
      <table border="0" cellspacing="2">
            <tbody>
                  <tr>
                        <td valign="top">
                              <div id="stat_line_all" class="stats_line line" style="display: block; ">
                                
								<?php
								$TopFiles = $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->TopFiles(15);
								$Labels = array();
								$DataSet = array();
								foreach($TopFiles as $FileInfo){
									$Labels[] = $FileInfo['FileName'].'.'.$FileInfo['Extension'];
									$DataSet[] = $FileInfo['Downloads'];
								}
									$pie3dChart = new gPie3DChart();
	$pie3dChart->addDataSet($DataSet);
	$pie3dChart->setLabels($Labels);
	$pie3dChart->setTitle("Liczba ściągnięć");
	$pie3dChart->setColors(array("4D7797", "485F71", "194262", "80ABCB", "94B3CB"));
	$pie3dChart->setDimensions(440, 160);
	?>
                                    
                                    <img src="<?php echo $pie3dChart->getUrl(); ?>" />
									<br />
								
									
									</div>
                              </td>
                              <td valign="top">
                              
                                    <div class="wrap_unfloat">
                                          <ul class="no_bullet toggle_display stat_line" id="xv_table" style="display: block; ">
                                                <li>
                                                      <span class="historical_link">Ilość plików</span>
                                                      <span class="historical_count"><b><?php echo $GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->Files; ?></b></span>
                                                </li>

                                                <li>
                                                      <span class="historical_link">Rozmiar plików</span>
													  <span class="historical_count"><b><?php echo round($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->FilesSize / 1024 /1024, 2) ; ?> MB</b></span>
                                                </li>  
												<li>
                                                      <span class="historical_link">Zużyty transfer: </span>
													  <span class="historical_count"><b><?php echo round($GLOBALS['XVwebEngine']->InitClass('XVStatistics')->get()->FilesBandwidth / 1024 /1024 / 1024, 2) ; ?> GB</b></span>
                                                </li>
						
                     
                                          </ul>
                                    </div>
                                    <h3>Top 15 plików</h3>
                                        <div class="wrap_unfloat">
                                          <ul class="no_bullet toggle_display stat_line" id="xv_table" style="display: block; ">
										      <li>
                                                      <span class="historical_link"><b>Nazwa</b></span>
													  <span class="historical_count"><b>Ściągnięć</b></span>
                                                </li>  
										  <?php
											$CounterFiles = 0; 
										  foreach($TopFiles as $FileInfo) { $CounterFiles++; ?>
                                                <li>
                                                      <span class="historical_link" style="text-overflow: ellipsis; max-width:30px; overflow: hidden;"><a href="<?php echo $GLOBALS['URLS']['Script'].'File/'.$FileInfo['ID'].'/'; ?>"><?php echo $CounterFiles.'. '.$FileInfo['FileName'].'.'.$FileInfo['Extension']; ?></a></span>
                                                      <span class="historical_count"><?php echo $FileInfo['Downloads']; ?></span>
                                                </li>
											<?php } unset($CounterFiles); ?>
						
                     
                                          </ul>
                                    </div>
   
                              </td>
                        </tr>
                  </tbody>
            </table>
      </div>