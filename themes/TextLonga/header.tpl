<!doctype html>
<html>
  <head>
  {if $smarty.server.HTTP_USER_AGENT|strpos:"MSIE"}{assign var="isie" value="true"}{/if}
<!--{include file="functions.tpl" inline}
	 _                   _                              _   
	| |__   ___  _ __ __| | ___ _   ___  __  _ __   ___| |_ 
	| '_ \ / _ \| '__/ _` |/ _ \ | | \ \/ / | '_ \ / _ \ __|
	| |_) | (_) | | | (_| |  __/ |_| |>  < _| | | |  __/ |_ 
	|_.__/ \___/|_|  \__,_|\___|\__,_/_/\_(_)_| |_|\___|\__|
-->                                                        					
    <title>{$xv_title|default:$SiteTopic} :: {$xv_main_config->site_name} :.</title>
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<meta charset="utf-8">
	<link rel="shortcut icon" href="{$URLS.Site}favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:'url'}{/if}" />
	{if !"Adv"|xv_perm}{include  file='adv.tpl'}{/if}
	<style type="text/css" media="all">
	/*<![CDATA[*/
	@import url('{$URLS.Theme}css/custom-theme/jquery-ui-1.8.7.custom.css{if $isie}?ie=true{/if}');
	@import url('{$URLS.Theme}css/style.css{if $isie}?ie=true{/if}');
	{if $CCSLoad}
	/*{$CCSLoad|@ksort}*/
	{foreach from=$CCSLoad item=CSSLink key=kess}
	@import url('{$CSSLink}{if $isie}?ie=true{/if}');
	{/foreach}
	{/if}
	/*]]>*/
	</style>
	<script type="text/javascript">
	{foreach from=$JSVars key=k item=vs}
	var {$k} = '{$vs|escape:'quotes'}';
	{/foreach}
	var URLS = eval('({$URLS|@json_encode})'); 
	/*{if $JSBinder}{$JSBinder|@sort}{/if}*/	
	</script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.min.js" charset="UTF-8"> </script> 
	<script>!window.jQuery && document.write(unescape('%3Cscript src="{$URLS.Theme}js/jquery.js"%3E%3C/script%3E'))</script>	
	<script type="text/javascript" async="async" defer="defer" src="{$URLS.JSCatalog}js/JSBinder/js.js?Load=js{foreach from=$JSBinder item=JSScriptName}:{$JSScriptName}{/foreach}&amp;NoCompress={foreach from=$JSBinderNC item=JSScriptName}:{$JSScriptName}{/foreach}" charset="UTF-8"></script>
	{foreach from=$xv_append_header key=k item=vs}
		{$vs}
	{/foreach}
	
  </head>
  <body>
 <header>
		<div class="main">
			<div class="container">
				<!-- LOGO -->
					<h1><a href="{$URLS.Site}">{$xv_main_config->site_name}</a></h1>
				<!-- /LOGO -->
					<div class="xvlogin">
						<div class="xvlogin-boxes">
						{if !$Session.user_logged_in}
						<!-- LOGOWANIE -->
							<div class="xvlogin-login xvlogin-tohide">
						
							</div>
							<!-- /LOGOWANIE -->
						{/if}
						<div class="xvlogin-hide"><a href="#hide" class="xvshow" rel="nofollow" data-tohide=".xvlogin-tohide"></a></div>
						</div>
					<div class="xvlogin-bar">
					{if $Session.user_logged_in}
						<a href="{$URLS.Script}Users/{$Session.user_name|escape:'url'}/" id="UserNick">{if $Session.Logged_Avant}<img src="{$AvantsURL}{$Session.user_name|escape:'url'}_16.jpg" alt="{$Comment.Author}"/>{/if}{$Session.user_name}</a> | 
						<a href="{$URLS.Script}Users/{$Session.user_name|escape:'url'}/Edit">{$language.EditProfile}</a> | 
						<a href="{$URLS.Script}Messages/">{$language.Messages} (0/0)</a> | 
						{$xv_panel_links}
						<a href="{$URLS.Script}Logout/{$JSVars.SIDUser}/" class="xv-confirm-link" data-xv-question="Czy napewno chcesz się wylogować? ">{$language.LogOut}</a> 
					{else}
						<a href="{$URLS.Script}Login/" rel="nofollow" class="xvshow xv-login-header" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-login">{"SingIn"|xv_lang}</a> | <a href="{$URLS.Script}Register/" rel="nofollow">{"SingUp"|xv_lang}</a>
					{/if}
					</div>
					</div>
					<!--<div class="search">
					 <form action="{$URLS.Script}Search/" method="get" name="SearchForm" id="SearchForm">
						<input type="search" results="5" name="Search" placeholder="{$language.Search}..." />
					  </form>
					</div>-->
				<div class="clear"></div>
			</div>
			{include file="menu.tpl" inline}
		</div>
	</header>
<!--/Header-->
{if $Advertisement}
		<div class="xv-adv xv-adv-banner">{$smarty.capture.ADVBanner}</div>
{/if}