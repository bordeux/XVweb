
function EditTag(IDArticle, tagi) {
ThemeClass.EditTagAjax = function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/EditTag.js", function(){
		ThemeClass.EditTagAjax(IDArticle, tagi);
	});
};

function SendComment(IDCom)
{
	ThemeClass.SendComment = function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/SendComment.js", function(){
		ThemeClass.SendComment(IDCom);
	});
};
var SaveComment = new Array();
function EditComment(EditLink,IDComment){
	ThemeClass.LoadJS(URLS.JSCatalog+"js/EditComment.js", function(){
		ThemeClass.EditComment(EditLink,IDComment);
	});
};

function DeleteComment(ID, NoQuery) 
{
	ThemeClass.DeleteComment = function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/DeleteComment.js", function(){
		ThemeClass.DeleteComment(ID, NoQuery);
	});
};
function DeleteArticle(ID,Topic, NoQuery) {
	ThemeClass.DeleteArticle= function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/DeleteArticle.js", function(){
		ThemeClass.DeleteArticle(ID,Topic, NoQuery);
	});

};

function DeleteLastVer(ID) {
	ThemeClass.DeleteLastVerArt= function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/DeletLastVer.js", function(){
		ThemeClass.DeleteLastVerArt(ID);
	});
};

function DeleteVersionArt(ID, Version) {
	ThemeClass.DeleteArtVer= function(){ ThemeClass.Error(); };
	ThemeClass.LoadJS(URLS.JSCatalog+"js/DeletVerArt.js", function(){
		ThemeClass.DeleteArtVer(ID, Version);
	});
};

function ProgreesImage(div){
	$GetID(div).innerHTML = "<img src='"+URLS.Theme+"img/progress.gif' alt='Progress' />";
};
function PreviewComment(IDComment){
	if (typeof(IDComment) != "undefined")
	{
		ProgreesImage('PreView'+IDComment);
		sendPost('PreView'+IDComment, 'CommentForm'+IDComment, URLS.Script+"receiver/PreViewComment");
	}else{
		ProgreesImage('PreView');
		sendPost('PreView', 'CommentForm', URLS.Script+"receiver/PreViewComment");
	}
};

ThemeClass.Wykop = function() { 
	var wykop_url=encodeURIComponent(location.href); 
	var wykop_title=$(".topic_site").text(); 
	var wykop_desc=encodeURIComponent('Przyk³adowy opis');
	var widget_bg='DAD9D9';
	var widget_type='compact';
	var widget_bold=true;
	var widget_url='http://www.wykop.pl/widget.php?url='+(wykop_url)+'&title='+(wykop_title)+'&desc='+(wykop_desc)+'&bg='+(widget_bg)+'&type='+(widget_type)+'&bold='+(widget_bold);
	return ('<iframe src="'+widget_url+'" style="border:none;width:70px;height:20px;overflow:hidden;margin:0;padding:0;" frameborder="0" border="0"></iframe>');
};
ThemeClass.DeleteBind = function (){
	$('[href=#DeleteArticle]').click();
};

 $(document).ready(function(){
 $("#StarDiv").append(ThemeClass.Wykop());
    $(".WykopButton").html(ThemeClass.Wykop());
	$("#EditPanel .ui-icon-zoomin").click(function(){
		FontResize(1); 
		return false;
	});
	$("#EditPanel .ui-icon-zoomout").click(function(){
		FontResize(-1); 
		return false;
	});
	
	
	$(".vote").click(function(){
	var DivVote = this;
	$.getJSON($(this).attr("href")+"&json=true",{ajaxmethod:true}, function(data) {
		var ToAdd = data.modified;
		if(data.result){
			$(DivVote).parent("div").find(".Votes").html(($(DivVote).hasClass('voteup') ? eval($(DivVote).parent("div").find(".Votes").text()+"+"+ToAdd) : eval($(DivVote).parent("div").find(".Votes").text()+"-"+ToAdd)));
			$(DivVote).fadeTo('slow', 0.3, function() {
      $(this).attr("href", "#").unbind("click").click(function(){return false;});
    });
		}else{
		alert(data.message)
		}
	});
	return false;
	});
	
	
	
	if($(".setvideo").size())
		ThemeClass.LoadJS(URLS.JSCatalog+"js/JSbinder.php?Load=swfobject:video");
		
	$("#Report").click(function (){
		  $.get(URLS.Script+'Contact/?url='+escape(location.href)+'&view=true&html=true', function(d) {
				CreateWindowLayer("ErrorWindow", "<div style='width:400px;'>"+d+"</div>", "#ff0000");
	  });
	return false;
	});
	
  });


