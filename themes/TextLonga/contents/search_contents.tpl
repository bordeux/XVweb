<!-- Content -->
 <div id="Content">
<div id="ContentDiv">
	{if $smarty.get.msg}
		<div class="{if $smarty.get.success}success{else}failed{/if}">
		{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
			{$smarty.get.msg|escape:"html"}
			{if $smarty.get.list}
			<ul>
				{foreach from=$smarty.get.list item=Value name=minimap}
				<li>{$Value|escape:"html"}</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	{/if}
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
				<a href="#" rel="xv-system-search-id" title="Search with system search module" style="padding-left:20px;" class="xv-tab"> 	
				<span class="ui-icon ui-icon-search" style="margin-left:-16px;"></span>{$language.SiteSearch|default:"Site Search"}
				</a>
			</li>
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ">
				<a href="#" rel="xv-google-search-id" title="Search with google" style="padding-left:20px;" class="xv-tab"> 		<span class="ui-icon ui-icon-search" style="margin-left:-16px;"></span>{$language.GoogleSearch|default:"Google Search"}
				</a>
			</li>
		</ul>
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic}</h1>
		</div>
	</div>

<div class="xv-text-wrapper">

<!-- TEXT -->
<div id="xv-system-search-id">
{if $JoinForm == false}
<form action="{$UrlScript}Search/" method="get" name="SearchForm">
	{$language.Search}: <input accesskey="s" type="search" name="Search" value="{$smarty.get.Search|escape:'html'}" class="Search" />
	<input type="checkbox" value="true" name="AllVersion" id="AllVersion" class="StyleForm" {if $smarty.get.AllVersion == true}checked="checked"{/if} /> <label for="AllVersion">Szukaj w wszyskich wersjach</label> 
	<input type="submit" value="{$language.Search}" class="StyleForm" /> 
</form>
	<br />
{/if}
{$Pager.0}
<hr />
	{if empty($SearchArray)}
		<div style="text-align: center; margin:10px; font-weight: bold; ">{$language.NotFoundKeyword|sprintf:$smarty.get.Search|escape:"html"}</div>
		{else}
			{foreach from=$SearchArray item=SearchResult}
				<div id="Search-ID" style="background-color:#F8F8F8;">
					<div id="TitleSearch-ID" style="font-size:15px; margin-top:10px; font-weight: bold;">
						<a href="{$UrlScript}{$SearchResult.URL|substr:1|replace:' ':'_'}{if $smarty.get.AllVersion == true}?version={$SearchResult.Version}{/if}">{$SearchResult.Topic}</a>
					</div>
					<div id="DescriptionSearch-ID"> 
						<div style="margin-left:10px;">
							{$SearchResult.Contents}
						</div>
					</div>
					<div id="FooterSearch-ID" style="font-size: 11px; color : #1C8C1C; ">
					{$UrlScript}{$SearchResult.URL|substr:1} -  {$SearchResult.StrByte} B {$SearchResult.Lenght} Char {math equation="round(x*10)" x=$SearchResult.Relevance}% {$language.Relevance} 
					</div>
				</div> 
				<hr />
		{/foreach}

{/if}
{$Pager.1}
</div>
<div id="xv-google-search-id">
{literal}
<div id="cse" style="width: 100%;">Loading</div>
<script src="//www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript"> 
  google.load('search', '1', {language : 'pl', style : google.loader.themes.SHINY});
  google.setOnLoadCallback(function() {
    var customSearchControl = new google.search.CustomSearchControl('013724345724155454559:WMX1242190816');
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    var options = new google.search.DrawOptions();
    options.setAutoComplete(true);
    customSearchControl.draw('cse', options);
	customSearchControl.execute({/literal}"{$smarty.get.Search|escape:'html'}"{literal});
  }, true);
</script>
 <style type="text/css">
  .gsc-control-cse {
    font-family: Arial, sans-serif;
    border-color: #ffffff;
    background-color: #ffffff;
  }
  input.gsc-input {
    border-color: #8A99A6;
  }
  input.gsc-search-button {
    border-color: #8A99A6;
    background-color: #D0D1D4;
  }
  .gsc-tabHeader.gsc-tabhInactive {
    border-color: #B2BDC6;
    background-color: #B2BDC6;
  }
  .gsc-tabHeader.gsc-tabhActive {
    border-color: #8A99A6;
    background-color: #8A99A6;
  }
  .gsc-tabsArea {
    border-color: #8A99A6;
  }
  .gsc-webResult.gsc-result,
  .gsc-results .gsc-imageResult {
    border-color: #FFFFFF;
    background-color: #FFFFFF;
  }
  .gsc-webResult.gsc-result:hover,
  .gsc-imageResult:hover {
    border-color: #D2D6DC;
    background-color: #EDEDED;
  }
  .gs-webResult.gs-result a.gs-title:link,
  .gs-webResult.gs-result a.gs-title:link b,
  .gs-imageResult a.gs-title:link,
  .gs-imageResult a.gs-title:link b {
    color: #0568CD;
  }
  .gs-webResult.gs-result a.gs-title:visited,
  .gs-webResult.gs-result a.gs-title:visited b,
  .gs-imageResult a.gs-title:visited,
  .gs-imageResult a.gs-title:visited b {
    color: #0568CD;
  }
  .gs-webResult.gs-result a.gs-title:hover,
  .gs-webResult.gs-result a.gs-title:hover b,
  .gs-imageResult a.gs-title:hover,
  .gs-imageResult a.gs-title:hover b {
    color: #0568CD;
  }
  .gs-webResult.gs-result a.gs-title:active,
  .gs-webResult.gs-result a.gs-title:active b,
  .gs-imageResult a.gs-title:active,
  .gs-imageResult a.gs-title:active b {
    color: #0568CD;
  }
  .gsc-cursor-page {
    color: #0568CD;
  }
  a.gsc-trailing-more-results:link {
    color: #0568CD;
  }
  .gs-webResult .gs-snippet,
  .gs-imageResult .gs-snippet {
    color: #5F6A73;
  }
  .gs-webResult div.gs-visibleUrl,
  .gs-imageResult div.gs-visibleUrl {
    color: #009900;
  }
  .gs-webResult div.gs-visibleUrl-short {
    color: #009900;
  }
  .gs-webResult div.gs-visibleUrl-short {
    display: none;
  }
  .gs-webResult div.gs-visibleUrl-long {
    display: block;
  }
  .gsc-cursor-box {
    border-color: #FFFFFF;
  }
  .gsc-results .gsc-cursor-box .gsc-cursor-page {
    border-color: #B2BDC6;
    background-color: #FFFFFF;
    color: #0568CD;
  }
  .gsc-results .gsc-cursor-box .gsc-cursor-current-page {
    border-color: #8A99A6;
    background-color: #8A99A6;
    color: #0568CD;
  }
  .gs-promotion {
    border-color: #D2D6DC;
    background-color: #D0D1D4;
  }
  .gs-promotion a.gs-title:link,
  .gs-promotion a.gs-title:link *,
  .gs-promotion .gs-snippet a:link {
    color: #0066CC;
  }
  .gs-promotion a.gs-title:visited,
  .gs-promotion a.gs-title:visited *,
  .gs-promotion .gs-snippet a:visited {
    color: #0066CC;
  }
  .gs-promotion a.gs-title:hover,
  .gs-promotion a.gs-title:hover *,
  .gs-promotion .gs-snippet a:hover {
    color: #0066CC;
  }
  .gs-promotion a.gs-title:active,
  .gs-promotion a.gs-title:active *,
  .gs-promotion .gs-snippet a:active {
    color: #0066CC;
  }
  .gs-promotion .gs-snippet,
  .gs-promotion .gs-title .gs-promotion-title-right,
  .gs-promotion .gs-title .gs-promotion-title-right *  {
    color: #333333;
  }
  .gs-promotion .gs-visibleUrl,
  .gs-promotion .gs-visibleUrl-short {
    color: #5F6A73;
  }
</style>
{/literal}
</div>
{$Content}
<!-- TEXT -->

<div style="clear:both;"></div>
</div>
{if $LoadInfo}
	{include  file='info.tpl' inline}
{/if}

	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>
	
{if $LoadComment}
	{include  file='comment.tpl' inline}
{/if}
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->