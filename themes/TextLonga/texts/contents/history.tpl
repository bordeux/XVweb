<!-- Content -->
<div class="xv-text-wrapper xv-texts-select-version">
	<h2>Wersje strony: </h2>
	<form action="?" method="post" class="xv-texts-select-version-form xv-table">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
		<table style="width : 100%; text-align: center;">
				<thead> 
					<tr>
						{if "texts_set_version"|xv_perm}<th>Select</th>{/if}
						<th>{'txts_date'|xv_lang}</th>
						<th>{'txts_author'|xv_lang}</th>
						<th>{'txts_changes_description'|xv_lang}</th>
						<th></th>
					</tr>
				</thead> 
				<tbody> 
				{foreach from=$xv_texts_versions item=xv_texts_version_item}
					<tr>
						{if "texts_set_version"|xv_perm}<td><input type="radio" name="texts[version]" value="{$xv_texts_version_item.Date}" {if $xv_texts_version_item.IsActual}checked="checked"{/if} /></td>{/if}
						<td><a href="{$URLS.Script}{$xv_texts_page|substr:1}?date={$xv_texts_version_item.Date|escape:'url'}" target="blank">{$xv_texts_version_item.Date}</a></td>
						<td><a href="{$URLS.Script}/Users/{$xv_texts_version_item.User}/" target="blank">{$xv_texts_version_item.User}</a></td>
						<td>{if $xv_texts_version_item.Changes}{$xv_texts_version_item.Changes|escape}{else}-----{/if}</td>
						<td>{if $xv_texts_version_item.IsActual}{'txts_actual'|xv_lang}{/if}</td>
					</tr>
				{/foreach}
				</tbody> 
			</table>
			<div class="xv-texts-next">
				<input type="submit" value="{'txts_change'|xv_lang}" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->