<!-- Content -->
	{include file="users/edit_panel.tpl"}

<div class="xv-text-wrapper">
<!-- TEXT -->
<div class="xv-user-content">
{foreach from=$widgets_html key=k item=widget_html}
	{$widget_html}
{/foreach}
</div>
<div class="xv-user-right" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Person">
	<div class="xv-user-avatar">
		<img src="{$AvantsURL}{if $profile->Avant}{$profile->User}{/if}_150.jpg" alt="{$profile->User}" />
		<div class="xv-user-id">ID : {$profile->ID}</div>
	</div>
	<div class="xv-user-nick" property="v:nickname">
		{$profile->User}
	</div>	
	<div class="xv-user-register-date">
		{"joined"|xv_lang} <time title="{$profile->Creation}" datetime="{$profile->Creation|date_format:'Y-m-d'}T{$profile->Creation|date_format:'H:i:s'}TZD" pubdate="">{$profile->Creation}</time>
	</div>
	
	<div class="xv-user-seperate"></div>
	
	<div class="xv-user-info-table">
		{if $profile->Name}<div>
			<div>{$language.Name}</div>
			<div>{$profile->Name}</div>
		</div>{/if}
		{if $profile->VorName}<div>
			<div>{$language.VorName}</div>
			<div>{$profile->VorName}</div>
		</div>{/if}		
		{if $profile->WhereFrom}<div>
			<div>{$language.WhereFrom}</div>
			<div>{$profile->WhereFrom}</div>
		</div>{/if}	
		{if $profile->Page}<div>
			<div>{$language.Page}</div>
			<div><a href="{$profile->Page}" target="_blank" >{$profile->Page}</a></div>
		</div>{/if}		
		{if $profile->GG}<div>
			<div>{$language.GaduGadu}</div>
			<div><a href="gg:{$profile->GG}" ><img src="http://status.gadu-gadu.pl/users/status.asp?id={$profile->GG}&amp;styl=1" title="{$profile->GG}" alt="{$profile->GG}" /> {$profile->GG}</a></div>
		</div>{/if}		
		{if $profile->Skype}<div>
			<div>{$language.Skype}</div>
			<div><a href="skype:{$profile->Skype}?chat"><img src="http://mystatus.skype.com/smallclassic/{$profile->Skype}" style="border: none;" width="114" height="20" alt="Mój stan" /></a></div>
		</div>{/if}		
		{if $profile->Tlen}<div>
			<div>{$language.Tlen}</div>
			<div><a href="http://ludzie.tlen.pl/{$profile->Tlen}/" target="_blank"><img src="http://status.tlen.pl/?u={$profile->Tlen}&t=3"></a></div>
		</div>{/if}		
		{if $profile->ICQ}<div>
			<div>{$language.ICQ}</div>
			<div><img src="http://status.icq.com/online.gif?icq={$profile->ICQ}&img=9"></div>
		</div>{/if}
	</div>
		
		
	<div class="xv-user-table2">
		<div>
			<div>{if $profileStats.CreationDay == 0}{$profile->LoginCount}{else}{math equation="x/y" x=$profile->LoginCount y=$profileStats.CreationDay format="%.2f"}{/if}</div>
			<div>{$language.VisitsPerDay}</div>
		</div>	
		<div>
			<div>{$profile->Views}</div>
			<div>{$language.ProfileViews}</div>
		</div>	
	
	</div>
</div>
<!-- TEXT -->
<div style="clear:both;"></div>
</div>


<div style="clear:both;"></div>
 <!-- /Content -->