<div class="WidgetsMain" id="WidgetsMainID">
{foreach from=$Widgets item=Widget name=WidgetsForeach}
	{foreach from=$Widget key=NameWidget item=WidgetValue}
		<div class="dragbox" id="{$NameWidget}" style="{$WidgetValue.WindowStyle}">
			<h2><span class="configure" ><div class="movebutton"></div><div class="maximizebutton"></div><div class="closebutton"></div></span> {$WidgetValue.name.value}</h2>
			<div class="dragbox-content" >
				{$WidgetValue.content.value}
			</div>
		</div>
		{/foreach}
{/foreach}
	</div>