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
			&gt;&gt; {$Title}
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">{"xca_adding_opinion"|xv_lang}</div>
		</div>
		<div>
		{if $added_comment}
			<div style="padding: 20px;">
				<div class="success">{"xca_opinion_added"|xv_lang}.</div>
				
			</div>
		{else}

			<script type="text/javascript" src="{$URLS.Theme}xvauctions/js/stars/jquery.rating.js"></script>
			<link rel="stylesheet" media="screen" type="text/css" href="{$URLS.Theme}xvauctions/js/stars/jquery.rating.css" />
		{literal}	
		<script type="text/javascript">
				$(document).ready(function(){
					$(".xva-stars").rating({showCancel: false});
				});		
			
			</script>
		{/literal}
			<div style="padding: 50px;">
			<form action="?add=true" method="post">
			<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
				<div class="LightBulbTip" style="margin-bottom: 20px;">
				 {"xca_you_are_adding_opinion"|xv_lang|sprintf:'<a href="{$URLS.Auction}/{$bought_info.Auction}/" target="_blank"><b>{$bought_info.Title}</b> , id: {$bought_info.Auction}</a>'}
				</div>
				<div style="float:left">
					<table>	
					{if $comment_mode == "buyer"}					
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_compliance_with_desc"|xv_lang}</td>
							<td>
								<select class="xva-stars" name="compatibility">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>			
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_contact_with_seller"|xv_lang}</td>
							<td>
								<select class="xva-stars" name="contact">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_realization_time"|xv_lang}</td>
							<td>
								<select class="xva-stars" name="realization">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_shipment_cost"|xv_lang}</td>
							<td>
								<select class="xva-stars" name="shipping">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select>
							</td>
						</tr>
						{/if}
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_comment_type"|xv_lang}</td>
							<td>
								<input type="radio" name="comment_type" value="positive" id="comment-type-positive" checked="checked"/>
									<label for="comment-type-positive" style="color: #009B00; font-weight: bold;">{"xca_positive"|xv_lang}</label>
								<input type="radio" name="comment_type" value="neutral" id="comment-type-neutral"/>
									<label for="comment-type-neutral" style="color: #646464; font-weight: bold;">{"xca_neutral"|xv_lang}</label>
								<input type="radio" name="comment_type" value="negative" id="comment-type-negative"/>
									<label for="comment-type-negative" style="color: #EE3E2B; font-weight: bold;">{"xca_negative"|xv_lang}</label>
					
							</td>
						</tr>
			
			
						<tr>
							<td style="width: 200px; font-weight: bold;">{'xca_comment'|xv_lang}</td>
							<td><textarea name="comment"  style="width: 300px; height: 60px;">{"xca_default_comment"|xv_lang}</textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="{'xca_comment_add'|xv_lang}" name="submit" /></td>
						</tr>

					</table>
				</div>
				{if $comment_mode == "buyer"}
				<div style="float:left; margin-left: 40px; width: 300px;" class="LightBulbTip">
					{"xca_coment_add_tip"|xv_lang}
				</div> 
				{/if}
				
				<div style="float:left; margin-left: 40px; margin-top: 30px; width: 300px;" class="LightBulbTip">
					{"xca_comment_add_tip2"|xv_lang}
				</div>
				</form>
				<div style="clear:both;"></div>
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