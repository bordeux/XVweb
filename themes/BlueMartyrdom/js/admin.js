AdminClass = {};


AdminClass.ConfigPage = function(){
	AdminClass.ThemeRefresh();
};
AdminClass.ThemeRefresh = function(){
	$(".Seleced").fadeTo("slow", 1);
	$(".NoSeleced").fadeTo("slow", 0.40).hover(
	function () {
		$(this).fadeTo("fast", 1).css("cursor","pointer");
	}, 
	function () {
		$(this).fadeTo("slow", 0.40);
	}
	).click(function(){
		$("#config-theme").val($(this).attr("id"));
		$(".Seleced").attr("class", "NoSeleced"); 
		$(this).attr("class", "Seleced").unbind();
		AdminClass.ThemeRefresh();
	});
};


function setCharAt(str,index,chr) {
	if(index > str.length-1) return str;
	return str.substr(0,index) + chr + str.substr(index+1);
}

AdminClass.RankPicker = function(a){
	var pleft=$(a).offset().left+$(a).width();
	var ptop=$(a).offset().top;
	$("#EditRankTool").css({"top": ptop, "left":pleft});
	var AdminRank = $(a).val();
	for (var x=0; x<AdminRank.length; x++) {
		if(AdminRank[x]=="1")
		$("#EditRankTool input[value="+x+"]").attr('checked', true);
		else
		$("#EditRankTool input[value="+x+"]").removeAttr("checked");
	}
	$("#EditRankTool input").unbind('change');

	$("#EditRankTool input").change(function(){
		var Bits = "";
		$("#EditRankTool input").each(function(i){
			if($(this).attr('checked'))
			Bits +="1"; else Bits +="0";

		});
		$(a).val(Bits);
	});
	$("#EditRankTool").show("slow");
	$("#EditRankTool input[type='button']").click(function(){
		$("#EditRankTool").hide("slow");
		
		
	});
};


$(function(){
	$(function(){
		$(".codexml").each(function(){
			var editor = CodeMirror.fromTextArea($(this).attr('id'), {
height: "350px",
parserfile: "parsexml.js",
stylesheet: URLS.Theme+"js/CodeMirror/css/xmlcolors.css",
path: URLS.JSCatalog+"js/CodeMirror/js/",
onChange: function (n) { $("#MenuXML").text(editor.getCode());},
lineNumbers: true
			});
		});		


	});
	$('.xv-easyedit').dblclick(function() {
		$(this).html($("<input>").attr({"type":"text", "id":"EditNameWidget",  }).css("width", "100%").val($(this).html()).blur(function(){
			if($(this).val() != ""){
				$(this).replaceWith($(this).val());
				IndexPageClass.Save();
			}
		}));
		$("#EditNameWidget").focus();
	});
$("input[id^='config-rank-']").bind("click", function(e) {
		AdminClass.RankPicker(this);
	});
	
	$(".EditBan").click(function(){
		var BanRow = $(this).parent().parent();
		$("input[name='AddBan']").val($(BanRow).find(".ip").html());
		$("input[name='TimeOut']").val($(BanRow).find(".timeout").html());
		$("textarea[name='Message']").val($(BanRow).find(".message").text());
	});
	if($("#TextDiv").attr("class") == "Config"){
		AdminClass.ConfigPage();
	}
	
	var ThemesListing = eval('(' + ($("#ThemesListing").html()) + ')');
	$("#config-theme").hide();
	for(var i in ThemesListing){
	var ClassSelected = "NoSeleced";
		if($("#config-theme").val() == ThemesListing[i]['name'])
			var ClassSelected = "Seleced";
	$("#config-theme").after("\t\t\t\t<div style=\"border:1px solid #C9DEA1; margin-left:150px; width:400px; height:100px; padding:5px;\" class=\""+ClassSelected+"\" id=\""+ThemesListing[i]['name']+"\">\n\t\t\t\t\t\t<div class=\"table\">\n\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t<div class=\"table-cell\"><img src=\""+URLS['Site']+"themes\/"+ThemesListing[i]['name']+"\/"+ThemesListing[i]['screenshot']+"\" alt=\"ScreenShot\" \/> <\/div>\n\t\t\t\t\t\t\t\t<div class=\"table-cell\" style=\"padding-left:10px; display:inline-block;\"> \n\t\t\t\t\t\t\t\t\t\t<div class=\"table\">\n\t\t\t\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><b>"+Language['Name']+":<\/b> <\/div>\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\">"+ThemesListing[i]['name']+" <\/div>\n\t\t\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><b>"+Language['Author']+":<\/b> <\/div>\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\">"+ThemesListing[i]['author']+"<\/div>\n\t\t\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><b>Corporation:<\/b> <\/div>\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\">"+ThemesListing[i]['corporation']+" <\/div>\n\t\t\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><b>"+Language['Page']+":<\/b> <\/div>\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><a href=\""+ThemesListing[i]['url']+"\">"+ThemesListing[i]['url']+"<\/a> <\/div>\n\t\t\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t\t\t\t<div class=\"table-row\">\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\"><b>"+Language['Version']+":<\/b> <\/div>\n\t\t\t\t\t\t\t\t\t\t\t<div class=\"table-cell\">"+ThemesListing[i]['version']+"<\/div>\n\t\t\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t\t<\/div>\n\t\t\t\t\t\t<\/div>\n\t\t\t\t<\/div>");
	}
	AdminClass.ThemeRefresh();
});
