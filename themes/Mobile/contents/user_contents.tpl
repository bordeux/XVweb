<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="ArticleTools">
		<ul>
			<li>
				<a href="?#Profile" title="{$language.Profile}"  id="btViewProfile" class="selected">{$language.Profile}</a>
			</li>
			{if "EditOtherProfil"|perm or ( "EditProfil"|perm and $User.Nick eq $LogedUser)}
				<li>
					<a href="#Edit" id="btEditProfile">{$language.EditProfile}</a>
				</li>
			{/if}
			{if "DeleteUser"|perm}
				<li>
					<a href="#DeleteUser" title="{$language.DeleteProfile}" id="btDeleteUser" >{$language.DeleteProfile}</a>
				</li>
			{/if}
			{if  "BanUser"|perm}
				<li>
					<a href="#BanUser" title="{$language.BanUser}" id="btBanUser" >{$language.BanUser}</a>
				</li>
			{/if}
		</ul>
	</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
			
	<div id="ProfileText">
		{include  file='user_tableInfo.tpl'}
	</div>
</div>

			
			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->