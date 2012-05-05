<?php
	if(isset($_GET['uptime'])){
	if(function_exists('sys_getloadavg')){
					$load = sys_getloadavg();
					echo $load[0];
					
	}
	exit;
	}
		$UptimeSQL = $XVweb->DataBase->query("SHOW STATUS LIKE 'Uptime'")->fetch();
		$UptimeSQL = (int) $UptimeSQL['Value']; 
		
		$SQLVersion = $XVweb->DataBase->query("SELECT VERSION() AS 'version';")->fetch();

		$SQLVersion = $SQLVersion['version']; 
		
?>
		<div class="xv-widget-area">
		
		<div class="xv-wid-status">
		<table>
				<tr>
					<td>Server Name</td>
					<td><?php echo $_SERVER['SERVER_NAME']; ?></td>
				</tr>			
				<tr>
					<td>Server IP</td>
					<td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
				</tr>		
				<tr>
					<td>MySQL Uptime</td>
					<td><span class="xv-clock" data-timestamp="<?php echo time()- $UptimeSQL; ?>"><?php echo time()- $UptimeSQL; ?></span></td>
				</tr>
				<tr>
					<td>MySQL Version</td>
					<td><?php echo $SQLVersion; ?></td>
				</tr>	
				<tr>
					<td>PHP Version</td>
					<td><?php echo PHP_VERSION; ?></td>
				</tr>
				<?php 
					if(function_exists('sys_getloadavg')){
					$load = sys_getloadavg();
				?>
				<tr>
					<td>Server Load</td>
					<td><span class="xv-refresh" data-url="<?php echo $GLOBALS['URLS']['Script']; ?>Administration/get/Widgets/Get/status/?wid=13123&name=status&uptime=true&xv-hide=true"><?php echo $load[0]; ?></span>%</td>
				</tr>
				<?php
					}
				?>
				<?php
				$total_space =  disk_total_space("/");
				$free_space = disk_free_space("/");
				$used_space = $total_space- $free_space;
				$used_space_percent = round(($used_space/$total_space)*100);
				?>
				<tr>
					<td>Disk usage</td>
					<td>
					<div style="background: #94FC88;">
						<div style="width: <?php echo $used_space_percent; ?>%; text-align:center; height: 13px; background: #E84141;"><?php echo ($used_space_percent > 5) ? $used_space_percent .'%': ''; ?></div>
					</div></td>
				</tr>
			</table>
		</div>
	</div>
	
	<script type="text/javascript">
$(function(){
   setInterval(function(){
       $(".xv-clock").each(function(){
           var xvTimestamp = Math.round((new Date()).getTime() / 1000);
           var xvObjTimestamp = $(this).data("timestamp");
           var xvToSeconds = Math.round(eval(xvTimestamp+"-"+xvObjTimestamp));
           
           var xvD =  Math.floor(xvToSeconds / 86400); 
           var xvH =  Math.floor((xvToSeconds % 86400) / 3600);
           var xvM = Math.floor(((xvToSeconds  % 86400) % 3600) / 60);
           var xvS = ((xvToSeconds % 86400) % 3600) % 60;
           var xvResult = "";
           
           if(xvD) xvResult = xvResult + xvD+ "d ";
           if(xvH) xvResult = xvResult + xvH+ "h ";
           xvResult = xvResult + xvM+ "m ";
           xvResult = xvResult +" "+ xvS +"s ";
           
           $(this).text(xvResult);
       });  
    },1000);
	setInterval(function(){
		$('.xv-refresh').each(function(){
			$(this).load($(this).data("url"));
		});
	},5000);
    
});
	</script>