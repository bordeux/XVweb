<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	<div class="category_parents_tree" >
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xvLang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}">{"xca_auctions_panel"|xvLang}</a> 
			&gt;&gt; {"xca_finish_auction"|xvLang}
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">{"xca_finish_auction"|xvLang}</div>
		</div>
		<div>
			{if $finished}
				<div class="success"> 
				{"xca_sale_finished"|xvLang}
				
				<p> <a href="{$URLS.Auction}/{$auction_info.ID}/" >{"xca_go_to_auction"|xvLang}</a></p>
				</div>
			{else}
			<div style="padding: 20px;">
				<div class="LightBulbTip" style="width: 600px; margin: auto;">
				{"xca_finish_auction_question"|xvLang} <a href="{$URLS.Auction}/{$auction_info.ID}/" target="_blank">{$auction_info.Title}</a> ?
				 </div>
							<form action="?transfer=true" method="post" style="text-align:center; padding: 10px; width: 300px; margin:auto;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="finish" value="true"/>
								<a href="{$URLS.AuctionPanel}/selling/" style="margin-right: 20px;">{"xca_back"|xvLang}</a> 
								<input type="submit" value="{'xca_finish'|xvLang}" />
							</form>
				
			</div>
			{/if}
			<div style="clear:both;"></div>
		</div>
	
	
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->