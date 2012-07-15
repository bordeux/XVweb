	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover {if $users_mode == 'profile'}ui-state-active{/if}">
				<a href="{$URLS.Script}Users/{$profile->User|escape:'url'}" title="{$language.Profile}"  style="padding-left:20px;"> <span class="ui-icon ui-icon-person" style="margin-left:-16px;"></span> {$language.Profile}</a>
			</li>
			{if $profile->User eq $LogedUser}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover {if $users_mode == 'edit'}ui-state-active{/if}">
					<a href="{$URLS.Script}Users/{$profile->User|escape:'url'}/Edit/" id="btEditProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditProfile}</a>
				</li>
			{/if}
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover {if $users_mode == 'about'}ui-state-active{/if}">
				<a href="{$URLS.Script}Users/{$profile->User|escape:'url'}/about/" title="{$language.about_me}"  style="padding-left:20px;"> <span class="ui-icon ui-icon-contact" style="margin-left:-16px;"></span> {$language.about_me}</a>
			</li>
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
				<a href="{$URLS.Script}auctions/?auction_seller={$profile->User|escape:'url'}" title="{$language.i_sell}"  style="padding-left:20px;"> <span class="ui-icon ui-icon-cart" style="margin-left:-16px;"></span> {$language.i_sell}</a>
			</li>
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Messages/Write/?To={$profile->User|escape:'url'}" title="{$language.Write}" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span> {$language.Write}...</a>
			</li>
		</ul>
	</div>