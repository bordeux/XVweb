{capture name="ADVHeight"}
	<script type="text/javascript">
		<!--
		google_ad_client = "pub-7650113987924443";
		/* 728x90, utworzono 10-05-30 */
		google_ad_slot = "5148700426";
		google_ad_width = 800;
		google_ad_height = 90;
		//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<script type="text/javascript">
	{if $smarty.cookies.adblock != "tak"}
		{literal}
		setTimeout(function(){
		if($("div#RTop").height() == 0){
			$.get(UrlScript+'System/AdBlock', function(data) {
				CreateWindowLayer("AdBlock", data, "#ff0000");
				document.cookie = "adblock=tak; expires=Fri, 13 Jul 2044 05:28:21 UTC; path=/";
			});
		}
		}, 2000);
		{/literal}
	{/if}
		</script>
	{*<a href="{$URLS.Site}Write/"><img src="{$URLS.Theme}img/baner.jpg" alt="BlinkSport.pl" /></a>*}
{/capture}
{capture name="ADVCenter"}
	<script type="text/javascript">
		<!--
		google_ad_client = "pub-7650113987924443";
		/* 728x90, utworzono 10-05-30 */
		google_ad_slot = "5148700426";
		google_ad_width = 800;
		google_ad_height = 90;
		//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
{/capture}
{capture name="ADVInfo"}
	<script type="text/javascript">
		<!--
		google_ad_client = "pub-7650113987924443";
		/* 728x90, utworzono 10-05-30 */
		google_ad_slot = "5148700426";
		google_ad_width = 800;
		google_ad_height = 90;
		//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
{/capture}
{capture name="ADVFooter"}
	<script type="text/javascript">
		<!--
		google_ad_client = "pub-7650113987924443";
		/* 468x15, utworzono 10-05-31 */
		google_ad_slot = "6034680391";
		google_ad_width = 468;
		google_ad_height = 15;
		//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
{/capture}