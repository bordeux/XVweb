<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	<div class="category_parents_tree" >
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xv_lang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}">{"xca_auctions_panel"|xv_lang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}/payment_add/">{$Title}</a> 
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">{$Title}</div>
		</div>
		<div>
		{if $payments_mode == "select_method"}
			<div style="padding: 20px;">
				<div class="LightBulbTip" style="width: 90%; margin: auto;">
					<div style="margin: 20px; text-align:center;">{"xca_select_payment_method"|xv_lang}</div>
					
					<div style="margin: 20px; text-align:center;">
						 {foreach from=$payments_buttons item=payment}
							{$payment}
						 {/foreach}
					</div>
				
				</div>
	
			<div style="clear:both;"></div>
		</div>
		{/if}
		{if $payments_mode == "form"}
			<div style="padding: 20px;">
				<div class="LightBulbTip" style="width: 90%; margin: auto;">
						{$payments_form}
				</div>
	
			<div style="clear:both;"></div>
		</div>
		{/if}
		{if $payments_mode == "other"}
			{$payments_content}
		{/if}
	
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->