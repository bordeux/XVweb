if(jQuery) {
	jQuery.fn.attrList = function( strAttribute, strDelimiter ){
		// Create an array to store the attribute values of
		// the jQuery stack items.
		var arrValues = new Array();

		// Check to see if we were given a delimiter.
		// By default, we will use the comma.
		strDelimiter = (strDelimiter ? strDelimiter : ",");

		// Loop over each element in the jQuery stack and
		// add the given attribute to the value array.
		this.each(
		function( intI ){
			// Get a jQuery version of the current
			// stack element.
			var jNode = $( this );

			// Add the given attribute value to our
			// values array.
			arrValues[ arrValues.length ] = jNode.attr(
			strAttribute
			);

		}
		);

		// Return the value list by joining the array.
		return(
		arrValues.join( strDelimiter )
		);
	}
};

$(function(){
function htmlspecialchars(p_string) {
	p_string = p_string.replace(/&/g, '&amp;');
	p_string = p_string.replace(/</g, '&lt;');
	p_string = p_string.replace(/>/g, '&gt;');
	p_string = p_string.replace(/"/g, '&quot;');
//	p_string = p_string.replace(/'/g, '&#039;');
	return p_string;
};
	var DrawMenu = function(){
		var XMLMenu = ($("#MenuXML").val());
		var DrawMenuPlace = "#DrawMenu";
		var WorkVar = "";
		$(XMLMenu).children().each(function(){
			WorkVar = '<fieldset class="paddingbottom">';
			WorkVar += ('<legend><span class="xv-easyedit xv-menu-main-name">'+$(this)[0].tagName+'</span></legend>');
			$(this).children().each(function(){
				WorkVar +='<div class="ui-dialog ui-widget ui-widget-content ui-corner-all  xv-widget xv-menu-submenu"  style="width:100%;">';
				WorkVar +=   '<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix xv-menu-submenu-title">';
				WorkVar +=	'  <span id="ui-dialog-title-dialog" class="ui-dialog-title xv-easyedit ">'+$(this).attr('title')+'</span>';
				$(this).removeAttr('title');
				WorkVar +=	'  <a class="ui-dialog-titlebar-close ui-corner-all xv-delete" href="#Delete"><span class="ui-icon ui-icon-closethick">close</span></a>';
				WorkVar +=  '</div>';
				WorkVar +=  ' <div style="min-height: 109px; width: auto;" class="ui-dialog-content ui-widget-content">';
				WorkVar +=	 ' <div class="widget-content xv-menu-submenu-content">';
				WorkVar +=	 '<table class="xv-menu-submenu-attr">';
				var attrs = $(this)[0].attributes;
				for(var i=0;i<attrs.length;i++) {
					WorkVar +=	 '<tr class="xv-menu-attribute">';
						WorkVar +=	 '<td class="xv-menu-attribute-key">'+attrs[i].nodeName+'</td>';
						WorkVar +=	 '<td class="xv-menu-attribute-val">'+attrs[i].nodeValue+'</td>';
					WorkVar +=	 '</tr>';
				}
				WorkVar +=	 '<tr class="xv-menu-attribute-add">';
				WorkVar +=	 '<td class="xv-menu-attribute-key-add"><input type="text" value=""  /></td>';
				WorkVar +=	 '<td class="xv-menu-attribute-val-add"><input type="text" value="" /></td>';
				WorkVar +=	 '<td class="xv-menu-attribute-val-add"><a href="#" class="xv-menu-attribute-val-add-link"><span class="ui-button  ui-icon ui-icon-circle-plus"></span></a></td>';
				WorkVar +=	 '</tr>';
				WorkVar +=	 '</table>';	
				$(this).children().each(function(){
					WorkVar +='<div class="ui-dialog ui-widget ui-widget-content ui-corner-all  xv-widget xv-menu-url"  style="width:100%;" >';
					WorkVar +=   '<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix xv-menu-url-holder" style="background: #ffbcbc;">';
					WorkVar +=	'  <span id="ui-dialog-title-dialog" class="ui-dialog-title xv-easyedit xv-menu-url-name">'+$(this).text()+'</span>';
					WorkVar +=	'  <a class="ui-dialog-titlebar-close ui-corner-all xv-delete" href="#"><span class="ui-icon ui-icon-closethick">close</span></a>';
					WorkVar +=  '</div>';
					WorkVar +=  ' <div style="width: auto;" class="ui-dialog-content ui-widget-content">';
					WorkVar +=	 ' <div class="widget-content">';
					WorkVar +=	 ' <div class="xv-menu-parameters">';
					WorkVar +=	 '<table>';
					var attrs = $(this)[0].attributes;
					
					for(var i=0;i<attrs.length;i++) {
						WorkVar +=	 '<tr class="xv-menu-attribute">';
						WorkVar +=	 '<td class="xv-menu-attribute-key xv-easyedit">'+attrs[i].nodeName+'</td>';
						WorkVar +=	 '<td class="xv-menu-attribute-val xv-easyedit">'+attrs[i].nodeValue+'</td>';
						WorkVar +=	 '</tr>';
					}
					WorkVar +=	 '<tr class="xv-menu-attribute-add">';
					WorkVar +=	 '<td class="xv-menu-attribute-key-add"><input type="text" value="" /></td>';
					WorkVar +=	 '<td class="xv-menu-attribute-val-add"><input type="text" value="" /></td>';
					WorkVar +=	 '<td class="xv-menu-attribute-val-add"><a href="#" class="xv-menu-attribute-val-add-link"><span class="ui-button  ui-icon ui-icon-circle-plus"></span></a></td>';
					WorkVar +=	 '</tr>';
					WorkVar +=	 '</table>';
					WorkVar +=	 ' </div>';
					
					WorkVar +='</div>';
					WorkVar +='   </div>';
					WorkVar += '</div>	';
				});
				WorkVar +=	 '<a href="#" class="xv-menu-add-new-submenu">Add new submenu</a>';
				WorkVar +='</div>';
				WorkVar +='   </div>';
				WorkVar += '</div>	';
			});
			WorkVar +=	 '<a href="#" class="xv-menu-add-new-position">Add new positon</a>';
			WorkVar +=  ('</fieldset>');
			$(DrawMenuPlace).append(WorkVar);
		});
		var UpdateElements = function(){
		$('.xv-easyedit').unbind("dblclick").dblclick(function() {
			$(this).html($("<input>").attr({"type":"text", "id":"EditNameWidget",  }).css("width", "100%").val($(this).html()).blur(function(){
				if($(this).val() != ""){
					$(this).replaceWith($(this).val());
					IndexPageClass.Save();
				}
			}));
			$("#EditNameWidget").focus();
		});
		
		$(".xv-menu-attribute-val-add-link").unbind("click").click(function(){
				var WorkVar =	 '<tr class="xv-menu-attribute">';
						WorkVar +=	 '<td class="xv-menu-attribute-key">'+$(this).parent().parent().find('.xv-menu-attribute-key-add input').val()+'</td>';
						WorkVar +=	 '<td class="xv-menu-attribute-val">'+$(this).parent().parent().find('.xv-menu-attribute-val-add input').val()+'</td>';
					WorkVar +=	 '</tr>';
					
					$(this).parent().parent().before(WorkVar);
			$(this).parent().parent().find('.xv-menu-attribute-val-add input').val("");
			$(this).parent().parent().find('.xv-menu-attribute-key-add input').val("");
			UpdateElements();
			return false;
		});
		
			$(".xv-delete").unbind("click").click(function(){
				$(this).parent().parent().hide("slow", function(){
					$(this).remove()
				});
				return false;
			});
			
			$(".xv-menu-attribute").unbind("hover").hover(
			function () {
				$(this).find(".xv-menu-attribute-delete").remove();
				$(this).append($('<td class="xv-menu-attribute-delete"><a href="#DeleteAttr" class="xv-menu-attribute-delete-link" style="margin-left:-20px;"><span class="ui-button  ui-icon ui-icon-circle-minus"></span></a></td>'));
				$(".xv-menu-attribute-delete-link").click(function(){
					$(this).parents(".xv-menu-attribute").hide("slow", function(){
						$(this).remove()
					});
				});
				
			}, 
			function () {
				$(this).find(".xv-menu-attribute-delete").remove();
			}
			);
		$(".xv-menu-url-holder").unbind("click").click(function(){
			//$(this).find(".xv-menu-parameters").show();
			$(this).parent().find(".xv-menu-parameters").toggle();
		});
				
				
			 $("fieldset").unbind("sortable").sortable({
                        update: function(event, ui) { },
                        connectWith: 'fieldset',
                        placeholder: 'placeholder',
                        handle: '.xv-menu-submenu-title',
                        opacity: 0.6,
                        revert: true,
                        forcePlaceholderSize: true
                });	
				$(".xv-menu-submenu .xv-menu-submenu-content").unbind("sortable").sortable({
                        update: function(event, ui) { },
                        connectWith: '.xv-menu-submenu .xv-menu-submenu-content',
                        placeholder: 'placeholder',
                        handle: '.xv-menu-url-holder',
                        opacity: 0.6,
                        revert: true,
                        forcePlaceholderSize: true
                });
				
				$(".xv-menu-add-new-submenu").unbind("click").click(function(){

					$(this).before('<div class="ui-dialog ui-widget ui-widget-content ui-corner-all  xv-widget xv-menu-url" style="width:100%;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix xv-menu-url-holder" style="background: #ffbcbc;">  <span id="ui-dialog-title-dialog" class="ui-dialog-title xv-easyedit xv-menu-url-name">NewSubMenu</span>  <a class="ui-dialog-titlebar-close ui-corner-all xv-delete" href="#"><span class="ui-icon ui-icon-closethick">close</span></a></div> <div style="width: auto;" class="ui-dialog-content ui-widget-content"> <div class="widget-content"> <div class="xv-menu-parameters"><table><tbody><tr class="xv-menu-attribute-add"><td class="xv-menu-attribute-key-add"><input type="text" value=""></td><td class="xv-menu-attribute-val-add"><input type="text" value=""></td><td class="xv-menu-attribute-val-add"><a href="#" class="xv-menu-attribute-val-add-link"><span class="ui-button  ui-icon ui-icon-circle-plus"></span></a></td></tr></tbody></table> </div></div>   </div></div>');
					UpdateElements();
				return false;
				});	
				$(".xv-menu-add-new-position").unbind("click").click(function(){
					$(this).before('<div class="ui-dialog ui-widget ui-widget-content ui-corner-all  xv-widget xv-menu-submenu" style="width:100%;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix xv-menu-submenu-title">  <span id="ui-dialog-title-dialog" class="ui-dialog-title xv-easyedit ">New Position</span>  <a class="ui-dialog-titlebar-close ui-corner-all xv-delete" href="#Delete"><span class="ui-icon ui-icon-closethick">close</span></a></div> <div style="min-height: 109px; width: auto;" class="ui-dialog-content ui-widget-content"> <div class="widget-content xv-menu-submenu-content ui-sortable"><table class="xv-menu-submenu-attr"><tbody><tr class="xv-menu-attribute-add"><td class="xv-menu-attribute-key-add"><input type="text" value=""></td><td class="xv-menu-attribute-val-add"><input type="text" value=""></td><td class="xv-menu-attribute-val-add"><a href="#" class="xv-menu-attribute-val-add-link"><span class="ui-button  ui-icon ui-icon-circle-plus"></span></a></td></tr></tbody></table>						<a href="#" class="xv-menu-add-new-submenu">Add new submenu</a></div>   </div></div>');
					UpdateElements();
				return false
				});
		};
		UpdateElements();
	};
	DrawMenu();
	
var GetXML = function(){
var DrawMenuPlace = "#DrawMenu";

var XML = '<?xml version="1.0" encoding="utf-8"?>';
    XML += '<menu>';
	$(DrawMenuPlace + " fieldset").each(function(){
		XML += '<'+$(this).find(".xv-menu-main-name").text().toLowerCase()+'>';
		$(this).find(".xv-menu-submenu").each(function(){
					XML += '<submenu title="'+$(this).find(".xv-menu-submenu-title .xv-easyedit").text()+'" ';
						$(this).find(".xv-menu-submenu-attr .xv-menu-attribute").each(function(){
							XML += $(this).find(".xv-menu-attribute-key").text()+"=\""+htmlspecialchars($(this).find(".xv-menu-attribute-val").html())+"\" "
						});
					XML += '>';
					$(this).find(".xv-menu-url").each(function(){
					XML += '<url ';
						$(this).find(".xv-menu-parameters .xv-menu-attribute").each(function(){
							XML += $(this).find(".xv-menu-attribute-key").text()+"=\""+htmlspecialchars($(this).find(".xv-menu-attribute-val").html())+"\" "
						});
					XML += '>';
					XML += htmlspecialchars($(this).find(".xv-menu-url-name").html());
					XML += '</url>';
					});
						
					XML += '</submenu>';
		});
		XML += '</'+$(this).find(".xv-menu-main-name").text().toLowerCase()+'>';
	
	});
	XML += '</menu>';
return XML;
};
$("#MenuVisualForm").submit(function(){
	$("#MenuVisualForm #MenuXML").val(GetXML());
	return true;
});
});
