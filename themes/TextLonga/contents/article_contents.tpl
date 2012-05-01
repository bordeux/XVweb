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
				<a href="{$URLS.Script}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{$language.History}</a>
			</li>
			{if "EditArticle"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
					<a href="{$URLS.Script}Write{$ReadArticleIndexOut.URL|replace:' ':'_'}?Edit&amp;id={$ReadArticleIndexOut.ID}"  style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditArticle}</a>
				</li>
			{/if}
			{if "DeleteVersion"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
					<a href="{$URLS.Script}Receiver/DLVA?ArticleID={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.DeleteArticleVersion}" class="xv-delete-article-version"  style="padding-left:20px;"> <span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.DeleteArticleVersion}</a>
				</li>
			{/if}
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button  ui-icon ui-icon-zoomin xv-zoom" data-xv-zoom="+1px"></span>
			</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button ui-icon ui-icon-zoomout xv-zoom" data-xv-zoom="-1px"></span>
			</li>		
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<a href="{$URLS.Script}Contact/?url={$URLS.Path|escape:'url'}&amp;topic=copyright" style=" padding:0px;"  class="xv-article-report"><span class="ui-button  ui-icon ui-icon-flag"></span></a>
			</li>
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<a href="{$URLS.Script}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:"url"}{/if}" style=" padding:0px;" title="RSS"><span class="ui-button  ui-icon ui-icon-signal-diag"></span></a>
			</li>
			{if "EditTags"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
				<span class="ui-button  ui-icon ui-icon-tag" onclick="EditTag('{$ReadArticleIndexOut.ID}', '{$ReadArticleIndexOut.Tag}'); return false;"  id="EditTagButton" title="{$language.Tags}"></span>
				</li>
			{/if}
		{if "DeleteArticle"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<a href="{$URLS.Script}Receiver/DA?&ArticleID={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="xv-delete-article" style="padding:0px"><span class="ui-button  ui-icon ui-icon-trash " title="{$language.DeleteArticle}" ></span></a>
				</li>
			{/if}
			
						{if  $Session.Logged_Logged}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
				
					{if $ReadArticleIndexOut.Observed}<a href="?Watch=0&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.UnWatch}" style="padding:0px;"><span class="ui-button  ui-icon ui-icon-pin-w" title="{$language.UnWatch}"></span></a>{else}<a href="?Watch=1&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.Watch}" style="padding:0px;"><span class="ui-button  ui-icon ui-icon-pin-s" title="{$language.Watch}" ></span></a>{/if}
				</li>	
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					{if $ReadArticleIndexOut.Bookmark}<a href="?Bookmark=0&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.AddBookmark}" style="padding:0px;"><span class="ui-button  ui-icon ui-icon-star" ></span></a>{else}<a href="?Bookmark=1&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.DeleteBookmark}" style="padding:0px;"><span class="ui-button  ui-icon ui-icon-cancel" ></span></a>{/if}
				</li>
			{/if}
			
			
		</ul>
		
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map">
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
{if $ReadArticleIndexOut.Accepted == "no"}
	{$ReadArticleIndexOut.AcceptedMsg}
{/if}
<div class="xv-text-content">
{$Content}
</div>
{if $QuickSearch}
	<div class="xv-quick-search">
		<h3>Zobacz też:</h3>
			<ul>
		{foreach from=$QuickSearch item=QuickLink}
					<li><a href="{$URLS.Script}{$QuickLink.URL|substr:1|replace:' ':'_'}" class="xv-quick-search-link">{$QuickLink.Topic}</a></li>
		{/foreach}
		</ul>
		<script type="text/javascript"><!--
			google_ad_client = "ca-pub-7650113987924443";
			/* Zobacz też - linki */
			google_ad_slot = "8483204690";
			google_ad_width = 200;
			google_ad_height = 90;
			//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
{/if}
{if $Divisions}
<hr />
{foreach from=$Divisions item=Column key=ColumnNO}
{if $Column}
<div class="DivisionsColumn" id="Column{$ColumnNO}">
{foreach from=$Column item=Value key=CharDivision}

	<li><span>{$CharDivision}</span>
	<ul>
		{foreach from=$Value item=ArticleLink}
		<li><a href="{$URLS.Script}{$ArticleLink.URL|substr:1|replace:' ':'_'}" id="art-{$ArticleLink.ID}">{$ArticleLink.Topic}</a></li>
		{/foreach}
	</ul>
	</li>

{/foreach}
</div>
{/if}
{/foreach}

{/if}

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