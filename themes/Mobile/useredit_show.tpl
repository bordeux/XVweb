<div id="UserTableEdit">
<form id="ProfilForm" name="ProfilForm" action="?Save" enctype="multipart/form-data" method="post" onsubmit="EditProfile.SendDate(); return false;">
<table class="TableUser" summary="User Table Profil" style="width:800px;">
 <tr class="TableCell">
  <td  rowspan="5" align="center"> 
	 <img src="{$AvantsURL}{$Comment.Author}_150.jpg" alt="{$User.Nick}">
	 </td>

 </tr>
{foreach from=$UserInputs item=field key=handlefield name=InputsFields}
<tr class="TableCell">
		<td>{$language[$handlefield]|default:"------"}</td>
		<td>
		{if $field.tag == "select"}
		<select {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>
			{foreach from=$field.options item=option key=optionkey}
				<option value="{$optionkey}" {if $field.checked[$optionkey]}selected="selected"{/if}>{$option}</option>
			{/foreach}
		</select>
		{elseif $field.tag == "input"}
		<input{foreach from=$field.attr item=attrvalue key=attrkey}{if $attrkey == "checked" && $attrvalue !="checked"} {else} {$attrkey}="{$attrvalue}"{/if}{/foreach} />
		{elseif $field.tag == "multiinput"}
			{foreach from=$field.inputs key=inkey item=inputh}
				{$language[$inkey]|default:"------"}: <input {foreach from=$inputh item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach} /> <br/>
			{/foreach}
			{elseif $field.tag == "textarea"}
				<textarea {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>{$field.text|escape:"html"}</textarea>
		{/if}
		</td>
		 </tr>
{/foreach}
	<tr class="TableCell">
  <td> <input type="submit" name="EditSend" value="Save" size="36"  /></td>
 </tr>
 
 </table>
 </form>
</div>