<html lang="pl"><head>
    <title>{$SiteTopic} :: {$SiteName} :.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	{foreach from=$MetaTags item=content key=equiv}
    <meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<link rel="shortcut icon" href="{$Url}favicon.ico" type="image/x-icon" />
<style type="text/css" media="all">
/*<![CDATA[*/
@import url({$Digg.Theme}style.css);
/*{$CCSLoad|@ksort}*/
{foreach from=$CCSLoad item=CSSLink key=kess}
@import url('{$CSSLink}');
{/foreach}
/*]]>*/
</style>
	<script type="text/javascript">
	{foreach from=$JSVars key=k item=vs}
	var {$k} = '{$vs|escape:'quotes'}';
	{/foreach}
	var URLS = eval('({$URLS|@json_encode})'); 
	/*{if $JSBinder}{$JSBinder|@sort}{/if}*/	
	
		function AjaxCounterOnline() {

			$.getJSON(URLS.Script + "online/", {
				LogedUsers:true, 
				UrlLocation:location.href,
				HideProgres:true
			}, function(a) {
				$(".OAllUsers").html(a.OnlineUsers);
				$(".OLogedUsers").html(a.LogedUser);
				this.HideProgress = true
			});
		}
	$(function() {
		AjaxCounterOnline();
		setInterval("AjaxCounterOnline()", 1000);
	});
	
	</script>
</head>


<body>{$MetaTag}
<div id="Header">
<div id="Logo"> 
	<a href="{$URLS.Site}"><img src="{$URLS.Site}plugins/digg/theme/logo.png" /></a>
</div>
<div id="Description">
	<div id="Title">
		<a href="?digg=article">{$SiteTopic}</a>
	</div>
	<div id="Informations">
		<a href="?digg=comments">{$language.Comments|strtolower}: (<b>{$Digg.Comments}</b>)</a>
		<a href="{$Digg.Link}">źródło: {$Digg.Host|escape:"html"}</a>
		<div id="EditPanel">
				{if  $Session.Logged_Logged}
				
					{if $ReadArticleIndexOut.Observed}<a href="?Watch=0&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.UnWatch}">{$language.UnWatch}</a>{else}<a href="?Watch=1&amp;SIDCheck={$JSVars.SIDUser|md5}&amp;frame=true" title="{$language.Watch}">{$language.Watch}</a>{/if}
					
				
					{if $ReadArticleIndexOut.Bookmark}<a href="?Bookmark=0&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.AddBookmark}">{$language.AddBookmark}</a>{else}<a href="?Bookmark=1&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.DeleteBookmark}">{$language.DeleteBookmark}</a>{/if}
				
			{/if}
		</div>
	</div>
</div>
<div id="CloseFrame">
	<a href="{$Digg.Link}"><img src="{$URLS.Site}plugins/digg/theme/close.png" /></a>
</div>
</div>
<iframe id="FramePage" name="FramePage" src="{$Digg.Link}" frameborder="0" noresize="noresize" style="width:100%; height:100%; "></iframe>
</body>
</html>