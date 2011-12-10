<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
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
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
<!-- TEXT -->

{if $JoinForm == false}
<form action="{$UrlScript}Search/" method="get" name="SearchForm">
	{$language.Search}: <input accesskey="s" type="text" name="Search" value="{$smarty.get.Search|escape:'html'}" class="Search" />
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
{$Content}
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->