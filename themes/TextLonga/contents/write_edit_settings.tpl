
	<form action="{$UrlScript}Write/?settings={$IDArticle}" name="SettingsForm" method="post">
	<div class='xv-table'>
					<table style="width : 100%; text-align: center;">
				<caption>{$Pager.0}</caption>
				<thead> 
					<tr>
						<th>{$language.Name}</th>
						<th>{$language.Description}</th>
						<th>{$language.Value}</th>
					</tr>
				</thead> 
				<tbody> 
					{foreach from=$SettingsInputs item=field key=handlefield name=InputsFields}
						<tr>
							<td><b>{$handlefield}</b></td>
							<td>{$language[$handlefield]|default:"------"}</td>
							<td>
							{if $field.tag == "select"}
							<select {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>
								{foreach from=$field.options item=option key=optionkey}
									<option value="{$optionkey}" {if $field.checked[$optionkey]}selected="selected"{/if}>{$option}</option>
								{/foreach}
							</select>
							{elseif $field.tag == "input"}
							<input {foreach from=$field.attr item=attrvalue key=attrkey}{if $attrkey == "checked" && $attrvalue !="checked"} {else} {$attrkey}="{$attrvalue}"{/if}{/foreach}>
							{elseif $field.tag == "multiinput"}
								{foreach from=$field.inputs item=input}
									<input{foreach from=input item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}> <br/>
								{/foreach}
								{elseif $field.tag == "textarea"}
									<textarea {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>{$field.text|escape:"html"}</textarea>
							{/if}
							
							</td>
						</tr>
					{/foreach}
				</tbody> 
			</table>
			
			<div class="xv-table-pager"><input type="submit" value="{$language.Save}" /></div>
	
	</div>
	</form>