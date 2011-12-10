<!-- Content -->
 <div id="Content">
	<div class="xvauction-main" >

{include file="xvauctions_theme/add_categories_nav.tpl" inline}

		<div class="xvauction-add">
		
			asdasdasd
				
		</div>
	<div style="clear:both"></div>
		<div class="xvauction-description">
				<div class="xvauction-description-caption">{"xca_description"|xvLang}</div>
				<div class="xvauction-description-content">
				<!-- AUCTION CONTENT -->
						{$smarty.post.add.description}
				
				<!-- END AUCTION CONTENT -->
					<div style="clear:both;"></div>
				</div>
				
		</div>
		
		<div style="clear:both;"></div>
		
		<div><form action="?" method="get" style="text-align:center;">
			<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
			<input type="hidden" name="step" value="save" />
		<input type="submit" value="Wystaw licytacje" /></form></div>
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->