<!-- Content -->
 <div id="Content">
	<div class="xvauction-main" >

{include file="xvauctions_theme/add_categories_nav.tpl" inline}

		<div class="xvauction-add">
		
			<div class="xvauction-list">
				<ul>
					<li><img src="{$URLS.Theme}xvauctions_theme/img/wait.gif" alt="{"xca_please_wait"|xv_lang}" /></li>
				</ul>
			</div>
			<div class="xvauction-next">
				<form action="?step=descriptions" method="post">
				<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
					<p>{"xca_selected_category"|xv_lang} : <span class="xvauction-next-category-span"></span></p>
					<input type="hidden" name="category" value="{$xvauctions_category|escape:'html'}" class="xvauction-next-category" />
					<input type="submit" value="{'xca_next'|xv_lang}"  disabled="disabled" class="xvauction-next-submit" />
				
				</form>
				
			</div>
				
	</div>
	
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->