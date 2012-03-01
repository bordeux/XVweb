<!doctype html>
<html>
  <head>
  {if $smarty.server.HTTP_USER_AGENT|strpos:"MSIE"}{assign var="isie" value="true"}{/if}
<!--
	 _                   _                              _   
	| |__   ___  _ __ __| | ___ _   ___  __  _ __   ___| |_ 
	| '_ \ / _ \| '__/ _` |/ _ \ | | \ \/ / | '_ \ / _ \ __|
	| |_) | (_) | | | (_| |  __/ |_| |>  < _| | | |  __/ |_ 
	|_.__/ \___/|_|  \__,_|\___|\__,_/_/\_(_)_| |_|\___|\__|
-->                                                        					
    <title>{$SiteTopic} :: {$SiteName} :.</title>
	{foreach from=$MetaTags item=content key=equiv}
		<meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<link rel="shortcut icon" href="{$Url}favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:'url'}{/if}" />
	{if !"Adv"|xvPerm}{include  file='adv.tpl'}{/if}
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
	
	{if $GAnalistics}
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
	{/if}

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
							<!-- OPENID BUTTON -->
								<div class="xvlogin-with-ext">
									<a href="{$URLS.Site}OpenID/" rel="nofollow" class="xvshow" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-openid"><img src="{$URLS.Theme}img/openid.png" alt="{$language.OpenID}" /></a>
									<a href="{$URLS.Site}Facebook/?Path={$URLS.Path|substr:1}" rel="nofollow"><img src="{$URLS.Theme}img/facebook_icon.png" alt="{$language.Facebook}" /></a>
									<a href="{$URLS.Site}GoogleID/?Path={$URLS.Path|substr:1}" rel="nofollow"><img src="{$URLS.Theme}img/google_icon.png" alt="{$language.Google}" /></a>
								</div>
							<!-- /OPENID BUTTON -->
								<div id="LoginResult"></div>
							<form action="{$URLS.Script}Login/SignIn/" method="post" class="xv-form" data-xv-result="#LoginResult">
								<label for="xvlogin-login-input-id">{$language.Nick}:</label> <input type="text" name="LoginLogin" id="xvlogin-login-input-id"/>
								<label for="xvlogin-password-input-id">{$language.Password}:</label> <input type="password" name="LoginPassword" id="xvlogin-password-input-id"/>
							 <input type="checkbox" name="LoginRemember" title="{$language.RememberPassword}" id="xvlogin-remember-input-id"/>
								<input type="submit" id="xvlogin-submit-input-id" value="{$language.Login}"/>
							</form>
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
							<!-- REJESTRACJA -->

							<div class="xvlogin-register xvlogin-tohide">
							<form action="{$URLS.Site}Register/?SingUp=true" method="post" class="xvlogin-register-form">
								<div class="xvlogin-register-result error" style="display:none;"></div>
								<table>
									<tr>
										<td><label for="xvlogin-login-input-id">{$language.Nick}:</label></label></td>
										<td><input type="text" name="register[User]" id="xvlogin-login-input-id"/></td>										<td><label for="xvlogin-login-input-id">{$language.Mail}:</label></label></td>
										<td><input type="text" name="register[Mail]" id="xvlogin-login-input-id"/></td>

									</tr>
									<tr>
										<td><label for="xvlogin-password-input-id">{$language.Password}:</label></td>
										<td><input type="password" name="register[Password]" id="xvlogin-password-input-id"/></td>
										<td><label for="xvlogin-password-input-id">{$language.RewritePassword}:</label></td> <!-- language! -->
										<td><input type="password" name="register[RPassword]" id="xvlogin-password-input-id"/></td>
									</tr>
									<tr>
										<td style="vertical-align:top;"><label for="xvlogin-password-input-id">Captcha:</label></td>
										<td style="vertical-align:top;">
										<div style='float: left;'>
											<div style='float: left; vertical-align:middle;'>
												<img src='{$URLS.Script}Captcha/CaptchaImage/captcha.gif?rand={math equation="rand(10,1000)"}' id='CaptchaImage' />
											
											<a href='{$URLS.Script}Captcha/Audio?CaptchaWav' rel="nofollow"><img src='{$URLS.Theme}img/audio_icon.png' alt="Audio Captcha" /></a>
	
											<a href='#' class="xvlogin-register-captcha-refresh" rel="nofollow" data-captcha="#CaptchaImage">
												<img src='{$URLS.Theme}img/refresh_icon.png'/>
											</a>
											</div>
										</div>
</td>
										<td style="vertical-align:top;"><label for="xvlogin-password-input-id">Kod z obrazka:</label></td> <!-- language! -->
										<td style="vertical-align:top;"><input type="text" name="register[Captcha]" id="xvlogin-password-input-id"/></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td><input type="submit" value="{$language.Send}" id="xvlogin-login-input-id"/></td>										

									</tr>
								</table>
								</form>
							</div>
							<!-- /REJESTRACJA -->
						{/if}
						<div class="xvlogin-hide"><a href="#hide" class="xvshow" rel="nofollow" data-tohide=".xvlogin-tohide"></a></div>
						</div>
					<div class="xvlogin-bar">
					{if $Session.Logged_Logged}
						<a href="{$URLS.Script}Users/{$Session.Logged_User|escape:'url'}/" id="UserNick">{if $Session.Logged_Avant}<img src="{$AvantsURL}{$Session.Logged_User|escape:'url'}_16.jpg" alt="{$Comment.Author}"/>{/if}{$Session.Logged_User}</a> | 
						<a href="{$URLS.Script}Users/{$Session.Logged_User|escape:'url'}/Edit">{$language.EditProfile}</a> | 
						<a href="{$URLS.Script}Messages/">{$language.Messages} (0/0)</a> | 
						{$xv_panel_links}
						<a href="?LogOut=true" class="xv-confirm-link" data-xv-question="Czy napewno chcesz się wylogować? ">{$language.LogOut}</a> 
					{else}
						<a href="{$URLS.Script}Login/" rel="nofollow" class="xvshow" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-login">Zaloguj</a> | <a href="{$URLS.Script}Register/" rel="nofollow" class="xvshow" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-register">Rejestracja</a>
					{/if}
					</div>
					</div>
					<div class="search">
					 <form action="{$UrlScript}Search/" method="get" name="SearchForm" id="SearchForm">
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