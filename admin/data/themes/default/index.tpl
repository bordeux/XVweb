<!doctype html>
<html> 
	<head> 
		<title>XVweb::Backstage</title> 
		<meta name="description" content=""> 
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1">
		<style type="text/css" media="all">
			/*<![CDATA[*/
			@import url('{$URLS.Theme}css/custom-theme/jquery-ui-1.8.11.custom.css');
			@import url('{$URLS.Theme}css/style.css');
			{if $CCSLoad}
			/*{$CCSLoad|@ksort}*/
			{foreach from=$CCSLoad item=CSSLink key=kess}
			@import url('{$CSSLink}');
			{/foreach}
			{/if}
			/*]]>*/
		</style>
		<script type="text/javascript">
			{foreach from=$JSVars key=k item=vs}
			var {$k} = '{$vs|escape:'quotes'}';
			{/foreach}
			var URLS = eval('({$URLS|@json_encode})'); 
			var UserConfig = eval('({$UserConfig|@json_encode})'); 
			/*{if $JSBinder}{$JSBinder|@sort}{/if}*/
		</script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.min.js" charset="UTF-8"> </script> 
		<script>!window.jQuery && document.write(unescape('%3Cscript src="{$URLS.Theme}js/jquery.min.js"%3E%3C/script%3E'))</script>
		<script type="text/javascript" src="{$URLS.Theme}js/jquery-ui-1.8.11.custom.min.js" charset="UTF-8"> </script>
		<script type="text/javascript" src='{$URLS.Theme}js/jquery.contextMenu.js' charset="UTF-8"> </script> 
		<script type="text/javascript" src="{$URLS.Theme}js/js.js" charset="UTF-8"> </script>
		<script type="text/javascript" src="{$URLS.Theme}js/widgets.js" charset="UTF-8"> </script>
		<script type="text/javascript" src="{$URLS.Theme}js/desktop.js" charset="UTF-8"> </script>
	</head> 
	<body> 
		<ul class="menu"> 
		{foreach from=$admin_menu item=menu_cat key=menu_key}
			<li id="xv-menu-{$menu_key}">
				<a href="{$menu_cat.href|default:'#'}">{$menu_cat.name}</a> 
				{if $menu_cat.submenu}
				<ul class="sub-menu"> 
					{foreach from=$menu_cat.submenu item=submenu_item}
					<li><a href="{$URLS.Script}{$submenu_item.href}" class="xv-get-window">{$submenu_item.name}</a></li> 
					{/foreach}
				</ul>
				{/if}
			</li>
		{/foreach}
			
			
			<li style="float:right"><a href="{$URLS.Script}Logout/{$JSVars.SIDUser}/" >Logout</a></li> 
			<li style="float:right; padding: 0 3px 0 3px;"><a href="#" class='xv-close-all-windows' style="display:block; padding: 0 10px 0 10px; " title="Close windows">X</a></li> 
			<li style="float:right; padding: 0 3px 0 3px;"><a href="#+" class="xv-enlarge" style="display:block; padding: 0 10px 0 10px; ">+</a></li> 
			<li style="float:right;  padding: 0 3px 0 3px;"><a href="#+" class="xv-reduce" style="display:block; padding: 0 10px 0 10px;">-</a></li> 
			

			
			
		</ul>
<div id="xv-windows" class="xv-windows-class">		
<!-- Place to work! -->


<!-- END Place to work! -->
<div class="xv-desktop"></div>


<div class="xv-sidebar xv-sidebar-left"></div>
<div class="xv-sidebar xv-sidebar-right"></div>
		<div class="dock">
				<div class="apps">
					<ul><!-- Wait for load in JS --></ul>
					<div class="l"></div>
					<div class="r"></div>
				</div>
				<a href="#MinAll" class="xv-minimalize-all"></a>
				<div class="xv-status"><img src="{$URLS.Theme}img/wait.gif" alt="Please Wait" style="width: 16px; height:16px;" /> <span class="xv-status-text"></span></div>
		</div>
		
			
</div>
	</body> 
</html>