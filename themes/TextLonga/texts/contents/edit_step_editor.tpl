<!-- Content -->
<div class="xv-text-wrapper xv-texts-editor">
	<form action="{$URLS.Script}edit/set_changes/" method="post" class="xv-texts-editor-form">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
			<div class="xv-texts-editor-content">
				{$xv_texts_editor_html}
			</div>
			
			<div class="xv-texts-next">
				<input type="submit" value="Dalej" />
			</div>
	</form>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->