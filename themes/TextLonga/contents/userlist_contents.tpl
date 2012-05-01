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
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic}</h1>
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
						<td class="column1"></td> 
						<th>{$language.User}</th>
						<th>{$language.CreatedDateAccount}</th>
						<th>{$language.GaduGadu}</th>
						<th>{$language.WhereFrom}</th>
					</tr>
				</thead> 
				<tbody> 
				{foreach from=$UserList item=UserArray}
				<tr>
					<td>
						<a href="{$URLS.Script}Users/{$UserArray.User|urlrepair}"><img src="{$AvantsURL}{if $UserArray.Avant}{$UserArray.User}{/if}_16.jpg" alt="{$UserArray.User}"/></a>
						{if $UserArray.OpenID}<a href="{$UserArray.OpenID}"> <img src="{$UrlTheme}img/openid.png" /></a>{/if}
					</td>
					<td><a href="{$URLS.Script}Users/{$UserArray.User|urlrepair}">{$UserArray.User}</a></td>
					<td>{$UserArray.Creation}</td>
					<td>{if $UserArray.GaduGadu}<a href="gg:{$UserArray.GaduGadu}"><img src="http://status.gadu-gadu.pl/users/status.asp?id={$UserArray.GaduGadu}&amp;styl=0" title="{$UserArray.GaduGadu}" alt="{$UserArray.GaduGadu}" /> {$UserArray.GaduGadu}</a>{/if}</td>
					<td>{$UserArray.WhereFrom}</td>
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