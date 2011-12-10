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
@import url({$Video.Theme}style.css);
/*]]>*/
</style>
<script type="text/javascript" src="{$URLS.Site}plugins/libraries/jquery/jquery.js" charset="UTF-8"> </script>  
<script src="http://www.cacaoweb.org/js/cacaoweb.api.js" type="text/javascript"></script>
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
	
var CacaowebChecked = false;
var CacaowebLastStatus = "";
	Cacaoweb.periodicalExecuter(function(status){
	$(".mvoption").hide();
			if (status == 'Off') {
						if(CacaowebChecked == false){
							alert("Nie masz zainstalowanego dodatku CacaoWeb - jest to dodatek do darmowego oglądania filmów z Megavideo. Więcej informacji o nim po prawej stronie ->>>>>");
						}
						
			CacaowebChecked = true;	
			} else if (status == 'On') {
			if(CacaowebLastStatus != status || CacaowebChecked == false)
				$("#WebPlayer").html('<object width="800" height="430"> <param name="allowScriptAccess" value="always" /> <param name="allowFullScreen" value="true" /> <param name="quality" value="best" /> <param name="bgcolor" value="#000000" /> <param name="flashvars" value="file=http://127.0.0.1:4001/megavideo/megavideo.caml?videoid={$Video.ID}" /> <param name="movie" value="http://www.cacaoweb.org/player/currentplayer.swf" /> <embed src="http://www.cacaoweb.org/player/currentplayer.swf"  flashvars="file=http://127.0.0.1:4001/megavideo/megavideo.caml?videoid={$Video.ID}"  quality="best" bgcolor="#000000"  width="800" height="430" allowScriptAccess="always" enablejs="true" allowFullScreen="true"  type="application/x-shockwave-flash" /></object>');
				$("#CacaowebMonit").hide("slow");
			CacaowebChecked = true;
			}
		CacaowebLastStatus = status;
	});
	
	function AjaxCounterOnline() {

			$.getJSON(URLS.Script + "online/get.js", {
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
	<a href="{$URLS.Site}"><img src="{$URLS.Site}plugins/data/megavideo/theme/logo.png" /></a>
</div>
<div style="float:left; padding-left:10px;">
<a href="?video=article"><img src="{$Video.Thumbnail}" style="height:40px;"/></a>
</div>
<div id="Description">
	<div id="Title">
		<a href="?video=article">{$SiteTopic}</a>
	</div>
	<div id="Informations">
		<a href="?video=comments">{$language.Comments|strtolower}: (<b>{$Video.Comments}</b>)</a>
		<a href="{$Video.Megavideo}">Źródło: Megavideo.com</a>
		<div id="EditPanel">
				{if  $Session.Logged_Logged}
				
					{if $ReadArticleIndexOut.Observed}<a href="?Watch=0&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.UnWatch}">{$language.UnWatch}</a>{else}<a href="?Watch=1&amp;SIDCheck={$JSVars.SIDUser|md5}&amp;frame=true" title="{$language.Watch}">{$language.Watch}</a>{/if}
					
				
					{if $ReadArticleIndexOut.Bookmark}<a href="?Bookmark=0&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.AddBookmark}">{$language.AddBookmark}</a>{else}<a href="?Bookmark=1&amp;SIDCheck={$JSVars.SIDUser}&amp;frame=true" title="{$language.DeleteBookmark}">{$language.DeleteBookmark}</a>{/if}
				
			{/if}
		</div>
	</div>
</div>
<div id="CloseFrame">
	<a href="{$Video.Link}"><img src="{$URLS.Site}plugins/data/megavideo/theme/close.png" /></a>
</div>
</div>
<div id="Content">
	<div id="LeftSideBar" style="position: absolute; left: 0;top: 0px; width: 200px; height: 200px; top: 50px; padding-left:20px; padding-top:50px;">
	<table>
    <tr>
      <td><a href="?video=article"><img src="{$Video.Thumbnail}" /></a></td>
    </tr>
    <tr>
      <td style="font-size:10px;">{$Video.Description}
	  
		{if $QuickSearch}
			<div class="xv-quick-search">
				<h3>Zobacz też:</h3>
					<ul>
				{foreach from=$QuickSearch item=QuickLink}
							<li><a href="{$URLS.Script}{$QuickLink.URL|substr:1|replace:' ':'_'}" class="xv-quick-search-link">{$QuickLink.Topic}</a></li>
				{/foreach}
				</ul>
			</div>
		{/if}	  
	  </td>
    </tr>
</table>
	</div>
	<div id="WebPlayer" style="margin: 0 200px; height: 400px;  text-align:center; padding-top:60px;">
<object width="800" height="430"><param name="movie" value="http://www.megavideo.com/v/{$Video.ID}"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.megavideo.com/v/{$Video.ID}" type="application/x-shockwave-flash" allowfullscreen="true" width="800" height="430"></embed></object>	
	</div>
	<div id="RightSidebar" style="position: absolute; right: 0; top: 50px; width: 200px; height: 200px;">
		<div id="CacaowebMonit" style="text-align:center; padding-left:20px; ">
			<a href="http://www.cacaoweb.org/" target="_blank"><img src="http://www.cacaoweb.org/images/logo.png" style="width:150px;" /></a> <br />
			<b>Oglądaj filmy bez limitu 100% za DARMO!</b>
			<p>Ściągnij program CacaoWeb - jest to program wpełni darmowy, zajmuje tylko 1mb. Dzięki niemu będziesz mógł oglądać więcej niż 72min filmu</p>
			
			<p><a href="http://www.cacaoweb.org/" onclick="Cacaoweb.download(); return false;"><img src="http://img221.imageshack.us/img221/74/downloadbuttonu.png" /></a></p>
		</div>
		{*
			<script type="text/javascript"><!--
				google_ad_client = "pub-7650113987924443";
				/* 120x600, utworzono 11-01-16 */
				google_ad_slot = "2402004163";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>*}

	</div>
</div>
<div style="clear:both"></div>
<div id="Footer" style="text-align:center; background:#000;">
	{*<script type="text/javascript"><!--
	google_ad_client = "pub-7650113987924443";
	/* 728x90, utworzono 11-01-16 */
	google_ad_slot = "9112363366";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>*}
</div>
</body>
</html>