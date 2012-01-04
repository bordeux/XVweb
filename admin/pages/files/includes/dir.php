<?php
				 $root = $GLOBALS['RootDir'];
				 $_GET['dir'] = preg_replace('/\w+\/\.\.\//', '', $_GET['dir']);
				$_GET['dir'] = urldecode($_GET['dir']);

				if( file_exists(realpath($root . $_GET['dir'])) ) {
					$files = scandir(realpath($root . $_GET['dir']));
					natcasesort($files);
					if( count($files) > 1 ) {
						echo "<!-- DIRS -->";
						foreach( $files as $file ) {
							if( file_exists($root . $_GET['dir'] . $file) && $file != '.'  && is_dir($root . $_GET['dir'] . $file) ) {
								
								echo '
								<div class="xv-icon xv-file-dir" data-xv-location="'. htmlentities(($_GET['dir'] . $file)) .'/">
									<div class="xv-file-icon xv-ico-dir"></div>
									<div class="xv-file-desc">'.basename($_GET['dir'] . $file).'</div>
								</div>
								';
							}
						}
						echo "<!-- /DIRS -->";
						echo "<!-- FILES -->";
						// All files
						
						foreach( $files as $file ) {
							if( file_exists($root . $_GET['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_GET['dir'] . $file) ) {
								$ext = pathinfo($file, PATHINFO_EXTENSION);
								
								echo '
								<div class="xv-icon" data-xv-location="'. htmlentities(($_GET['dir'] . $file)) .'">
									<div class="xv-file-icon xv-ico-'.$ext.'"></div>
									<div class="xv-file-desc">'.basename($_GET['dir'] . $file).'</div>
								</div>
								';
							}
						}
						echo "<!-- /FILES -->";
						
						?>
						<script type="text/javascript">
							$(function(){
								$(".xv-file-location").val("<?php echo $_GET['dir']; ?>");
								/*ThemeClass.history("#xv-file-menager", "?dir=<?php echo $_GET['dir']; ?>", "XVweb::Files", { type: "filemenager" , todo: function(){
										alert("jasne");
									}});*/
								$("#xv-file-menager").data("xv-url", 'Files/?dir=<?php echo $_GET['dir']; ?>')
								$('.xv-icon').single_double_click(function () {
									  ThemeClass.GetInfo($(this).data('xv-location'));
									  $('.xv-file-selected').removeClass("xv-file-selected");
									  $(this).addClass("xv-file-selected");
									}, function () {
										if($(this).hasClass('xv-file-dir'))
											ThemeClass.LoadDir($(this).data('xv-location')); else
											ThemeClass.GetWindow('Files/View/?file='+escape($(this).data('xv-location')));
									});
	
									
											var fileRightMenu = [
														  {'Edit': {
															  onclick: function(menuItem,menuObject) { 
																	alert($(this).data('xv-location'));
																	return true; 
															  },
																icon: URLS.Theme+'img/contextmenu/page_white_edit.png' 
														  }}, 
														  $.contextMenu.separator,
														  {'Cut':{
															  onclick: function(menuItem,menuObject) { 
																	if(PasteDisabled == true)
																	$(".xv-paste").toggleClass("context-menu-item-disabled");
																	
																	PasteDisabled = false;
																	
														fullPath = $(this).data('xv-location'); 
														PasteFilename = fullPath.substring(fullPath.lastIndexOf("/")+1,fullPath.length);
														$(".xv-paste div").text("Paste "+PasteFilename);
																	//$(".contextMenu .paste").removeClass("disabled").data({
																		//file: $(this).data('xv-location'),
																		//operaction: "cut" 	
																	//});
																	return true; 
															  },
																icon: URLS.Theme+'img/contextmenu/cut.png'
														  } },
														  {'Copy':{
																 onclick: function(menuItem,menuObject) {

																	if(PasteDisabled == true)
																	$(".xv-paste").toggleClass("context-menu-item-disabled");
																																	 
																 PasteDisabled = false;
														fullPath = $(this).data('xv-location'); 
														PasteFilename = fullPath.substring(fullPath.lastIndexOf("/")+1,fullPath.length);
															$(".xv-paste div").text("Paste "+PasteFilename);
														
																		//$(".contextMenu .paste").removeClass("disabled").data({
																			//file: $(this).data('xv-location'),
																			//operaction: "copy" 	
																		//});
																		return true; 
																  },
																icon: URLS.Theme+'img/contextmenu/page_white_copy.png'
														  } },	 
														  { 'Paste ' : {
																onclick:   function(menuItem,menuObject) { 
																		ThemeClass.GetWindow('Files/Paste/?file='+escape($(".contextMenu .paste").data("file") )+'&destination='+escape($(this).data('xv-location'))+'&operation='+escape($(".contextMenu .paste").data("operaction") ));
																		return true; 
																  },
																icon: URLS.Theme+'img/contextmenu/page_white_paste.png',
																 disabled : PasteDisabled,
																 className : "xv-paste",
																 title : PasteFilename
														  
														  } },
														  $.contextMenu.separator,
														  {'Delete': {
																onclick: function(menuItem,menuObject) { 
																		ThemeClass.GetWindow('Files/Delete/?file='+escape($(this).data('xv-location')));
																		return true; 
																  },
																icon: URLS.Theme+'img/contextmenu/page_white_delete.png'
														  } },
														  {'Rename':{
																onclick: function(menuItem,menuObject) { 
																ThemeClass.GetWindow('Files/Rename/?file='+escape($(this).data('xv-location')));
																return true; 
																},
																icon: URLS.Theme+'img/contextmenu/rename.png'
														  }},
														  {'New dir':{
																onclick: function(menuItem,menuObject) { 
																	ThemeClass.GetWindow('Files/NewDir/?file='+escape($(this).data('xv-location')));
																	return true; 
																},
																 icon: URLS.Theme+'img/contextmenu/folder-new.png'
														  } },	 
														  {'Chmod':{
																onclick: function(menuItem,menuObject) { 
																	ThemeClass.GetWindow('Files/Chmod/?file='+escape($(this).data('xv-location')));
																	return true; 
															  },
															  icon: URLS.Theme+'img/contextmenu/chmod.png'
														  }
														  }, 
														  $.contextMenu.separator,
														  {'Quit':{
																	onclick:function(menuItem,menu){
																		alert($(this).data('xv-location'));
																	},
																	icon: URLS.Theme+'img/contextmenu/door.png'
																 }
														}
														];
														
														$(function() {
														  $('.xv-file-place-icons .xv-icon').contextMenu(fileRightMenu,{theme:'gloss'});
														});
										
										


									/*
								$(".xv-file-place-icons .xv-icon").unbind("contextMenu").contextMenu({
										menu: 'xv-right-menu'
									},function(action, el, pos) {
										if(action == "delete")
											ThemeClass.GetWindow('Files/Delete/?file='+escape($(el).data('xv-location')));
										
										if(action == "rename")
											ThemeClass.GetWindow('Files/Rename/?file='+escape($(el).data('xv-location')));
										if(action == "copy" || action == "cut"){
												$(".contextMenu .paste").removeClass("disabled").data({
													file: $(el).data('xv-location'),
													operaction: action 	
												});

										}
										if(action == "newdir")
											ThemeClass.GetWindow('Files/NewDir/?file='+escape($(el).data('xv-location')));
										if(action == "chmod")
											ThemeClass.GetWindow('Files/Chmod/?file='+escape($(el).data('xv-location')));
											
										if(action == "paste"){
											ThemeClass.GetWindow('Files/Paste/?file='+escape($(".contextMenu .paste").data("file") )+'&destination='+escape($(el).data('xv-location'))+'&operation='+escape($(".contextMenu .paste").data("operaction") ));
										}
									});*/
									
									//$(".xv-icon").draggable( "destroy" ).draggable({helper: "clone"});
									/*$(".xv-file-dir").droppable( "destroy" ).droppable({
										accept: ".xv-file-place-icons .xv-icon",
										drop: function( event, ui ) {
											ThemeClass.GetWindow('Files/Paste/?file='+escape($(ui.draggable).data('xv-location'))+'&destination='+escape($(this).data('xv-location'))+'&operation=cut');
										}
									});
									*/
									
							//ThemeClass.MenagerDropPlace('#xv-file-menager .content' , '<?php echo $_GET['dir']; ?>');
							
							});
						</script>
<?php
					}
				}
				
			
		exit;