function SendNewTags(tag)
{

var EditTag = document.forms['TagArticleForm'].TagsArticle.value;	 
	if (EditTag == "")
	{
		document.forms['TagArticleForm'].TagsArticle.style.border = "2px solid #FF0000";
		ErrorAlert("<b>"+ Language["NoTags"] +"!</b>");
	} else {
	if (EditTag == tag)
	{
		document.forms['TagArticleForm'].TagsArticle.style.border = "2px solid #FF0000";
		ErrorAlert("<b>"+ Language["NoChange"] +"!</b>");
	} else {
	 
	if (EditTag.length < 5)
	{
		document.forms['TagArticleForm'].TagsArticle.style.border = "2px solid #FF0000";
		ErrorAlert("<b>"+ Language["ShortTag"] +"!</b>");

	} else {

	sendPost('EdistTagsDiv', 'TagArticleForm', URLS.Script+"receiver/tag");
	}
    

}
}
}

ThemeClass.EditTagAjax = function(IDArticle, tagi) {
ThemeClass.LoadLang("custom", function(){
  CreateWindowLayer( "EditTag" ,
  ["<div id='EdistTagsDiv'>",
	  "<form id='TagArticleForm' name='TagArticleForm' method='post'>",
		  "<input type='hidden' name='TagArticleID' value='"+IDArticle+"'>",
		  "<div class='LightBulbTip'>",
			"<img src='"+URLS.Theme+"img/LightbulbIcon.png'/> ",Language["TagsMSG"],
		  "</div>",
		  "<br />",
		  "<textarea class='StyleForm' rows='5' name='TagsArticle' cols='26'>"+ tagi +"</textarea>","<br />",
		  "<a href='#' onclick='SendNewTags(\"",tagi,"\"); return false;'>",
			"<button class='StyleForm'>", Language["Send"] ,"</button>",
		  "</a>",
		  "<a href='#' onclick='CancelWindowLayer(\"EditTag\"); return false;'><button class='StyleForm'>"+ Language["Send"] +"</button></a>",
	  "</form>",
  "</div>"].join(""));
  });
}