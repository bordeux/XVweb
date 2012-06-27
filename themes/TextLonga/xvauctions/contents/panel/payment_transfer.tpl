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
			&gt;&gt; <a href="{$URLS.AuctionPanel}/payment_transfer/">{$Title}</a> 
	
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
		{if $smarty.post.pre_send && $isset_user}
			<div style="padding: 20px;">
				<div class="LightBulbTip" style="width: 600px; margin: auto;">Czy jesteś pewien transferu <b>{$smarty.post.transfer.amount|escape:"html"} {"xca_coin_type"|xv_lang}</b> dla użytkownika <a href="{$URLS.Script}/Users/{$smarty.post.transfer.user|escape:'url'}/" target="_blank"><b>{$smarty.post.transfer.user|escape:"html"}</b></a> </div>
							<form action="?transfer=true" method="post" style="text-align:center; padding: 10px; width: 300px; margin:auto;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="transfer[user]" value="{$smarty.post.transfer.user}"/>
								<input type="hidden" name="transfer[amount]" value="{$smarty.post.transfer.amount}"  />
								<input type="hidden" name="finish_mode" value="true" />
								<a href="?" style="margin-right: 20px;">{'xca_back'|xv_lang}</a> 
								<input type="submit" value="{'xca_payments_send_transfer'|xv_lang}" />
							</form>
				
			</div>
		{else}
		
		{if $smarty.post.pre_send}
			<div class="error">{"xca_payments_send_invalid_user"|xv_lang}</div>
		{/if}	
		{if $smarty.get.transfer}
			{if $send_mode}
				<div class="success">{"xca_payments_send_success"|xv_lang}</div>
			{else}
				<div class="error">{"xca_payments_send_error"|xv_lang}</div>
			{/if}
		{/if}
		
		
			<div style="padding: 50px;">
			<form action="?" method="post">
				<div style="float:left">
				<input type="hidden" name="pre_send" value="true" />
					<table>
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_available_balance"|xv_lang}</td>
							<td>{if $Session.xv_payments_amount > 0} <span style="font-weight:bold; color:#3f7f00;">{({$Session.xv_payments_amount}/100)|number_format:2:'.':' '}  {"xca_coin_type"|xv_lang}</span>{else}<span style="font-weight:bold; color:#bf0000;">{({$Session.xv_payments_amount}/100)|number_format:2:'.':' '}  {"xca_coin_type"|xv_lang}</span>{/if}</td>
						</tr>			
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_amount_of_transfer"|xv_lang}</td>
							<td><input type="text" value="" name="transfer[amount]" class="xva-transfer-amount" {literal}pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))"{/literal} placeholder="ex. 53.42" /></td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_amount_of_transfer_result"|xv_lang}</td>
							<td><span class="xva-transfer-result">0</span> {"xca_coin_type"|xv_lang}</td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_transfer_recipient"|xv_lang}</td>
							<td><input type="text" value="" name="transfer[user]" maxlength="50" placeholder="username.." /></td>
						</tr>				
						<tr>
							<td style="width: 200px; font-weight: bold;">{"xca_message_to_recipient"|xv_lang}</td>
							<td><textarea name="transfer[message]" ></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="{'xca_next'|xv_lang}" name="submit" /></td>
						</tr>

					</table>
				</div>
				<div style="float:left; margin-left: 40px;" class="LightBulbTip">
					{"xca_provision_message"|xv_lang|sprintf:($amount_commission*100)}
				</div>
				</form>
				<script>
				$(function(){
					$(".xva-transfer-amount").keyup(function(){
						var amount = parseFloat($(this).val());
						amount = amount*(1-({$amount_commission}));
						$(".xva-transfer-result").text(amount.toFixed(2));
					});
				
				});
				</script>
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