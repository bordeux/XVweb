<!-- Content -->
<div class="xv-text-wrapper xv-texts-set-changes">
	<h2>{'txts_changes_description'|xv_lang}: </h2>
	<form action="{$URLS.Script}edit/preview/" method="post" class="xv-texts-changes-form">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
			{'txts_changes_description'|xv_lang} : <input type="text" value="{$Session.xv_texts_changes|escape}" name="texts[changes]" class="xv-texts-changes-input"			/>
			
			<div class="xv-texts-next">
				<input type="submit" value="{'txts_next'|xv_lang}" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->