ThemeClass.DeleteArticle = function(ID,Topic, NoQuery){
if (typeof(NoQuery) != "undefined")
{
GetAjax(URLS.Script+"receiver/DA?&ArticleID="+ID+"&SIDCheck="+SIDUser, 'QueryIDText-DeleteArticle');
$('#Footer-DeleteArticle').html("<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteArticle\"); return false;' ><button class='StyleForm'>"+Language["Close"]+"</button></a>");
return false;
}
  CreateWindowLayer("DeleteArticle" , QueryView("DeleteArticle", 
  ["<div class='LightBulbTip'>",Language["DeleteArticleMSG"].replace(/%s/i, Topic),"</div>"].join("")
  ,//next arg
  ["<a href='#' onclick='DeleteArticle(",ID,", \"",Topic,"\", true); return false;' >","<button class='StyleForm'>",Language["Yes"],"</button></a>",
  "<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteArticle\"); return false;' ><button class='StyleForm'>"+Language["No"]+"</button></a>"].join("")
  ));
  return false;
 }