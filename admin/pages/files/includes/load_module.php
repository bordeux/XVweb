<style type="text/css" media="all">
			@import url('<?=$GLOBALS['URLS']['Theme']?>css/jquery.contextMenu.css');
				.app-window  .xv-files {
					background-color: rgba(255,255,255,0.7);
					color : #000;
					padding:0;
					overflow-y:scroll;
					overflow-x:hidden;
				}
				.xv-file-info {
					float:left;
					max-width:15%;
					width:15%;
					height:300px;
					background: rgba(0,0,0, 0.6);
				}

				.xv-file-place {
					float:left;
					width: 84%;
				}
				.xv-icon {
				float:left;
				}
				.xv-file-desc {
				word-wrap:normal;
				text-align:center;
				max-width:64px;
				max-height:14px;
				overflow: hidden;
				text-overflow: ellipsis;
				}
				.xv-icon:hover .xv-file-desc{
					

				}
				.xv-icon:hover , .xv-file-selected{
					box-shadow: 0px 0px 15px #000000;
				}
				 .xv-file-selected{
					box-shadow: 0px 0px 15px #000000;
					background: rgba(148,198, 255, 0.4 );
				}
				.xv-file-icon {
					background: url(<?=$GLOBALS['URLS']['Site']?>admin/data/themes/{$GLOBALS['xv_theme_name']}/img/fileicons/file.png) no-repeat center center;
					width:64px;
					height:64px;
				}<style type="text/css" media="all">
			@import url('<?=$GLOBALS['URLS']['Theme']?>css/jquery.contextMenu.css');
				.app-window  .xv-files {
					background-color: rgba(255,255,255,0.7);
					color : #000;
					padding:0;
					overflow-y:scroll;
					overflow-x:hidden;
				}
				.xv-file-info {
					float:left;
					max-width:15%;
					width:15%;
					height:300px;
					background: rgba(0,0,0, 0.6);
				}

				.xv-file-place {
					float:left;
					width: 84%;
				}
				.xv-icon {
				float:left;
				}
				.xv-file-desc {
				word-wrap:normal;
				text-align:center;
				max-width:64px;
				max-height:14px;
				overflow: hidden;
				text-overflow: ellipsis;
				}
				.xv-icon:hover .xv-file-desc{
					

				}
				.xv-icon:hover , .xv-file-selected{
					box-shadow: 0px 0px 15px #000000;
				}
				 .xv-file-selected{
					box-shadow: 0px 0px 15px #000000;
					background: rgba(148,198, 255, 0.4 );
				}
				.xv-file-icon {
					background: url(<?=$GLOBALS['URLS']['Site']?>admin/data/themes/<?=$GLOBALS['xv_theme_name']?>/img/fileicons/file.png) no-repeat center center;
					width:64px;
					height:64px;
				}
<?php
foreach (glob(realpath($GLOBALS['RootDir']."/admin/data/themes/".$GLOBALS['xv_theme_name']."/img/fileicons/").'/*.png') as $filename) {
	$FileBaseName = basename($filename);
	$FileExec = explode("-", pathinfo($FileBaseName, PATHINFO_FILENAME));
	foreach($FileExec as $extt){
?>
				.xv-file-icon.xv-ico-<?=$extt?> {
					background: url(<?=$GLOBALS['URLS']['Site']?>admin/data/themes/<?=$GLOBALS['xv_theme_name']?>/img/fileicons/<?=$FileBaseName?>) no-repeat center center;
				}
				
<?php
}
}
?>
</style>
	
				<div class="xv-file-content">
				<input type="text" style="width:100%" class='xv-file-location'/>
					<div class="xv-file-info">
					</div>
					<div class="xv-file-place">
						<div class="xv-file-place-icons">

						</div>
					</div>
				</div>
				<script type="text/javascript" src='<?=$GLOBALS['URLS']['Theme']?>js/html5_uploader.jquery.js' charset="UTF-8"> </script> 
				<script type="text/javascript" src='<?=$GLOBALS['URLS']['Theme']?>js/alpha.jquery.js' charset="UTF-8"> </script> 
				<script type="text/javascript">
					var PasteDisabled = true;
					var PasteFilename = "";
					$(function(){
				
						jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
							  return this.each(function(){
								var clicks = 0, self = this;
								jQuery(this).click(function(event){
								  clicks++;
								  if (clicks == 1) {
									setTimeout(function(){
									  if(clicks == 1) {
										single_click_callback.call(self, event);
									  } else {
										double_click_callback.call(self, event);
									  }
									  clicks = 0;
									}, timeout || 300);
								  }
								});
							  });
							};


					ThemeClass.LoadDir = function(dirloc){
								$.ajax({
									  url: AdminLink+'Get/Files/Dir/',
									  data : { dir : dirloc},
									  type: "GET",
									  dataType: "text",
											  success: function(data) {
												$('.xv-file-place-icons').html(data);
												$('#xv-file-menager').data("xv-current-dir", dirloc);
											  }
									});
								};	
					 ThemeClass.GetInfo = function(filedir){
						$('.xv-file-info').load(AdminLink+'Get/Files/Info/', {filedir: filedir});
					};	
									
				ThemeClass.MenagerDropPlace =  function(ids, dirloc){	};
			ThemeClass.LoadDir("<?=$_GET['dir']?>");
			
					$("#xv-file-menager").html5_uploader().bind("html5_uploader.dragenter", function(){

					}).bind("html5_uploader.dragleave html5_uploader.drop", function(){

					}).bind("html5_uploader.drop", function(evt, files, files_count){
						$(this).trigger('html5_uploader.send', [{
							field_name : "filemenager[]",
							url : AdminLink+'Get/Files/Upload/?dir='+escape($(".xv-file-location").val()) //UPLOAD LINK
						}]);
					}).bind("html5_uploader.start", function(evnt, files_count){
					
						$('#xv-file-menager').jalpha({
											text : '<div style="text-align:center; display:table-cell; vertical-align:middle; color: #FFF;">'
													+'<div style="text-align:center">Name: <span class="xv-file-progress-name"></span> / <span class="xv-file-progress-status"> </span> / <span class="xv-file-progress-percent"></span></div>'
													+'<div class="ui-progressbar ui-widget ui-widget-content ui-corner-all" style="width:90%; margin:auto;">'
														+'<div class="ui-progressbar-value ui-widget-header ui-corner-left xv-file-progress" style="width: 20%;">'
														+'</div>'
														+'</div>'
													+'</div>',
							click : function(){
								$('#xv-file-menager').jalpha("destroy");
							},
							zindex : 999999
						});
						
					
					}).bind("html5_uploader.finish", function(evnt, files_count){
						$('#xv-file-menager').jalpha("destroy");
						ThemeClass.LoadDir($(".xv-file-location").val());
					}).bind("html5_uploader.start_one", function(evnt, file_name, file_number, total){
							$(".xv-file-progress-name").text(file_name);
					}).bind("html5_uploader.finish_one", function(evnt, response_server, file_name, file_number, total){
					
					}).bind("html5_uploader.error", function(evnt,  file_name, e){
						alert("error upload");
						$('#xv-file-menager').jalpha("destroy");
						ThemeClass.LoadDir($(".xv-file-location").val());
					}).bind("html5_uploader.old_browser", function(evnt){
						
					}).bind("html5_uploader.abort", function(evnt){
						
					}).bind("html5_uploader.progress", function(evnt, uploaded, fileSize, fileName, number, total){
						$(".xv-file-progress-percent").text(Math.ceil((uploaded/fileSize)*100)+"%");
						$(".xv-file-progress").css('width', Math.ceil((uploaded/fileSize)*100)+"%");
					});
				
			});
				</script>
				<div class="clear"></div>