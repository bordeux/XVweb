<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
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
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
				<a href="{$URLS.Script}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{$language.History}</a>
			</li>
		</ul>
		
				
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map" style="float:left; position:absolute;">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic}</h1>
		</div>
	</div>
<div class="xv-text-wrapper">
<!-- TEXT -->
<div class="LightBulbTip" style="background-color: rgba(255, 250,228, 0.8);">
				{$Content}
				<img src="{$UrlTheme}img/LightbulbIcon.png" alt="Tip" /> {$language.ArticleNotFoundContent|replace:"<create>":"<a href='`$Url`write/?url=`$PathInfo`' style='font-weight: bold;'>"|replace:"</create>":"</a>"|replace:"<tocreate>":"<a href='`$Url`write/?url=/SuggestCreation`$PathInfo`' style='font-weight: bold;'>"|replace:"</tocreate>":"</a>"}
				<center><a href="{$Url}Write/?url={$PathInfo}" title="{$language.Write}" ><img src="{$UrlTheme}img/add_page.png" alt="{$language.Write}" /></a></center>
				</div>
{$Pager.0}
					{if empty($SearchArray)}
		<div style="text-align: center; margin:10px; font-weight: bold; ">{$language.NotFoundKeyword|sprintf:$smarty.get.Search|escape:"html"}</div>
		{else}
		<br />{$language.ResultSearch}:
			{foreach from=$SearchArray item=SearchResult}
				<div id="Search-ID" style="background-color:#F8F8F8;">
					<div id="TitleSearch-ID" style="font-size:15px; margin-top:10px; font-weight: bold;">
						<a href="{$URLS.Script}{$SearchResult.URL|substr:1|replace:' ':'_'}?version={$SearchResult.Version}">{$SearchResult.Topic}</a>
					</div>
					<div id="DescriptionSearch-ID"> 
						<div style="margin-left:10px;">
							{$SearchResult.Contents}
						</div>
					</div>
					<div id="FooterSearch-ID" style="font-size: 11px; color : #1C8C1C; ">
					{$URLS.Script}{$SearchResult.URL|substr:1|replace:' ':'_'} -  {$SearchResult.StrByte} B {$SearchResult.Lenght} Char {math equation="round(x*10)" x=$SearchResult.Relevance}% {$language.Relevance} 
					</div>
				</div> 
				<hr />
		{/foreach}
		{/if}
{$Pager.1}
<!-- TEXT -->
</div>

</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->