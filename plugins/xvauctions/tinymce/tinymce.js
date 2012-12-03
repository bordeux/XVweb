$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			
			script_url : URLS['Site']+'/plugins/xvauctions/tinymce/jscripts/tiny_mce/tiny_mce.js',
			content_css : URLS['Theme']+"xvauctions/css/desc.css",
			body_class : "xvauction-description-text",
			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			relative_urls : false,
			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true
		});
$(".xvauction-templates-show").click(function(){
	var actualEditor = $(this).parents(".xvauction-add-item").find(".tinymce");
	var iframeWith = $("<iframe style='width: 100%; height; 50px;' src='"+URLS['AuctionsAdd']+"/?step=templates' ></iframe>");
	$(this).replaceWith(iframeWith);
	iframeWith.load(function(){
		$(this).contents().find("a").click(function(){
			$.get(URLS['AuctionsAdd'], { step: 'get_template', theme: $(this).data("xva-theme") } , function(data) {
				actualEditor.val(data);
			});
			return false;
		});
	});

	return false;
});
	});
	