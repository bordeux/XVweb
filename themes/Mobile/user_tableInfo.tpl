<div id="UserTable">
<table  class="TableUser" summary="User Table Profil">
    <tr class="TableCell" >
      <td rowspan="5" align="center"> 
	  <img src="{$AvantsURL}{if $User.Avant}{$User.Nick}{/if}_32.jpg" alt="{$User.Nick}" />
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
    <tr class="TableCell">
      <td>{$language.Mail}</td>
      <td colspan="2">{mailto address=$User.Mail encode="javascript_charcode"}</td>
    </tr>
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
<a href="skype:{$User.Skype}?chat"><img src="http://mystatus.skype.com/smallclassic/{$User.Skype}" style="border: none;" width="40" height="8" alt="Mój stan" /></a>
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
      <td colspan="3">{$language.Statistics}</td>
    </tr>
	
	 <tr class="TableCell">
      <td>{$language.LastIP}</td>
      <td colspan="2">{$User.IP}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.ModificationCount}</td>
      <td colspan="2">{$UserStats.ModCount}</td>
    </tr>
	<tr class="TableCell">
      <td>{$language.PostCount}</td>
      <td colspan="2">{$UserStats.ProfileViews}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.VisitedCount}</td>
      <td colspan="2">{$UserStats.ProfileViews}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.RegistrationDate} </td>
      <td colspan="2">{$User.Creation}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.VisitsPerDay}</td>
      <td colspan="2">{math equation="x/y" x=$UserStats.LogedCount y=$UserStats.CretoionDay format="%.2f"}</td>
    </tr>  
	 <tr class="TableCell">
      <td>{$language.ProfileViews}</td>
      <td colspan="2">{$UserStats.ProfileViews}</td>
    </tr>
    <tr class="TableCell">
      <td>{$language.CreationAsDay}</td>
      <td colspan="2">{$UserStats.CretoionDay}</td>
    </tr>
</table>
	{if $UserFiles}
<table  class="UserFiles" summary="User Table File">
	<tr class="TableCell">
      <td>{$Pager.0}</td>
    </tr>
    <tr class="TableCell">
      <td><b>{$language.Files}</b></td>
	  <td><b>{$language.Downloads}</b></td>
    </tr>
	{foreach from=$UserFiles key=k item=file}
 <tr class="TableCell">
      <td><a href="{$UrlScript}File/{$file.ID}/">{$file.FileName}.{$file.Extension}</a></td>
	  <td>{$file.Downloads}</td>
    </tr>
{/foreach}
	<tr class="TableCell">
      <td>{$Pager.1}</td>
    </tr>
  </table>
  {/if}
</div>