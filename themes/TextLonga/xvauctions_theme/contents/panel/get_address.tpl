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
			&gt;&gt; Dane kontrahenta
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">Dane kontrahenta</div>
		</div>
		<div style="padding: 20px;">
				<div class="LightBulbTip">
				<div style="font-size: 14px; font-weight:bold">Dane użytkownika {$user_data.User} :</div>
				<div style="padding-left: 50px;">
					{$user_data.Name} {$user_data.Vorname}</b> {$user_data.Corporation} <br />
					{$user_data.Street}<br />
					{$user_data.Zip} {$user_data.City}<br />
					{$user_data.State}<br />
					{$user_data.Country}<br />
				</div>


				</div>
			<div style="clear:both;"></div>
		</div>
	
	
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->