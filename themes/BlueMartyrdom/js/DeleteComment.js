ThemeClass.DeleteComment  = function(ID, NoQuery) {
if (typeof(NoQuery) != "undefined")
{

GetAjax(URLS.Script+"receiver/DC?CommentID="+ID+"&SIDCheck="+SIDUser, 'QueryIDText-DeleteComment');
$('#Footer-DeleteComment').html("<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteComment\"); return false;' ><button class='StyleForm'>" +Language["Close"] +"</button></a>");
return false;
}
  CreateWindowLayer("DeleteComment" , QueryView("DeleteComment", Language["DeleteComment"].replace(/%s/i, ID),"<a href='#' onclick='DeleteComment("+ID+", true); return false;' ><button class='StyleForm'>"+ Language["Yes"] +"</button></a><a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteComment\"); return false;' ><button class='StyleForm'>"+ Language["No"] +"</button></a>"));
  return false;
}