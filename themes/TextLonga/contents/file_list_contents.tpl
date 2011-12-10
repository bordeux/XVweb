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
			
			<h1 class="xv-topic">{$SiteTopic|default:"Files list"}</h1>
		</div>
	</div>

<div class="xv-text-wrapper">

<!-- TEXT -->
{$Content}
	<div class='xv-table'>
			<table style="width : 100%; text-align: center;">
				<caption>{$Pager.0}</caption>
				<thead> 
					<tr>
						 <th>{$language.IDFile}</th>
						 <th>{$language.FileName}</th>
						 <th>{$language.AddedDate}</th>
						 <th>{$language.Downloads}</th>
						 <th>{$language.OwnerFile}</th>
						 {if $ViewCode}
							<th>{$language.CodeToArticle}</th>
						 {/if}
					</tr>
				</thead> 
				<tbody> 
{foreach from=$FileList item=FileArray}
			<tr>
				<td>{$FileArray.ID}</td>
				<td><a href="{$UrlScript}File/{$FileArray.ID}/">{$FileArray.FileName}.{$FileArray.Extension}</a></td>
				<td>{$FileArray.Date}</td>
				<td>{$FileArray.Downloads}</td>
				<td><a href="{$UrlScript}Users/{$FileArray.UserFile|escape:'url'}/" >{$FileArray.UserFile}</a></td>
				{if $ViewCode}
				<td><input type="text" value="&lt;file id=&quot;{$FileArray.ID}&quot; /&gt;" /></td>
				{/if}
			</tr>
{/foreach}
				</tbody> 
			</table>
			<div class="xv-table-pager">
			{$Pager.1}
			</div>
	</div>
	</div>
<!-- TEXT -->
<div style="clear:both;"></div>
</div>

	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>
	
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->