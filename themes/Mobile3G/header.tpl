<!DOCTYPE html> 
<html> 
<head> 
<!--
 ____                _                   _   _ ______ _______ 
|  _ \              | |                 | \ | |  ____|__   __|
| |_) | ___  _ __ __| | ___ _   ___  __ |  \| | |__     | |   
|  _ < / _ \| '__/ _` |/ _ \ | | \ \/ / | . ` |  __|    | |   
| |_) | (_) | | | (_| |  __/ |_| |>  < _| |\  | |____   | |   
|____/ \___/|_|  \__,_|\___|\__,_/_/\_(_)_| \_|______|  |_|   
                                                              
                                                              
                 _     _ _      
                | |   (_) |     
 _ __ ___   ___ | |__  _| | ___ 
| '_ ` _ \ / _ \| '_ \| | |/ _ \
| | | | | | (_) | |_) | | |  __/
|_| |_| |_|\___/|_.__/|_|_|\___|                
-->
{if $Advertisement}{include  file='adv.tpl'}{/if}
	<meta charset="utf-8"> 
	{foreach from=$MetaTags item=content key=equiv}
		<meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>{$SiteTopic} :: {$xv_main_config->site_name} :.</title>
	<link rel="shortcut icon" href="{$Url}favicon.ico" type="image/x-icon" />
	<link rel="stylesheet"  href="http://code.jquery.com/mobile/1.0rc1/jquery.mobile-1.0rc1.min.css" /> 
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script> 
	<script src="{$URLS.JSCatalog}js/js.js"></script> 
	<script src="http://code.jquery.com/mobile/1.0rc1/jquery.mobile-1.0rc1.min.js"></script> 
	<link rel="shortcut icon" href="{$Url}favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:'url'}{/if}" />
	<style type="text/css" media="all">
	/*<![CDATA[*/
	@import url('{$URLS.Theme}css/style.css');
	{if $CCSLoad}
	/*{$CCSLoad|@ksort}*/
	{foreach from=$CCSLoad item=CSSLink key=kess}
	/*@import url('{$CSSLink}');*/
	{/foreach}
	{/if}
	/*]]>*/
	</style>
		<script type="text/javascript">
		/*<![CDATA[*/
	{foreach from=$JSVars key=k item=vs}
	var {$k} = '{$vs|escape:'quotes'}';
	{/foreach}
	var URLS = eval('({$URLS|@json_encode})'); 
	/*{if $JSBinder}{$JSBinder|@sort}{/if}*/	
	
	/*]]>*/
	</script>  
</head> 
<body>