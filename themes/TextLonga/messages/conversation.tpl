<!-- Messages module -->
	<div class="xv-message-wrapper">
		<div class="xv-message-list">
			{foreach from=$xv_address_book item=address}
				<a href="{$URLS.Script}Messages/{$address.user|escape:'url'}/" {if $address.user == $xv_receiver}class="selected"{/if}>{$address.user} {if $address.unread}<span>{$address.unread}</span>{/if}</a>
			{foreachelse}
				<div class="success">No messages</div>
			{/foreach}
		</div>
		
		<div class="xv-message-conversation">
			<div class="xv-message-conversation-header">
				Rozmowa z <a href="{$URLS.Script}Users/{$xv_receiver}/">{$xv_receiver}</a>
			</div>
			<div class="xv-message-history">
				{foreach from=$xv_messages_list item=message_data}
					<div class="{if $message_data.Me}me{else}sender{/if}">
						<span class="time">{$message_data.Date}</span>
					{$message_data.Text}
					</div>
				{foreachelse}
					<div class="success">No messages</div>
				{/foreach}				

			</div>
			<div class="xv-message-scroll">
				<div data-scroll=".xv-message-history"></div>
			</div>
			<div style="clear:both;"></div>
				<form action="?" method="post" class="xv-message-form">
					<textarea class="xv-message-textarea"></textarea>
					<input type="submit" value="send" />
				
				</form>
		</div>
	</div>
	<div style="clear:both;"></div>
<!-- Messages module -->
