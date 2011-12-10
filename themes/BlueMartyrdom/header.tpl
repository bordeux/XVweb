<!doctype html>
<html>
  <head>
    <title>{$SiteTopic} :: {$SiteName} :.</title>
	{foreach from=$MetaTags item=content key=equiv}
    <meta http-equiv="{$equiv}" content="{$content}" />
	{/foreach}
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<link rel="shortcut icon" href="{$Url}favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$UrlScript}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:"url"}{/if}" />
	{if $Advertisement}{include  file='adv.tpl'}{/if}
<style type="text/css" media="all">
/*<![CDATA[*/
@import url('{$UrlTheme}css/custom-theme/jquery-ui-1.8.7.custom.css{if $smarty.server.HTTP_USER_AGENT|strpos:"MSIE"}?ie=true{/if}');
@import url('{$UrlTheme}css/style.css{if $smarty.server.HTTP_USER_AGENT|strpos:"MSIE"}?ie=true{/if}');
{if $CCSLoad}
/*{$CCSLoad|@ksort}*/
{foreach from=$CCSLoad item=CSSLink key=kess}
@import url('{$CSSLink}{if $smarty.server.HTTP_USER_AGENT|strpos:"MSIE"}?ie=true{/if}');
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
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		 {/literal}
	{/if}

	</script>
	<script type="text/javascript" src="{$UrlScript}receiver/language.js" charset="UTF-8"> </script>  
	{*<script type="text/javascript" src="{$URLS.Site}plugins/libraries/jquery/jquery.js" charset="UTF-8"> </script>  *}
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.1.min.js" charset="UTF-8"> </script> 
	<script>!window.jQuery && document.write(unescape('%3Cscript src="{$URLS.Site}plugins/libraries/jquery/jquery.js"%3E%3C/script%3E'))</script>	
	<script type="text/javascript" src="{$URLS.JSCatalog}js/JSBinder/js.js?Load=JavaScript{foreach from=$JSBinder item=JSScriptName}:{$JSScriptName}{/foreach}&amp;NoCompress={foreach from=$JSBinderNC item=JSScriptName}:{$JSScriptName}{/foreach}" charset="UTF-8"></script>
<!--[if IE 7]>
<link href="{$UrlTheme}css/ie7.css" rel="stylesheet">
<![endif]-->
  </head>
  <body>{$MetaTag}
  <div id="progressID"></div>
    <div id="MainPage">
      <!--Header-->
      <header>
        <div id="HeaderUpMenu">
          <div class="bigsprite" id="HULeftCorners"></div>
          <div id="HUCenterBG">
            <div id="UpMenu">
              <div id="UpMenuButtons">
                <div class="bigsprite" id="UMLC"></div>
                <div id="UMBG">
                  <div>
                    <a href="{$Url}?ref=topmenu">{$language.MainPage}</a>
                  </div>
                  <div>
                    {if $LogedUser}<a href="#" onclick=
                    'LogOut(); return false;'>{$language.LogOut}</a>{else}<a href="#" onclick=
                    'AjaxLoged(); return false;'>{$language.Login}</a>{/if}
                  </div>
                  <div>
                    <a href="{$UrlScript}Write/">{$language.AddArticle}</a>
                  </div>
                </div>
                <div class="bigsprite" id="UMRC"></div>
              </div>
            </div>
            <div id="SearchDiv">
              <form action="{$UrlScript}Search/" method="get" name="SearchForm" id="SearchForm">
                Szukaj: <input accesskey="s" type="text" class="cssprite" name="Search" class="Search" value="" />
              </form>
            </div>
          </div>
          <div class="bigsprite" id="HURightCorners"></div>
        </div>
        <div id="MainHeader">
          <div class="bigsprite" id="LeftSymbol"></div>
          <div id="RightSymbol"></div>
          <div class="bigsprite" id="LeftCorner">
            <div id="HeaderBackground">
              <div id="RightCorner" class="bigsprite">
                <div id="Logo">
                  <a href="{$Url}?ref=logo"><img class="Logo" src="{$UrlTheme}img/Logo.png" alt=
                  "Logo" /></a>
                </div>
                <div class="bigsprite" id="RightLogoPart">
                  <div id="UserNavPre">
                    <div class="bigsprite" id="UserNavLeft"></div>
                    <div id="UserNavTop">
                      <div id="UserNav">
                        {if $Session.Logged_Logged}<a href="{$UrlScript}Users/{$Session.Logged_User|escape:'url'}/" id="UserNick">{$Session.Logged_User}</a> | <a href="{$UrlScript}Users/{$Session.Logged_User|escape:'url'}/Edit">{$language.EditProfile}</a> | <a href="{$UrlScript}Messages/">{$language.Messages} (0/0)</a>{else}
						<a href="#Login" onclick='AjaxLoged();'><img src="{$URLS.Theme}img/blank.png" class="LoginIMG" alt="{$language.Login}" /></a> 
						<a href="{$URLS.Script}Facebook/?Path={$URLS.Path|substr:1}"><img src="{$URLS.Theme}img/blank.png" class="FacebookLogin" alt="{$language.Login} with Facebook" /></a>
						<a href="{$URLS.Script}GoogleID/?Path={$URLS.Path|substr:1}"><img src="{$URLS.Theme}img/blank.png" class="GoogleIMG" alt="{$language.Login} with Google" /></a>
						<a href="{$URLS.Script}OpenID/?Path={$URLS.Path|substr:1}" class="OpenIDLogin"><img src="{$URLS.Theme}img/blank.png" class="OpenIDIMG" alt="{$language.Login} with OpenID" /></a>
						{/if}
                      </div>
                    </div>
                    <div class="bigsprite" id="UserNavRight"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div id="HeaderSeperator"></div>
      <div id="MenuBG">
<!--/Header-->