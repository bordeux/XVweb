$(function(){
function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name){
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
  return "";
}
if(getCookie("adult") != "yes"){
	var adult_layer = $("<div>").css({
		"position" : "fixed",
		"width" : "100%",
		"height" : "100%",
		"top" : "0",
		"left" : "0",
		"background" : "#000",
		"color" : "#FFF",
		"padding-top" : "10%",
		"text-align" : "center"
	});
	$("body").append(adult_layer);
	$(".xva-adult-message").show().appendTo(adult_layer);
	$(".xv-adult-yes").click(function(){
		adult_layer.hide("slow", function(){
			adult_layer.remove();
			setCookie("adult","yes",31);
		});
	
	});
};
	//adult_layer.remove();

});