DesktopClass = {
	generate : function (width, height) {
							var TableCreator = "<table class='xv-desktop-grid'><tbody>";
							for (n = 0; n <= height; ++n) {
								TableCreator += "<tr class='xv-desktop-row xv-desktop-row-"+n+"' data-xv-row="+n+">";
								for (zn = 0; zn <= width; ++zn) {
										TableCreator += "<td class='xv-desktop-column xv-desktop-place xv-desktop-"+n+"x"+zn+"' data-xv-pos='"+n+"x"+zn+"'></td>";
								};
								TableCreator += "</tr>";
							};
							TableCreator += "</tbody></table>";
							$(".xv-desktop").html(TableCreator);
						}

};

DesktopClass.icon = {
	width: 120,
	height: 60
};

$(function(){
DesktopClass.columns = {
	height : Math.floor($(".xv-desktop").height()/DesktopClass.icon.height),
	width : Math.floor($(".xv-desktop").width()/DesktopClass.icon.width)
}

DesktopClass.generate(DesktopClass.columns.width, DesktopClass.columns.height);

$(".xv-desktop-2x0").html(
"<div class='xv-desktop-icon' data-xv-link='"+AdminLink +"Widgets/'>"+
	"<div class='xv-desktop-icon-image'>"+
		"<img src='"+URLS.Site+"admin/data/icons/widgets.png' alt='Widgets' />"+
	"</div>"+
	"<div class='xv-desktop-icon-title'>"+
		"Widgets"+
	"</div>"+
"</div>");
$(".xv-desktop-1x0").html(
"<div class='xv-desktop-icon' data-xv-link='"+AdminLink +"Files/'>"+
	"<div class='xv-desktop-icon-image'>"+
		"<img src='"+URLS.Site+"admin/data/icons/files.png' alt='Files' />"+
	"</div>"+
	"<div class='xv-desktop-icon-title'>"+
		"Files FTP"+
	"</div>"+
"</div>");
$(".xv-desktop-0x0").html(
"<div class='xv-desktop-icon' data-xv-link='"+AdminLink +"Cache/'>"+
	"<div class='xv-desktop-icon-image'>"+
		"<img src='"+URLS.Site+"admin/data/icons/cache.png' alt='Cache' />"+
	"</div>"+
	"<div class='xv-desktop-icon-title'>"+
		"Clear cache"+
	"</div>"+
"</div>");

$( ".xv-desktop-place" ).sortable({
			connectWith: ".xv-desktop-place:not(:has(div))",
			update : function(){
				//alert($(this).data("xv-pos"));
			}
		});
$( ".xv-desktop-grid" ).selectable({
	filter: ".xv-desktop-icon"
});
$(".xv-desktop-icon").live("click", function(){
	$(".xv-desktop-place .ui-selected").removeClass("ui-selected");
	$(this).addClass("ui-selected");
}).live("dblclick", function(){
	ThemeClass.GetWindow($(this).data("xv-link").substr(AdminLink.length));
	return false;
});

});