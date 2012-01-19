<!-- Content -->
 <div id="Content">
	<div class="xvauction-main" >

{include file="xvauctions_theme/add_categories_nav.tpl" inline}

		<div class="xvauction-header">
			<div class="xvauction-header-thumbnail">
					{if $smarty.post.add.thumbnail}
						<img src="{$URLS.Thumbnails}-tmp/{$smarty.post.add.thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
					{else}
						<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xvLang}'  />
					{/if}
							
			</div>
			<div class="xvauction-header-title">
				<h1>{$smarty.post.add.title|escape:"html"} <span>({"xca_auction_id"|xvLang} : 000000000)</span></h1>
			</div>
		</div>
		<div class="xvauction-price-list">
			<table>
				<thead>
					<tr> <td colspan="2">Cennik</td></tr>
				<thead>
				<tfoot>
					 <tr> 
						<td>SUMA</td>
						<td> {$xvauctions_price_sum|number_format:2:'.':' '} {"xca_coin_type"|xvLang} </td>
					 </tr>
				</tfoot>
				<tbody>
				{foreach from=$xvauctions_price_list item=price}
					<tr>
						<td>{$price.caption}</td>
						<td> {$price.cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang} </td>
					</tr>
				{/foreach}
				</tbody>
			</table>
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
		<input type="submit" value="Wystaw licytacje (koszt: {$xvauctions_price_sum|number_format:2:'.':' '} {'xca_coin_type'|xvLang})" /></form></div>
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->