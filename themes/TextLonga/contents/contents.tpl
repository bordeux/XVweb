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
				<a href="{$UrlScript}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{$language.History}</a>
			</li>
		</ul>
		
				
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map" style="float:left; position:absolute;">
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
{$Content}
<!-- TEXT -->
</div>
{if $LoadInfo}
	{include  file='info.tpl'}
{/if}
{if $LoadComment}
	{include  file='comment.tpl'}
{/if}
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->