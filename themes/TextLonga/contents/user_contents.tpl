<!-- Content -->
 <div id="Content">
<div id="ContentDiv">
	{if $smarty.get.msg}
		<div class="{if $smarty.get.success}success{else}failed{/if}">
		{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
			{$smarty.get.msg|escape:"html"}
			{if $smarty.get.list}
			<ul>
				{foreach from=$smarty.get.list item=Value name=minimap}
				<li>{$Value|escape:"html"}</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	{/if}
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover ui-state-active">
				<a href="{$URLS.Script}Users/{$User.Nick|escape:'url'}" title="{$language.Profile}"  id="btViewProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-person" style="margin-left:-16px;"></span> {$language.Profile}</a>
			</li>
			{if "EditOtherProfil"|perm or ( "EditProfil"|perm and $User.Nick eq $LogedUser)}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Users/{$User.Nick|escape:'url'}/Edit/" id="btEditProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditProfile}</a>
				</li>
			{/if}
			{if  "DeleteUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Users/{$User.Nick|escape:'url'}/?delete=true&SIDCheck={$JSVars.SIDUser}" title="{$language.DeleteProfile}" class="xv-delete-user" style="padding-left:20px;"> <span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.DeleteProfile}</a>
				</li>
			{/if}
			{if  "BanUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="#BanUser" title="{$language.BanUser}" id="btBanUser" style="padding-left:20px;"> <span class="ui-icon ui-icon-cancel" style="margin-left:-16px;"></span>{$language.BanUser}</a>
				</li>
			{/if}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Messages/Write/?To={$User.Nick|escape:'url'}" title="{$language.Write}" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span> {$language.Write}...</a>
				</li>
		</ul>
	</div>

<div class="xv-text-wrapper">
<!-- TEXT -->
<div class="xv-user-content">
{if $modifications_list}
<div class="xv-user-texts">
	<div class="xv-user-seperate"><span> Modyfikacje </span></div>
	<div class="xv-user-texts-list">
	{foreach from=$modifications_list key=k item=modification}
		<div>
			<a href="{$URLS.Script}{$modification.index_url|replace:' ':'_'|urlrepair|substr:1}" >{$modification.index_title}</a>
			<div>Data : {$modification.text_date}, wyświetleń: {$modification.index_views}</div>
		</div>
	{/foreach}
	</div>
	{$modifications_pager[1]}
</div>
{/if}


{if $files_list}
<div class="xv-user-files">
	<div class="xv-user-seperate"><span> {$language.Files} </span></div>

		<div class="xv-user-files-list">
			{foreach from=$files_list key=k item=file}
				<a href="{$URLS.Script}File/{$file.ID}/">{$file.FileName}.{$file.Extension}</a>
			{/foreach}
		</div>
		<div style="clear: both;" ></div>
		{$files_pager[1]}
</div>
{/if}



</div>
<div class="xv-user-right" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Person">
	<div class="xv-user-avatar">
		<img src="{$AvantsURL}{if $User.Avant}{$User.Nick}{/if}_150.jpg" alt="{$User.Nick}" />
		<div class="xv-user-id">ID : {$User.ID}</div>
	</div>
	<div class="xv-user-nick" property="v:nickname">
		{$User.Nick}
	</div>	
	<div class="xv-user-register-date">
		Dołączył <time title="{$User.Creation}" datetime="{$User.Creation|date_format:'Y-m-d'}T{$User.Creation|date_format:'H:i:s'}TZD" pubdate="">3 mies.</time> temu
	</div>
	
	<div class="xv-user-seperate"></div>
	
	<div class="xv-user-info-table">
		{if $User.Name}<div>
			<div>{$language.Name}</div>
			<div>{$User.Name}</div>
		</div>{/if}
		{if $User.VorName}<div>
			<div>{$language.VorName}</div>
			<div>{$User.VorName}</div>
		</div>{/if}		
		{if $User.WhereFrom}<div>
			<div>{$language.WhereFrom}</div>
			<div>{$User.WhereFrom}</div>
		</div>{/if}	
		{if $User.Page}<div>
			<div>{$language.Page}</div>
			<div><a href="{$User.Page}" target="_blank" >{$User.Page}</a></div>
		</div>{/if}		
		{if $User.GG}<div>
			<div>{$language.GaduGadu}</div>
			<div><a href="gg:{$User.GG}" ><img src="http://status.gadu-gadu.pl/users/status.asp?id={$User.GG}&amp;styl=1" title="{$User.GG}" alt="{$User.GG}" /> {$User.GG}</a></div>
		</div>{/if}		
		{if $User.Skype}<div>
			<div>{$language.Skype}</div>
			<div><a href="skype:{$User.Skype}?chat"><img src="http://mystatus.skype.com/smallclassic/{$User.Skype}" style="border: none;" width="114" height="20" alt="Mój stan" /></a></div>
		</div>{/if}		
		{if $User.Tlen}<div>
			<div>{$language.Tlen}</div>
			<div><a href="http://ludzie.tlen.pl/{$User.Tlen}/" target="_blank"><img src="http://status.tlen.pl/?u={$User.Tlen}&t=3"></a></div>
		</div>{/if}		
		{if $User.ICQ}<div>
			<div>{$language.ICQ}</div>
			<div><img src="http://status.icq.com/online.gif?icq={$User.ICQ}&img=9"></div>
		</div>{/if}
	</div>
		
		
	<div class="xv-user-stats-table">
		<div>
			<div>{if $UserStats.CreationDay == 0}{$User.LoginCount}{else}{math equation="x/y" x=$User.LoginCount y=$UserStats.CreationDay format="%.2f"}{/if}</div>
			<div>{$language.VisitsPerDay}</div>
		</div>	
		<div>
			<div>{$User.Views}</div>
			<div>{$language.ProfileViews}</div>
		</div>	
		<div>
			<div>{$modifications_count}</div>
			<div>{$language.ModificationCount}</div>
		</div>		
		<div>
			<div>{$files_count}</div>
			<div>Plików</div>
		</div>		
	</div>
</div>
<!-- TEXT -->
<div style="clear:both;"></div>
</div>

	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>
	
{if $LoadComment}
	{include  file='comment.tpl' inline}
{/if}
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->