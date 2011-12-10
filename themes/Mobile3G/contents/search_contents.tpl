<div data-role="page" id="xv-main-page-id" data-theme="c">
	<div data-role="header"> 
	<a href="#xv-menu-id" data-role="button" data-theme="b" data-transition="flip">Menu</a>
		<h1>{$SiteTopic}</h1> 
	<a href="{$URLS.Script}" data-icon="home" data-iconpos="notext" data-direction="reverse" data-theme="b" data-transition="slidedown">Home</a>
	</div><!-- /header -->
	<!--CONTENT -->
	
	{if $JoinForm == false}
	<div data-role="fieldcontain">
		<form action="{$UrlScript}Search/" method="get" name="SearchForm">
				<label for="search">Search Input:</label>
				<input type="search" name="Search" id="search" value="{$smarty.get.Search|escape:'html'}" />

				<input type="checkbox" name="AllVersion" id="xv-all-version-id" {if $smarty.get.AllVersion == true}checked="checked"{/if} class="custom" />
				<label for="xv-all-version-id">Szukaj w wszyskich wersjach</label>
				<input type="submit" value="Search" data-icon="search" />
		</form>
	</div>
	<hr />
{/if}


	{$Pager.0}
	{if empty($SearchArray)}
		<div style="text-align: center; margin:10px; font-weight: bold; ">{$language.NotFoundKeyword|sprintf:$smarty.get.Search|escape:"html"}</div>
		{else}
		<ul data-role="listview">
			{foreach from=$SearchArray item=SearchResult} 
				<li>
					<a href="{$UrlScript}{$SearchResult.URL|substr:1|replace:' ':'_'}{if $smarty.get.AllVersion == true}?version={$SearchResult.Version}{/if}"> 
						<h3>{$SearchResult.Topic}</h3> 
						<p style="color:#1C8C1C; font-weight:bold;">{$URLS.Script}{$SearchResult.URL|substr:1}</p> 
						<p>{$SearchResult.Contents}</p> 
						<p class="ui-li-aside">{math equation="round(x*10)" x=$SearchResult.Relevance}% {$language.Relevance} </p>
					</a>
				</li>
			{/foreach}
		</ul>
		{/if}
	{$Pager.1}
	<div style="clear:both"></div>
	
	<!--/CONTENT -->
{include  file='footer-main.tpl' inline}
</div><!-- /page xv-main-id -->