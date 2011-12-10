  <!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
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
	
<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover ui-state-active">
				<a href="{$UrlScript}Users/{$User.Nick|escape:'url'}" title="{$language.Profile}"  id="btViewProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-person" style="margin-left:-16px;"></span> {$language.Profile}</a>
			</li>
			{if "EditOtherProfil"|perm or ( "EditProfil"|perm and $User.Nick eq $LogedUser)}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Users/{$User.Nick|escape:'url'}/Edit/" id="btEditProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditProfile}</a>
				</li>
			{/if}
			{if  "DeleteUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="#DeleteUser" title="{$language.DeleteProfile}" id="btDeleteUser"style="padding-left:20px;"> <span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.DeleteProfile}</a>
				</li>
			{/if}
			{if  "BanUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="#BanUser" title="{$language.BanUser}" id="btBanUser" style="padding-left:20px;"> <span class="ui-icon ui-icon-cancel" style="margin-left:-16px;"></span>{$language.BanUser}</a>
				</li>
			{/if}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Messages/Write/?To={$User.Nick|escape:'url'}" title="{$language.Write}" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span> {$language.Write}...</a>
				</li>
		
			
		</ul>
		{if $MiniMap}
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
			{if $smarty.foreach.minimap.last}
				{$Value.Name}
			{else}
				<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/blank.png" class="cssprite SpaceIconIMG" alt="&gt;&gt;"/>
			{/if}
		{/foreach}
		</div>{/if}
	</div>
	
<div id="TextDiv">
<!-- TEXT -->
	<div id="wrapper">
	<div id="top">
   <div id="top-left">
        <div id="top-right">
              <div id="top-middle"> 
             </div>
        </div>
    </div>
</div>
<div id="frame-left"><div id="frame-right"><div id="content" >	  
<div id="UserInfo">
<!--
<div id="AdvPion">
</div>
-->
	<div id="ProfileText">
		<div id="UserTable">
<table  class="TableUser" summary="User Table Profil">
    <tr class="TableCell" >
      <td  width="159" height="113" rowspan="5" align="center"> 
	  <img src="{$AvantsURL}{if $User.Avant}{$User.Nick}{/if}_150.jpg" alt="{$User.Nick}" />
	  </td>

    </tr>
	<tr class="TableCell" >

      <td>{$language.Nick}</td>
      <td>
	  {if $User.OpenID}<a href="{$User.OpenID}"> <img src="{$UrlTheme}img/icon_openid.gif" /> </a>{/if} <span id="NickUser">{$User.Nick}</span></td>
    </tr>
	{if $User.Name}
    <tr class="TableCell" >
      <td >{$language.Name}</td>
      <td>{$User.Name}</td>
    </tr>
	{/if}
  {if $User.VorName}
    <tr class="TableCell">
      <td>{$language.VorName}</td>
      <td>{$User.VorName}</td>
    </tr>
	{/if}
    <tr class="TableCell">
      <td>{$language.UserID}</td>
      <td>{$User.ID}</td>
    </tr>
	{if $User.WhereFrom}
    <tr class="TableCell">
      <td>{$language.WhereFrom}</td>
      <td colspan="2">{$User.WhereFrom}</td>
    </tr>
	{/if}
   {* <tr class="TableCell">
      <td>{$language.Mail}</td>
      <td colspan="2">{mailto address=$User.Mail encode="javascript_charcode"}</td>
    </tr>*}
	{if $User.Page}
	<tr class="TableCell">
      <td>{$language.Page}</td>
      <td colspan="2"><a href="{$User.Page}" target="_blank" >{$User.Page}</a></td>
    </tr>
	{/if}
{if $User.GG}
 <tr class="TableCell">
      <td>{$language.GaduGadu}</td>
      <td colspan="2"> 
	  <a href="gg:{$User.GG}" ><img src="http://status.gadu-gadu.pl/users/status.asp?id={$User.GG}&amp;styl=1" title="{$User.GG}" alt="{$User.GG}" /> {$User.GG}</a></td>
    </tr>
{/if}

{if $User.Skype}
 <tr class="TableCell">
      <td>{$language.Skype}</td>
      <td colspan="2">
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a href="skype:{$User.Skype}?chat"><img src="http://mystatus.skype.com/smallclassic/{$User.Skype}" style="border: none;" width="114" height="20" alt="Mój stan" /></a>
  </td> </tr>
{/if}

{if $User.Tlen}
 <tr class="TableCell">
      <td>{$language.Tlen}</td>
      <td colspan="2"> 
<a href="http://ludzie.tlen.pl/{$User.Tlen}/" target="_blank"><img src="http://status.tlen.pl/?u={$User.Tlen}&t=3"></a>
	  </tr>
{/if}

{if $User.ICQ}
 <tr class="TableCell">
      <td>{$language.ICQ}</td>
      <td colspan="2"> 
<img src="http://status.icq.com/online.gif?icq={$User.ICQ}&img=9">
	  </tr>
{/if}
{if $User.Language}
 <tr class="TableCell">
      <td>{$language.Languages}</td>
      <td colspan="2"> 
{$User.Language}
	  </tr>
{/if}



    <tr class="TableCell">
      <td  width="449" height="17" colspan="3">{$language.Statistics}</td>
    </tr>
	
	 {* <tr class="TableCell">
      <td  width="159" height="10">{$language.LastIP}</td>
      <td   height="10" colspan="2">{$User.IP}</td>
    </tr> *}
    <tr class="TableCell">
      <td>{$language.ModificationCount}</td>
      <td colspan="2">{$UserStats.ModCount}</td>
    </tr>
	{*<tr class="TableCell">
      <td>{$language.PostCount}</td>
      <td colspan="2">ToDO</td>
    </tr> *}
    <tr class="TableCell">
      <td  width="159" height="12">{$language.VisitedCount}</td>
      <td   height="12" colspan="2">{$User.Views}</td>
    </tr>
    <tr class="TableCell">
      <td  width="159" height="23">{$language.RegistrationDate} </td>
      <td   height="23" colspan="2">{$User.Creation}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.VisitsPerDay}</td>
      <td colspan="2">{if $UserStats.CretoionDay == 0}{$User.LoginCount}{else}{math equation="x/y" x=$User.LoginCount y=$UserStats.CretoionDay format="%.2f"}{/if}</td>
    </tr>  
	 <tr class="TableCell">
      <td>{$language.ProfileViews}</td>
      <td colspan="2">{$User.Views}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.CreationAsDay}</td>
      <td colspan="2">{$UserStats.CretoionDay}</td>
    </tr>
	{if $UserFiles}
		<tr class="TableCell">
      <td> </td>
      <td colspan="2">{$Pager.0}</td>
    </tr>
    <tr class="TableCell">
      <td><b>{$language.Files}</b></td>
	  <td><b>{$language.Downloads}</b></td>
	  <td><b>{$language.CodeToArticle}</b></td>
    </tr>
	{foreach from=$UserFiles key=k item=file}
 <tr class="TableCell">
      <td><a href="{$UrlScript}File/{$file.ID}/">{$file.FileName}.{$file.Extension}</a></td>
	  <td>{$file.Downloads}</td>
	  <td><input type="text" value="&lt;file id=&quot;{$file.ID}&quot;/&gt;" /></td>
    </tr>
{/foreach}
	<tr class="TableCell">
      <td> </td>
      <td colspan="2">{$Pager.1}</td>
    </tr>
{/if}
  </table>
</div>
	</div>
</div>

<div style="clear:both;"></div>






</div></div></div>
<div id="bottom">
   <div id="bottom-left">
        <div id="bottom-right">
             <div id="bottom-middle"> 
             </div>
        </div>
    </div>
</div>
</div>
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->