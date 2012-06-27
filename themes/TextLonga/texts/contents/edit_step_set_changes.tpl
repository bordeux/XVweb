<!-- Content -->
<div class="xv-text-wrapper xv-texts-set-changes">
	<h2>Opis zmian: </h2>
	<form action="{$URLS.Script}edit/preview/" method="post" class="xv-texts-changes-form">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
			Opis zmian : <input type="text" value="{$Session.xv_texts_changes|escape}" name="texts[changes]" class="xv-texts-changes-input"			/>
			
			<div class="xv-texts-next">
				<input type="submit" value="Dalej" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->