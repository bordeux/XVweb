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
    <title>{$xv_title|default:$SiteTopic}:: {$xv_main_config->site_name} :.</title>
	{foreach from=$MetaTags item=content key=equiv}
		<meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<link rel="shortcut icon" href="{$URLS.Site}favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:'url'}{/if}" />
	{if !"Adv"|xv_perm}{include  file='adv.tpl'}{/if}
	<style type="text/css" media="all">
	/*<![CDATA[*/
	@import url('{$UrlTheme}css/custom-theme/jquery-ui-1.8.7.custom.css{if $isie}?ie=true{/if}');
	@import url('{$UrlTheme}css/style.css{if $isie}?ie=true{/if}');
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
	<script type="text/javascript" src="{$URLS.Script}receiver/language.js" charset="UTF-8"> </script>  
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.min.js" charset="UTF-8"> </script> 
	<script>!window.jQuery && document.write(unescape('%3Cscript src="{$URLS.Site}plugins/libraries/jquery/jquery.js"%3E%3C/script%3E'))</script>	
	<script type="text/javascript" async="async" defer="defer" src="{$URLS.JSCatalog}js/JSBinder/js.js?Load=js{foreach from=$JSBinder item=JSScriptName}:{$JSScriptName}{/foreach}&amp;NoCompress={foreach from=$JSBinderNC item=JSScriptName}:{$JSScriptName}{/foreach}" charset="UTF-8"></script>
	{foreach from=$xv_append_header key=k item=vs}{$vs}{/foreach}
	
  </head>
  <body>{$MetaTag}
 <header>
		<div class="main">
			<div class="container">
				<!-- LOGO -->
					<h1><a href="{$URLS.Site}">{$SiteName}</a></h1>
				<!-- /LOGO -->
					<div class="xvlogin">
						<div class="xvlogin-boxes">
						{if !$Session.Logged_Logged}
						<!-- LOGOWANIE -->
							<div class="xvlogin-login xvlogin-tohide">
						
							</div>
							<!-- /LOGOWANIE -->
							<!-- OPENID -->
							<div class="xvlogin-openid xvlogin-tohide">
							<form action="{$URLS.Script}OpenID/OpenIDLogin/" method="post">
								<label for="xvlogin-openid-input-id">{$language.OpenID}:</label> <input type="text" name="openid_url" id="xvlogin-openid-input-id" />
								<input type="submit" id="xvlogin-submit-input-id" value="{$language.Login}"/>
							</form>
							</div>
							<!-- /OPENID -->	
							<!-- RESET PASSWORD -->
							<div class="xvlogin-reset-password xvlogin-tohide">
								<div class="xv-reset-password-result"></div>
							<form action="{$URLS.Script}LostPass/Get/" method="post" class="xv-form" data-xv-result=".xv-reset-password-result">
								<label for="xvlogin-reset-password-id">{$language.Mail}:</label> <input type="text" name="LostEmail" id="xvlogin-reset-password-id" />
								<input type="submit" id="xvlogin-submit-input-id" value="{$language.Send}"/>
							</form>
							</div>
							<!-- /RESET PASSWORD -->
						{/if}
						<div class="xvlogin-hide"><a href="#hide" class="xvshow" rel="nofollow" data-tohide=".xvlogin-tohide"></a></div>
						</div>
					<div class="xvlogin-bar">
					{if $Session.Logged_Logged}
						<a href="{$URLS.Script}Users/{$Session.Logged_User|escape:'url'}/" id="UserNick">{if $Session.Logged_Avant}<img src="{$AvantsURL}{$Session.Logged_User|escape:'url'}_16.jpg" alt="{$Comment.Author}"/>{/if}{$Session.Logged_User}</a> | 
						<a href="{$URLS.Script}Users/{$Session.Logged_User|escape:'url'}/Edit">{$language.EditProfile}</a> | 
						<a href="{$URLS.Script}Messages/">{$language.Messages} (0/0)</a> | 
						{$xv_panel_links}
						<a href="{$URLS.Script}Logout/{$JSVars.SIDUser}/" class="xv-confirm-link" data-xv-question="Czy napewno chcesz się wylogować? ">{$language.LogOut}</a> 
					{else}
						<a href="{$URLS.Script}Login/" rel="nofollow" class="xvshow xv-login-header" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-login">{"SingIn"|xv_lang}</a> | <a href="{$URLS.Script}Register/" rel="nofollow">{"SingUp"|xv_lang}</a>
					{/if}
					</div>
					</div>
					<div class="search">
					 <form action="{$URLS.Script}Search/" method="get" name="SearchForm" id="SearchForm">
						<input type="search" results="5" name="Search" placeholder="{$language.Search}..." />
					  </form>
					</div>
				<!--<div class="social">
					<a href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:'url'}{/if}"><img src="{$URLS.Theme}img/rss.jpg" alt=""></a>
					<a href="#"><img src="{$URLS.Theme}img/facebook.jpg" alt=""></a>
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