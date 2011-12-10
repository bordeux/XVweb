<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> {include file="adv.tpl"}
	<title>{$SiteTopic} :: {$SiteName} :.</title> 
	{foreach from=$MetaTags item=content key=equiv}
    <meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta http-equiv="Content-Language" content="pl" /> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<meta http-equiv="Content-Script-Type" content="text/javascript" /> 
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" /> 
	<link rel="shortcut icon" href="http://betta.bordeux.net/favicon.ico" type="image/x-icon" /> 
	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$UrlScript}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:"url"}{/if}" /> 
	<style type="text/css" media="all"> 
		/*<![CDATA[*/
		@import url({$UrlTheme}css/style.css);
		/*{$CCSLoad|@ksort}*/
		{foreach from=$CCSLoad item=CSSLink}
		@import url('{$CSSLink}');
		{/foreach}
		/*]]>*/
	</style> 
	{if $GAnalistics}
	<script type="text/javascript">
	window.google_analytics_domain_name = "";
		var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '{$GAnalistics}']);{literal}
		  _gaq.push(['_setDomainName', 'none']);
		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);
		  _gaq.push(['_trackPageLoadTime']);
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		 {/literal}
	</script>
{/if}
</head> 
<body>
<div id="Header">
	<div id="Logo">
		<a href="{$Url}"><img src="{$UrlTheme}img/Logo.png" alt="{$language.MainPage}"/></a>
	</div>
	<div id="UserPanel">
		 {if $Session.Logged_Logged}
			 <div id="LogOut"><a href="?LogOut=true"><img src="{$UrlTheme}img/logout.png" alt="{$language.LogOut}"/></a></div>
			 <a href="{$UrlScript}Users/{$Session.Logged_User|escape:'url'}/" id="UserNick">{$Session.Logged_User}</a><br/>
			 <a href="{$UrlScript}Users/{$Session.Logged_User|escape:'url'}#Edit=true">{$language.EditProfile}</a><br/>
			 <a href="{$UrlScript}Messages/">{$language.Messages}</a><br/>
		 {else}
			<a href="{$UrlScript}Login/?Path={$URLS.Path|escape:'url'}">{$language.Login}</a>
		{/if}
	</div>
	<div id="EndHeader"></div>
</div>