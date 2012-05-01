<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
				{$Content}
			<!-- TEXT -->
			<div style="clear:both;"></div>
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