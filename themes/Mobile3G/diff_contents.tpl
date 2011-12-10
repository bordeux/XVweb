  <!-- Content -->
 <div id="Content">
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
<div id="ContentDiv">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
		{$Value.Name}
		{else}
		<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div class="xv-text-wrapper">
<!-- TEXT -->
<div class="diff">
{$Diff.Result}
</div>
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->