$(document).ready(function(){

	var UpdateTo = function(){
	var a = $("input[type='text'][name='To']");
	if(a.val()){
		  $.getJSON(URLS.Script + "receiver/User/?User=" + encodeURIComponent(a.val()), function(b) {
		if(b){
		$(a).css({background:"url('" + b.AvantURL + encodeURIComponent(b.Avant ? b.Nick : "") + "_16.jpg') #BEEF77 no-repeat top right", border:"1px solid #7BBF17"})
		}else{
		  $(a).css({background:"url(" + URLS.Theme + "img/error.png) #EF7777 no-repeat top right", border:"1px solid #FF0000"});
		}
  });
  };
	};
	
$("input[type='text'][name='To']").change(UpdateTo);
UpdateTo();

$("#SelectAll").click(function(){
   var checked_status = this.checked;
   $("input[name^='DeleteMSG']").each(function(){
  
    this.checked = checked_status;
   });
  });
  
});