<!-- Content -->

{include file="users/edit_panel.tpl"}

<div class="xv-text-wrapper">
<!-- TEXT -->
<div class="xv-user-content">
{foreach from=$fields_html key=k item=field_html}
	{$field_html}
{/foreach}
</div>
<!-- TEXT -->
<div style="clear:both;"></div>
</div>
	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>

<div style="clear:both;"></div>
 <!-- /Content -->