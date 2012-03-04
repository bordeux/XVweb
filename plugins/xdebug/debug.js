
var DebugCons = {};
DebugCons.about = {version:1.00, author:"Krzysztof Bednarczyk"};
DebugCons.isset = function( variable ){return( typeof( variable ) != 'undefined' );}
DebugCons.Load = function(){
	$("body").prepend(
	$("<div></div>").css({position: "fixed", bottom:"0px", right:"0px", width:"100%", opacity: 0.6, "z-index":"50"}).hover(
	function () {
		$(this).css("opacity", 1);
	}, 
	function () {
		$(this).css("opacity", 0.6);
	}
	).append(
	$("<span></span>").addClass("debugm").css({height:"20px", background:"", padding:"5px;", float:"right", paddingRight:"5px"}).append($("<img src='"+rootDir+"plugins/xdebug/debug.png' alt='Debug'/> ").click(function(){
	
	$("#ConsoleWindow").html(["<img src='",rootDir,"plugins/xdebug/xvdebug.png' alt='Debug'/><br/> Version: ",DebugCons.about.version,"<br/> Author: ", DebugCons.about.author].join('')).toggle("slow");
	})).append(' <span>|</span> ').append(
	$("<span></span>").addClass("debugm").attr("id", "ConsoleTime").html("<img src='"+rootDir+"plugins/xdebug/time.png' />"+(Math.round(DebugConsole.GeneratedTime*10000)/10000)).click(function(){
		$("#ConsoleWindow").html("").append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"PHP ver : "+DebugConsole.PHPVer
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Zend ver : "+DebugConsole.ZendVer
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Used function count : "+DebugConsole.FunctionsCount
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Time : "+DebugConsole.GeneratedTime+" MS"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Memory Usage : "+DebugConsole.MemUsage+"B  = "+DebugConsole.MemUsage/1024+" KB = "+DebugConsole.MemUsage/1024/1024+" MB  = "+(100*(DebugConsole.MemUsage/1024/1024))/DebugConsole.MemLimit+" %"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Memory Peak Usage : "+DebugConsole.MemPeakUsage+"B  = "+DebugConsole.MemPeakUsage/1024+" KB = "+DebugConsole.MemPeakUsage/1024/1024+" MB = "+(100*(DebugConsole.MemPeakUsage/1024/1024))/DebugConsole.MemLimit+" %"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Memory Limit : "+DebugConsole.MemLimit+" MB"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Loaded Classes:"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").attr("id","ConsoleSQLrows").css({marginLeft:"20px"}));
		
		for(i in DebugConsole.Debug.Classes)
			$("#ConsoleSQLrows").append($("<div></div>").attr("class", "ConsoleSQLZr").css("border", "#EEEFA4").html("Class Name : <span style='color:#0012DF; font-weight:bold;'>"+DebugConsole.Debug.Classes[i].ClassName+"</span> ; File: <span style='color:#FF0000'>"+DebugConsole.Debug.Classes[i].File+"</span> ; Time : "+DebugConsole.Debug.Classes[i].Time+" = "+(Math.round(DebugConsole.Debug.Classes[i].Time*10000)/10000)+"MS  ; Memory Usage : <span style='color:#0C4F00'>"+DebugConsole.Debug.Classes[i].MemoryUsage+"B  = "+DebugConsole.Debug.Classes[i].MemoryUsage/1024+" KB = "+DebugConsole.Debug.Classes[i].MemoryUsage/1024/1024+" MB <span>"));
			
			$("#ConsoleWindow").append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Included files - "+(DebugConsole.IncludedFiles.length)+" :"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").attr("id","ConsoleFilesRows").css({marginLeft:"20px"}));
		
		for(i in DebugConsole.IncludedFiles)
			$("#ConsoleFilesRows").append($("<div></div>").attr("class", "ConsoleSQLZr").css("border", "#EEEFA4").html((parseFloat(i)+1)+". "+DebugConsole.IncludedFiles[i]+""));
			
			if(DebugCons.isset(DebugConsole.Debug.Cache.Cached)){
			$("#ConsoleWindow").append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"Cached - "+(DebugConsole.Debug.Cache.Cached.length)+" :"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").attr("id","ConsoleCachedFiles").css({marginLeft:"20px"}));
		for(i in DebugConsole.Debug.Cache.Cached)
			$("#ConsoleCachedFiles").append($("<div></div>").attr("class", "ConsoleCached").css("border", "#EEEFA4").html((parseFloat(i)+1)+". Category: "+DebugConsole.Debug.Cache.Cached[i][0]+" Handle: "+DebugConsole.Debug.Cache.Cached[i][1]+" Time: "+DebugConsole.Debug.Cache.Cached[i][2]+""));
		}
		if(DebugCons.isset(DebugConsole.Debug.Cache.NoCached)){
					$("#ConsoleWindow").append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html(
		"NoCached - "+(DebugConsole.Debug.Cache.NoCached.length)+" :"
		)).append($("<div></div>").attr("class", "ConsoleSQLRow").attr("id","ConsoleNoCachedFiles").css({marginLeft:"20px"}));
		for(i in DebugConsole.Debug.Cache.NoCached)
			$("#ConsoleNoCachedFiles").append($("<div></div>").attr("class", "ConsoleCached").css("border", "#EEEFA4").html((parseFloat(i)+1)+". Category: "+DebugConsole.Debug.Cache.NoCached[i][0]+" Handle: "+DebugConsole.Debug.Cache.NoCached[i][1]+" Time: "+DebugConsole.Debug.Cache.NoCached[i][2]+""));
		}
		
		$('.ConsoleSQLZr:odd').css("background", "#CFFFDA"); 
		$('.ConsoleSQLRow:odd').css("background", "#CFCFCF"); 
		$("#ConsoleWindow").show("slow");
	}) // time
	).append(' <span>|</span> ').append(
	$("<span></span>").addClass("debugm").attr("id", "ConsoleSQl").html("<img src='"+rootDir+"plugins/xdebug/database.png' /> "+DebugConsole.SQL.length).click(function(){
		$("#ConsoleWindow").html("");
		for(i in DebugConsole.SQL){
			$("#ConsoleWindow").append($("<div></div>").attr("class", "ConsoleSQLRow").css({}).html((DebugConsole.SQL[i]).replace("\n","<br/>").replace("\r","<br/>")));
		}
		
		
		 $('.ConsoleSQLRow:odd').css("background", "#CFCFCF");
		$("#ConsoleWindow").show("slow");
	})
	)
	).append($("<div></div>").attr("id","ConsoleWindow").css({background:"#E4E4E4", height:"200px", overflow: "scroll", width:"100%"}).hide())

	);
	$(".debugm").css({cursor:"pointer"});
};

DebugCons.ShowConsole = function(){
	alert("jasne");
}
$(function(){
	if(typeof DebugConsole != "undefined"){
		DebugCons.Load();
	};
});
