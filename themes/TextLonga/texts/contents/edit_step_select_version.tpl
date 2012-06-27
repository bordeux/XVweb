<!-- Content -->
<div class="xv-text-wrapper xv-texts-select-version">
	<h2>Wybierz wersję źródłową: </h2>
	<form action="{$URLS.Script}edit/select_editor/" method="post" class="xv-texts-select-version-form xv-table">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
		<table style="width : 100%; text-align: center;">
				<thead> 
					<tr>
						<th>Select</th>
						<th>Data</th>
						<th>Użytkownik</th>
						<th>Opis zmian</th>
						<th>Język</th>
						<th></th>
					</tr>
				</thead> 
				<tbody> 
				{foreach from=$xv_texts_versions item=xv_texts_version_item}
					<tr>
						<td><input type="radio" name="texts[version]" value="{$xv_texts_version_item.Date}" /></td>
						<td>{$xv_texts_version_item.Date}</td>
						<td><a href="{$URLS.Script}/Users/{$xv_texts_version_item.User}/" target="blank">{$xv_texts_version_item.User}</a></td>
						<td>Coś tam coś tam</td>
						<td>{$xv_texts_version_item.Lang}</td>
						<td>Aktualna</td>
					</tr>
				{/foreach}
				</tbody> 
			</table>
			<div class="xv-texts-next">
				<input type="submit" value="Dalej" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->