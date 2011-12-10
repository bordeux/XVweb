ThemeClass.DeleteArtVer = function(ID,Version, NoQuery){z
if (typeof(NoQuery) != "undefined")
{
GetAjax(URLS.Script+"receiver/DVA?ArticleID="+ID+"&Version="+Version+"&SIDCheck="+SIDUser, 'QueryIDText-DeleteArtVer');
$GetID('Footer-DeleteArtVer').innerHTML ="<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteArtVer\"); return false;' ><button class='StyleForm'>"+ Language["Close"] +"</button></a>";
return false;
}
var Topic = $(".topic_site").html();
  CreateWindowLayer("DeleteArtVer" , QueryView("DeleteArtVer", "<div class='LightBulbTip'>"+(( Language["DeleteArtVer"].replace(/%d/i, "<b>"+Version+"</b>")).replace(/%s/i, "<b>"+Topic+"</b>"))+"</div>","<a href='#' onclick='ThemeClass.DeleteArtVer("+ID+", "+Version+", true); return false;' ><button class='StyleForm'>"+ Language["Yes"] +"</button></a><a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteArtVer\"); return false;' ><button class='StyleForm'>"+ Language["No"] +"</button></a>"));
  return false;
  }