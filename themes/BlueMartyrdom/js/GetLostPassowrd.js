ThemeClass.GetLostPassword = function(){
ThemeClass.LostPasswordForm = 		["<form id='LostPForm' onsubmit='ThemeClass.LostPasswordSend(); return false;' method='post' action='"+URLS.Script + "LostPass/Get/'>",
		"<div class='LightBulbTip'>",
		"<img src='"+URLS.Theme+"img/LightbulbIcon.png'/> Podaj adres e-mail, z którego korzystasz w serwisie i kliknij Dalej.",
		"</div>",
		"<br/>",
		"<label for='textinput'>Adres email: </label>","<input type='text' id='textinput' class='StyleForm' name='LostEmail' size='12' />",
		"<br/><br/>",
		"<input type='button' id='LostPButton' value='",Language["Send"],"' class='StyleForm' onclick='ThemeClass.LostPasswordSend(); return false;'/>",
		"</form>"].join("");
CreateWindowLayer("PassworLost",
["<div id='LostPasswordID'>",
	"<div style='float: left;'>",
		"<img src='"+URLS.Theme+"img/query.png' id='LostPIcon'>",
	"</div>",
	"<div style='float: left; margin:15px;' id='LostPContent'>",
		ThemeClass.LostPasswordForm,
	"</div>",
	"<div style='clear: both;'></div>",
"</div>"].join(""));
ThemeClass.LostPasswordSend = function() {
sendPost("LostPContent", "LostPForm", URLS.Script + "LostPass/Get/?tooo");
};
}