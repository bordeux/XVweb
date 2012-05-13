<!-- Content -->
 <div id="Content">
	<div class="xvauction-main" >

{include file="xvauctions_theme/add_categories_nav.tpl" inline}

		<div class="xvauction-header">
			<div class="xvauction-header-thumbnail">
					{if $smarty.post.add.thumbnail}
						<img src="{$URLS.Thumbnails}-tmp/{$smarty.post.add.thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
					{else}
						<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xv_lang}'  />
					{/if}
							
			</div>
			<div class="xvauction-header-title">
				<h1>{$smarty.post.add.title|escape:"html"} <span>({"xca_auction_id"|xv_lang} : 000000000)</span></h1>
			</div>
		</div>
		<div class="xvauction-price-list">
			<table>
				<thead>
					<tr> <td colspan="2">{"xca_prices"|xv_lang}</td></tr>
				<thead>
				<tfoot>
					 <tr> 
						<td>SUMA</td>
						<td> {$xvauctions_price_sum|number_format:2:'.':' '} {"xca_coin_type"|xv_lang} </td>
					 </tr>
				</tfoot>
				<tbody>
				{foreach from=$xvauctions_price_list item=price}
					<tr>
						<td>{$price.caption}</td>
						<td> {$price.cost|number_format:2:'.':' '} {"xca_coin_type"|xv_lang} </td>
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	<div style="clear:both"></div>
		<div class="xvauction-description">
				<div class="xvauction-description-caption">{"xca_description"|xv_lang}</div>
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
		<input type="submit" value="{"xca_make_auction"|xv_lang} ({'xca_cost2'|xv_lang}: {$xvauctions_price_sum|number_format:2:'.':' '} {'xca_coin_type'|xv_lang})" /></form></div>
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->