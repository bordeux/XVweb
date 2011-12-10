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
			&gt;&gt; Kasa płatności
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">Kasa płatności</div>
		</div>

		{if $smarty.get.error == "amount"}
			<div class="error"> Masz za mało środków na koncie. Musisz doładować konto </div>
		{/if}
		
		<form method="post" action="?pay=true">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
		<div class="xv-table">	
				<table>
					<thead> 
						<tr>	
							<th class="items-thumbnail" style="width: 70px;"></th>	
							<th class="items-description" style="width: 60%;">Tytuł</th>	
							<th class="items-cost">Cena/szt</th>	
							<th class="items-pieces">Sztuk</th>	
							<th class="items-sum">Razem</th>	
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="vertical-align: middle;">
								<a href="{$URLS.Auction}/{$bought_info.Auction}/" target="_blank">
									{if $bought_info.Thumbnail}
										<img src="{$URLS.Thumbnails}/{$bought_info.Thumbnail}" alt='{$bought_info.Title|escape:"html"}'/>
									{else}
										<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xvLang}'  />
									{/if}
								</a>
							</td>
							<td style="text-align:left; vertical-align: middle;">
								<a href="{$URLS.Auction}/{$bought_info.Auction}/" target="_blank">{$bought_info.Title|escape:"htmlall"}</a> (<span style="font-size:8px;">ID: {$bought_info.Auction}</span>)</td>
							<td style="vertical-align: middle;">{$bought_info.Cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang} </td>
							<td style="vertical-align: middle;">{$bought_info.Pieces}</td>
							<td style="vertical-align: middle;"><b style="color:#0F9100;">{($bought_info.Cost*$bought_info.Pieces)|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</b></td>
						</tr>						
						<tr>
							<td style="vertical-align: middle;"><b>Wysyłka</b></td>
							<td style="vertical-align: middle;">
										<select style="width: 90%;" name="shipment_method" id="shipment_method">
											{foreach from=$shipment_available_methods item=method}
												<option value="{$method.key}" class="shipment-method-{$method.key}" data-cost="{$method.cost}" data-pieces="{$method.pieces}" >{$method.name} ({$method.cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang}  +  kolejna sztuka * {$method.pieces|number_format:2:'.':' '} {"xca_coin_type"|xvLang})</option>
											{/foreach}
											</select>
							</td>
							<td style="vertical-align: middle;" class="shipment-cost-val"></td>
							<td style="vertical-align: middle;" class="shipment-pieces-val"></td>
							<td style="vertical-align: middle;"><b style="color:#0F9100;" class="shipment-result-val">{($bought_info.Cost*$bought_info.Pieces)|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</b></td>
						</tr>						
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><b>Razem:</b></td>
							<td style="vertical-align: middle;"><b style="color:#0F9100;" class="shipment-all-val"></b></td>
						</tr>
					</tbody>
				</table>
					<script>
						$(function(){
							$("#shipment_method").change(function(){
								var shipment_key = $(this).val();
								var shipment_cost = $(".shipment-method-"+shipment_key).data("cost");
								var shipment_pieces = $(".shipment-method-"+shipment_key).data("pieces");
								$(".shipment-pieces-val").html("+ "+ shipment_pieces+' {"xca_coin_type"|xvLang}');
								$(".shipment-cost-val").html(""+ shipment_cost+' {"xca_coin_type"|xvLang}');
								var shipment_result = (shipment_cost + (({$bought_info.Pieces}-1)*shipment_pieces));
								$(".shipment-result-val").html(""+  shipment_result +' {"xca_coin_type"|xvLang}');
								$(".shipment-all-val").html(""+ ( shipment_result + {($bought_info.Cost*$bought_info.Pieces)}) +' {"xca_coin_type"|xvLang}');
							}).change();
						});
					</script>
			
			<div style="clear:both;"></div>
		</div>
			<div style="text-align:center;"><input type="submit" value="Zapłać" /></div>
		</form>
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->