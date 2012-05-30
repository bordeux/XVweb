//**** START OLD SCRIPT  ***//

var WriteClass = {
};

var ColorPickerActual = "#000000";
WriteClass.ColorPicker = function () {
	
	$.getScript(URLS['JSCatalog'] + "js/Colorpicker.js", function () {
			
			$('#ColorPicker').ColorPicker({
					color : '#0000ff', 
					onShow : function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					}, 
					onHide : function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					}, 
					onChange : function (hsb, hex, rgb) {
						ColorPickerActual = '#' + hex;
						$('#ColorPicker').css('backgroundColor', '#' + hex);
					}
				});
			
		});
	
};

WriteClass.CheckUrl = function () {
	$.getJSON(URLS.Script + "Write/?UrlCheck=true", {
			"xv-path" : $("#UrlArticleID").val() 
		}, function (json) {
			
			json["result"] != true ? $("#UrlArticleID").css({
					background : "url(" + URLS.Theme + "img/error.png) #EF7777 no-repeat top right", 
					border : "1px solid #FF0000"
				}) : $("#UrlArticleID").css({
					background : "url(" + URLS.Theme + "img/validate.png) #BEEF77 no-repeat top right", 
					border : "1px solid #7BBF17"
				});
			
		});
};

$(document).ready(function () {
		$("#UrlArticleID").change(function () {
				WriteClass.CheckUrl();
			});
		
		$('textarea').TextAreaResizer();
		$("[name^='settings[CSS]']").attr("id", "CSSeditor"); //.after('<input type="checkbox" id="DisableCM" name="CMDisable" /> <label for="DisableCM">Wyłacz</label>' );
		if ($('#CSSeditor').length) {
			var editor = CodeMirror.fromTextArea('CSSeditor', {
					height : "350px", 
					parserfile : "parsecss.js", 
					stylesheet : URLS.Theme + "js/CodeMirror/css/csscolors.css", 
					path : URLS['JSCatalog'] + "js/CodeMirror/js/", 
					onChange : function (n) {
						$("#CSSeditor").text(editor.getCode());
					}, 
					lineNumbers : true
				});
		}
		
		$("input[name^='settings']").click(function () {
				if ($(this).attr('name') == "settings[EnablePHP]" || $(this).attr('name') == "settings[EnableHTML]") 
					$("[name^='block[Article]'] option[value^='yes']").attr("selected", true);
				
				return true;
			});
		
		
	});

$(function () {
		function SetURLTool(toolid) {
			$(toolid).after($("<img>").attr('src', URLS.Theme + 'img/list.png').css('cursor', 'pointer').click(function () {
						CreateWindowLayer("SelectCategory", "<div id='SelectCatWindow'><label for='CategorySearch'>Szukaj kategorii: </label><input type='text' id='CategorySearch' style='width:250px;' /><div id='CategoryList' style='min-height:400px;'></div><div style='text-align:center'><input type='text' id='FinishedCategory' readonly='readonly' value='/' style='width:250px; border-color:#aaaaaa;' />  <input type='text' id='TitleSearch' style='width:150px;' value='" + $(toolid).val().split("/").reverse()[1] + "' /> / <br/><input type='button' value='Ustaw' id='CSetButton'/></div></div>", "#000");
						
						$("#CategorySearch, #CSetButton").unbind();

						$("#CSetButton").click(function () {
								$(toolid).val($('#FinishedCategory').val() + $('#TitleSearch').val() + '/');
								CancelWindowLayer("SelectCategory");
								return false;
							});
						return false;
					}));
		};
		SetURLTool('input[name="alias"]');
		SetURLTool('input[name="urlpath"]');
	});

//**** END OLD SCRIPT  ***//


$(function () {
		
		// This class is example - i use this to my project - XVweb
		var XVwebFormater = {
			parseReturnedXML : function (strToParse, strStart) {
				var str = strToParse.match(new RegExp("<" + strStart + "[^<]*(?:(?!<\/" + strStart + ">)<[^<]*)*<\/" + strStart + ">", "gi"));
				if (str != null) 
					return str;
				return[];
			}, 
			htmlspecialchars : function (p_string) {
				p_string = p_string.replace(/&/g, '&amp;');
				p_string = p_string.replace(/</g, '&lt;');
				p_string = p_string.replace(/>/g, '&gt;');
				return p_string;
			}, 
			htmlspecialchars_decode : function (p_string) {
				p_string = p_string.replace(/&amp;/g, '&');
				p_string = p_string.replace(/&lt;/g, '<');
				p_string = p_string.replace(/&gt;/g, '>');
				return p_string;
			}, 
			parse : function (text) {
				var XVtags = ["youtube", "vimeo", "digg", "megavideo", "var", "include", "php", "delphi", "cpp", "java", "java5", "css", "javascript", "code", "vars", "file", "script", "info"];
				$.each(XVtags, function (index, value) {
						$.each(XVwebFormater.parseReturnedXML(text, value), function (indexz, valuez) {
								text = text.replace(valuez, "<pre class='xv-to-remove xv-without-html'>" + XVwebFormater.htmlspecialchars(valuez) + "</pre>");
							});
					});
	
					text = text.replace( /(\<script(.*)\>)/gi ,"Illegal tag script tag ");
					//text =.replace(r,"Illegal tag script"); //text.replace(new RegExp("<script[^<]*(?:(?!>)<[^<]*)*>", "gi") ,'');
					//if(text.search(new RegExp("script", "i")) > 0){
					//	return "This content can't be show in WYSIWYG Editor - Secruity alert";
					//};
					var Containter = $("<div>");
					Containter.html(text);
					Containter.find("*").unbind();
					
				return Containter.html(); 
			}, 
			DeleteFormat : function () {
				$(this).find(".xv-without-html").html(function (index, oldhtml) {
						return oldhtml.replace(/(<([^>]+)>)/ig, "");
					});
			}, 
			EditorToHTML : function (text) {
				matchResult = text.match(new RegExp("<pre class=\"xv-to-remove[^<]*(?:(?!<\/pre>)<[^<]*)*<\/pre>", "gi"));
				if (matchResult != null) {
					$.each(matchResult, function (index, value) {
							text = text.replace(value, XVwebFormater.htmlspecialchars_decode(value.replace(/<pre(.*?)>/, "").replace(/<\/pre(.*?)>/, "")));
						});
				};
				
				return text;
			}
		};
		
		$("#XVWysiwyg").h5w({
				content : XVwebFormater.parse($(".xv-edit-content").text()), // here you can set content for editor
				onChange : XVwebFormater.DeleteFormat, // you can delete this line
				onTextarea : XVwebFormater.EditorToHTML, // you can delete this line
				onVisual : XVwebFormater.parse, // you can delete this line
			});
		
		$(".xv-form-wysiwyg").submit(function () {
				$(this).find(".xv-textarea-wysiwyg").val($("#XVWysiwyg").getContent());
				return true;
			});
		
	});
 