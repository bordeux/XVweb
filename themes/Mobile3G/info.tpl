<ul data-role="listview"> 
		<li data-role="list-divider">{$language.LastModification}</li> 
		<li>{$ReadArticleOut.Date}</li> 
		<li data-role="list-divider">{$language.LastAuthor}</li> 
		<li><a href="{$UrlScript}Users/{$ReadArticleOut.Author|escape:'url'}/" >{$ReadArticleOut.Author}</a></li> 
		<li data-role="list-divider">{$language.ViewCount}</li> 
		<li>{$ReadArticleIndexOut.Views}</li> 
		<li data-role="list-divider">{$language.Version}</li> 
		<li>{$ReadArticleOut.Version}</li> 
		<li data-role="list-divider">{$language.Tags}</li>
		<li>{$ReadArticleIndexOut.Tag}</li>
</ul>