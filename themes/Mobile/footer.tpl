<!-- Footer -->
				{if $Advertisement}
					<div class="reklamo" id="RFooter">
						{$smarty.capture.ADVFooter}
					</div>
				{/if}
<div id="Footer">
	<div id="NavBottom">
		
			<a href="?mobile=false">{$language.FullVersion}</a>  |  
			<a href="?mobile=3g">iPhone version</a>  |  
			<a href="">{$language.MainPage}</a>  |  
			<a href="">Kontakt</a>
		
	</div>
	<div id="SearchForm">
        <form action="{$URLS.Script}Search/" method="get" name="SearchForm" id="SearchForm">
            {$language.Search}: <input accesskey="s" type="text" name="Search" class="Search" value="" id="SearchField" /> <input type="submit" value="{$language.Search}" id="SearchButton" />
        </form>
	</div>
</div>
<script type="text/javascript">
	{foreach from=$JSVars key=k item=vs}
	var {$k} = '{$vs|escape:'quotes'}';
	{/foreach}
	//{$JSBinder|@sort}
</script>
	<script type="text/javascript" src="{$UrlTheme}js/jquery.js" charset="UTF-8"></script>
	<script type="text/javascript" src="{$UrlTheme}js/mobile.js" charset="UTF-8"></script>
	{foreach from=$JSLoad item=JSLink}
		<script type="text/javascript" src="{$JSLink}"  charset="UTF-8"></script>
	{/foreach}
</body>
</html>