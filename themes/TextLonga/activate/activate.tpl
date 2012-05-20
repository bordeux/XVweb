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

<div class="xv-text-wrapper">
{if $activate_result}
	<div class="success">{"activate_success"|xv_lang}</div>
{else}
	<div class="error">{"activate_failed"|xv_lang}</div>
{/if}
</div>
		

<!-- TEXT -->
<div style="clear:both;"></div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->