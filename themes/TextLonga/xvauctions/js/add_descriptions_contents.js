$(function(){

        var XVauctionsFormater = {
                                        parseReturnedXML : function(strToParse, strStart){
                                                                                        var str = strToParse.match(new RegExp("<"+strStart+"[^<]*(?:(?!<\/"+strStart+">)<[^<]*)*<\/"+strStart+">", "gi"));
                                                                                        if (str != null) 
                                                                                        return str;
                                                                                        return [];
                                                                                },
                                        htmlspecialchars : function(p_string) {
                                                                                        p_string = p_string.replace(/&/g, '&amp;');
                                                                                        p_string = p_string.replace(/</g, '&lt;');
                                                                                        p_string = p_string.replace(/>/g, '&gt;');
                                                                                        return p_string;
                                                                                },
                                        htmlspecialchars_decode : function(p_string) {
                                                                                                p_string = p_string.replace(/&amp;/g, '&');
                                                                                                p_string = p_string.replace(/&lt;/g, '<');
                                                                                                p_string = p_string.replace(/&gt;/g, '>');
                                                                                                return p_string;
                                                                                        },
                                        parse :                         function(text){
                                                                                        var XVtags = ["include", "php", "delphi", "cpp", "java", "java5", "css", "javascript", "code", "vars", "file", "script"];
                                                                                        $.each(XVtags, function(index, value) {
                                                                                                $.each(XVauctionsFormater.parseReturnedXML(text, value), function(indexz, valuez) {
                                                                                                        text = text.replace(valuez, "<pre class='xv-to-remove xv-without-html'>"+XVauctionsFormater.htmlspecialchars(valuez)+"</pre>");
                                                                                                });
                                                                                        });
                                                                                        return text;
                                                                                },
                                        DeleteFormat    : function(){
                                                $(this).find(".xv-without-html").html(function(index, oldhtml){
                                                        return oldhtml.replace(/(<([^>]+)>)/ig,"");
                                                });
                                        },
                                        EditorToHTML : function(text){
                                                matchResult = text.match(new RegExp("<pre class=\"xv-to-remove[^<]*(?:(?!<\/pre>)<[^<]*)*<\/pre>", "gi"));
                                                if(matchResult != null){
                                                        $.each(matchResult, function(index, value){
                                                                text = text.replace(value, XVauctionsFormater.htmlspecialchars_decode(value.replace(/<pre(.*?)>/, "").replace(/<\/pre(.*?)>/, "")));
                                                        });
                                                };
                                                
                                                return text;
                                        }
                                };
								
	$(".xvauction-editor").each(function(){
			$(this).h5w({
				content :  $(this).find(".h5w-texarea").val() ,       // here you can set content for editor
				onChange :   XVauctionsFormater.DeleteFormat,         // you can delete this line
				onTextarea :  XVauctionsFormater.EditorToHTML,        // you can delete this line
				onVisual :  XVauctionsFormater.parse,                         // you can delete this line
			});
	});		
$(".xvauction-add-form").submit(function(){
		$(".xvauction-editor").getContent();
	return true;
	});
var ItemTypeAuction = function(name, hide){
	if(hide){
		$("input[name='add["+name+"]']").parents(".xvauction-add-item").hide("slow")
	}else{
		$("input[name='add["+name+"]']").parents(".xvauction-add-item").show("slow")
	}
};

var refreshTypeAuction = function(){
		var AuctionType = parseInt($("select[name='add[type]']").val());
		ItemTypeAuction("buynow" ,true);
		ItemTypeAuction("auction_start" ,true);
		ItemTypeAuction("auction_min" ,true);
		ItemTypeAuction("dutch_start" ,true);
		ItemTypeAuction("dutch_min" ,true);
		switch (AuctionType){
			case 0: // kup teraz
			  ItemTypeAuction("buynow" ,false);
			  break;
			case 1: //aukcja
				ItemTypeAuction("auction_start" ,false);
				ItemTypeAuction("auction_min" ,false);
			  break;
			case 2: // kup teraz + aukcja
				ItemTypeAuction("buynow" ,false);
				ItemTypeAuction("auction_start" ,false);
				ItemTypeAuction("auction_min" ,false);
			  break;
			case 3: // aukcja holenderska
				ItemTypeAuction("dutch_start" ,false);
				ItemTypeAuction("dutch_min" ,false);
			  break;
			};
	};
	
$("select[name='add[type]']").change(refreshTypeAuction);
refreshTypeAuction();

$(".xvauction-templates-show").click(function(){
	var actualEditor = $(this).parents(".xvauction-editor");
	var iframeWith = $("<iframe style='width: 100%; height; 50px;' src='"+URLS['AuctionsAdd']+"/?step=templates' ></iframe>");
	$(this).replaceWith(iframeWith);
	iframeWith.load(function(){
		$(this).contents().find("a").click(function(){
			$.get(URLS['AuctionsAdd'], { step: 'get_template', theme: $(this).data("xva-theme") } , function(data) {
				actualEditor.setContent(data);
			});
			return false;
		});
	});

	return false;
});
});