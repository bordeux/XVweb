ThemeClass.DeleteLastVerArt = function(ID, NoQuery){
if (typeof(NoQuery) != "undefined")
{
GetAjax(URLS.Script+"receiver/DLVA?ArticleID="+ID+"&SIDCheck="+SIDUser, 'QueryIDText-DeleteLastVerArt');
$GetID('Footer-DeleteLastVerArt').innerHTML ="<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteLastVerArt\"); return false;' ><button class='StyleForm'>"+ Language["Close"] +"</button></a>";
return false;
}
var Topic = $("#art-"+ID).html();
  CreateWindowLayer("DeleteLastVerArt" , QueryView("DeleteLastVerArt", "<div class='LightBulbTip'>"+ Language["DeleteLastVerArt"].replace(/%s/i, Topic)+"</div>","<a href='#' onclick='ThemeClass.DeleteLastVerArt("+ID+", true); return false;' ><button class='StyleForm'>"+ Language["Yes"]+"</button></a><a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteLastVerArt\"); return false;' ><button class='StyleForm'>"+ Language["No"] +"</button></a>"));
  return false;
  }