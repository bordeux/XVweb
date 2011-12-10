var WriteClass = {};
   function $GetID(id) {
return document.getElementById(id);
}
var ColorPickerActual = "#000000";
WriteClass.ColorPicker = function(){


$.getScript(URLS.JSCatalog+"js/Colorpicker.js", function(){



  $('#ColorPicker').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		ColorPickerActual = '#' + hex;
		$('#ColorPicker').css('backgroundColor', '#' + hex);
	}
});

  
});



};
 function ChangeObiekt(Where, What, Layer) {
 $GetID(Where).innerHTML = What;
 CancelWindowLayer(Layer);
 }
 
 function AddTagIE(lft, rgt)
{
     strSelection = document.selection.createRange().text;
     if (strSelection!="")
     {
     document.selection.createRange().text = lft + strSelection + rgt;
     }
	 
}
 function AddTag(where, StartTag, EndTag) {
if(EndTag == undefined){
EndTag = "";
}
  if (navigator.appName=="Microsoft Internet Explorer")
 {
 AddTagIE(StartTag,EndTag);
 return true;
 }
   var txtarea = $GetID(where);
  var selStart = txtarea.selectionStart;
   var selEnd = txtarea.selectionEnd;
$("#"+where).val( (txtarea.value).substring(0,selStart)+
   StartTag+(txtarea.value).substring(selStart, selEnd)+EndTag +
   (txtarea.value).substring(selEnd,txtarea.value.length));
}

function ValidateArt(){
if($GetID('UrlArticleID') != null){
if($GetID('UrlArticleID').value.length < 2){
ErrorAlert("<b>Wadliwy adres artykułu- za krotki!</b>");
return false;
}
}

$GetID('ArticleEditForm').submit();
return true;
}

WriteClass.CheckUrl = function(){
$.getJSON(URLS.Script+"Write/?UrlCheck=true", { "xv-path": $("#UrlArticleID").val()}, function(json){

    json["result"] != true ? $("#UrlArticleID").css({background:"url(" + URLS.Theme + "img/error.png) #EF7777 no-repeat top right", border:"1px solid #FF0000"}) : $("#UrlArticleID").css({background:"url(" + URLS.Theme + "img/validate.png) #BEEF77 no-repeat top right", border:"1px solid #7BBF17"});

});
};

$(document).ready(function() {
	$("#UrlArticleID").change(function(){
	WriteClass.CheckUrl();
	});

  
  
  $('textarea').TextAreaResizer();
  $("[name^='settings[CSS]']").attr("id", "CSSeditor");//.after('<input type="checkbox" id="DisableCM" name="CMDisable" /> <label for="DisableCM">Wyłacz</label>' );
  if($('#CSSeditor').length){
   var editor = CodeMirror.fromTextArea('CSSeditor', {
    height: "350px",
    parserfile: "parsecss.js",
    stylesheet: URLS.Theme+"js/CodeMirror/css/csscolors.css",
    path: URLS.JSCatalog+"js/CodeMirror/js/",
	onChange: function (n) { $("#CSSeditor").text(editor.getCode());},
	lineNumbers: true
  });
  }

$("input[name^='settings']").click(function(){
if($(this).attr('name') == "settings[EnablePHP]" || $(this).attr('name') == "settings[EnableHTML]")
		$("[name^='block[Article]'] option[value^='yes']").attr("selected", true);

	
});

$('#ArticleEditForm').submit(function() {

//onsubbmit

  
  
  
  return true;
});
  
});

$(function(){
function SetURLTool(toolid){
$(toolid).after($("<img>").attr('src', URLS.Theme+'img/list.png').css('cursor', 'pointer').click(function(){
	CreateWindowLayer("SelectCategory", "<div id='SelectCatWindow'><label for='CategorySearch'>Szukaj kategorii: </label><input type='text' id='CategorySearch' style='width:250px;' /><div id='CategoryList' style='min-height:400px;'></div><div style='text-align:center'><input type='text' id='FinishedCategory' readonly='readonly' value='/' style='width:250px; border-color:#aaaaaa;' />  <input type='text' id='TitleSearch' style='width:150px;' value='"+$(toolid).val().split("/").reverse()[1]+"' /> / <br/><input type='button' value='Ustaw' id='CSetButton'/></div></div>", "#000");
	
	$("#CategorySearch, #CSetButton").unbind();
	$("#CategorySearch").keyup(function(){
	$.getJSON(URLS['Script']+'Ajax/Category_List/js.js', { url: $("#CategorySearch").val() }, function(json){
	$("#CategoryList").html("");
		for ( var i in json ){
			$("#CategoryList").append(		$("<div>").html(json[i].URL).click(function(){
				$("#FinishedCategory").val($(this).html());
			}));
		}
    });
	});
	$("#CSetButton").click(function(){
		$(toolid).val($('#FinishedCategory').val()+$('#TitleSearch').val()+'/');
		CancelWindowLayer("SelectCategory");
	});
}));
};
SetURLTool('input[name="alias"]');
SetURLTool('input[name="urlpath"]');
});

