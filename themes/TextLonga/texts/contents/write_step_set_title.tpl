<!-- Content -->
<div class="xv-text-wrapper xv-texts-select-editor">
	<h2>Tytuł strony: </h2>
	<form action="{$URLS.Script}write/select_editor/" method="post" class="xv-texts-title-form">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
			Tytuł strony: <input type="text" value="{$Session.xv_texts_title|escape}" name="texts[title]" class="xv-texts-title-input"			/>
			<div class="xv-texts-url">Spodziewany URL: {$xv_texts_category}<span>___</span>/</div>
			
			<div class="xv-texts-next">
				<input type="submit" value="Dalej" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->