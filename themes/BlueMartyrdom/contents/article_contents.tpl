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
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
				<a href="{$UrlScript}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{$language.History}</a>
			</li>
			{if "EditArticle"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
					<a href="{$UrlScript}Write/?Edit&amp;id={$ReadArticleIndexOut.ID}"  style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditArticle}</a>
				</li>
			{/if}
			{if "DeleteVersion"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
					<a href="#DeleteVersion" title="{$language.DeleteArticleVersion}" onclick="DeleteVersionArt({$ReadArticleIndexOut.ID}, {$ReadArticleOut.Version}); return false;"  style="padding-left:20px;"> <span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.DeleteArticleVersion}</a>
				</li>
			{/if}
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button  ui-icon ui-icon-zoomin"></span>
			</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button ui-icon ui-icon-zoomout"></span>
			</li>		
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<a href="{$UrlScript}Contact/?url=" style=" padding:0px;" id="Report"><span class="ui-button  ui-icon ui-icon-flag"></span></a>
			</li>
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<a href="{$UrlScript}RSS/{if $ReadArticleIndexOut.URL}?rss={$ReadArticleIndexOut.URL|escape:"url"}{/if}" style=" padding:0px;" title="RSS"><span class="ui-button  ui-icon ui-icon-signal-diag"></span></a>
			</li>
			{if "EditTags"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
				<span class="ui-button  ui-icon ui-icon-tag" onclick="EditTag('{$ReadArticleIndexOut.ID}', '{$ReadArticleIndexOut.Tag}'); return false;"  id="EditTagButton" title="{$language.Tags}"></span>
				</li>
			{/if}
		{if "DeleteArticle"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
				<span class="ui-button  ui-icon ui-icon-trash" title="{$language.DeleteArticle}" onclick="DeleteArticle({$ReadArticleIndexOut.ID}, '{$ReadArticleIndexOut.Topic|escape:'html'}'); return false;"></span>
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
		
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
			{if $smarty.foreach.minimap.last}
				{$Value.Name}
			{else}
				<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/blank.png" class="cssprite SpaceIconIMG" alt="&gt;&gt;"/>
			{/if}
		{/foreach}
		</div>
	</div>
	

<div id="TextDiv">
<!-- TEXT -->
{if $ReadArticleIndexOut.Accepted == "no"}
	{$ReadArticleIndexOut.AcceptedMsg}
{/if}
<div id='FinallContent'>
{$Content}
</div>
{if $Divisions}
<hr />
{foreach from=$Divisions item=Column key=ColumnNO}
{if $Column}
<div class="DivisionsColumn" id="Column{$ColumnNO}">
{foreach from=$Column item=Value key=CharDivision}

	<li><span>{$CharDivision}</span>
	<ul>
		{foreach from=$Value item=ArticleLink}
		<li><a href="{$UrlScript}{$ArticleLink.URL|substr:1|replace:' ':'_'}" id="art-{$ArticleLink.ID}">{$ArticleLink.Topic}</a></li>
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