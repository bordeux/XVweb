<!-- Content -->
 <div id="Content">
	<div class="xvauction-main" >

{include file="xvauctions/add_categories_nav.tpl" inline}

		<div class="xvauction-add">
		{if $smarty.get.try_edit_category}
			<div class="error">{"xca_you_cant_edit_category"|xv_lang}</div>
		{/if}
			<form class="xvauction-add-form" action="?step=descriptions" enctype="multipart/form-data" method="post">
			<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
				<div class="xvauction-add-item">
					<div class="xvauction-add-name">
					{"xca_category"|xv_lang} :
						<div class="xvauction-add-name-desc">
							<a href="?step=category">  [{"xca_change"|xv_lang}]</a>
						</div>
					</div>
					<div class="xvauction-add-input"> 		
						<a href="{$URLS.Auctions}/" target="_blank">{"xca_main_category"|xv_lang}</a> 
						
						{foreach from=$auctions_category_tree item=cat_parent}
							&gt;&gt; <a href="{$URLS.Auctions}{$cat_parent.Category}" target="_blank">{$cat_parent.Name}</a> 
						{/foreach}
						
						<div class="xvauction-add-input-desc">
							{"xca_if_you_want_change_category"|xv_lang} <a href="?step=category">  [{"xca_change"|xv_lang}]</a>
						</div>
					</div>
					<div class="clear"></div>
				</div>	
				
			{$xvauctions_fields|@implode:' '}
				
				
				<div class="xvauction-add-item">
					<input type="submit" name="check" value="{'xca_auction_preview'|xv_lang}" />
					<input type="submit" name="save" value="{'xca_save'|xv_lang}" />
				</div>
				
			</form>
				
		</div>
	
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->