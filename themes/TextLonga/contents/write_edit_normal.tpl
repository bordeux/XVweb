				<div id="PreviewArticle">&nbsp;</div>
<form name="ArticleEditForm" id="ArticleEditForm" method="post" action="{$UrlScript}Write/?save={$IDArticle}">
<table style="border-style: none; width:100%;">
	<tr>
		<td class="EditTD">
		<div id="EditArea" class="EditArea">
		
		<div class="EditPreTool">
		<div class="EditTool">
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;b&gt;', '&lt;/b&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/bold.gif" alt="Pogrubienie tekstu" title="Pogrubienie tekstu" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;i&gt;', '&lt;/i&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/italic.gif" alt="Pogrubienie tekstu" title="Kursywa" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;u&gt;', '&lt;/u&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/underline.gif" alt="Pogrubienie tekstu" title="Podkreślenie" />
		</div>
		
			<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;strike&gt;', '&lt;/strike&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/strikethrough.gif" alt="Skreślenie" title="Skreślenie" />
		</div>
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;left&gt;', '&lt;/left&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/leftalign.gif" alt="Do lewej" title="Do lewej" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;center&gt;', '&lt;/center&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/centeralign.gif" alt="Wyśrodkowanie" title="Wyśrodkowanie" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;right&gt;', '&lt;/right&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/rightalign.gif" alt="Do prawej" title="Do prawej" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;justify&gt;', '&lt;/justify&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/fullalign.gif" alt="Wyjustuj" title="Wyjustuj" />
		</div>
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
		
		
		<div class="EditToolBg" style="border:1px solid #002D96;"> 

		<img src="{$UrlTheme}img/Editor/fontcolor.gif" alt="Kolor czcionki" title="Kolor czcionki" onclick="AddTag('EditArtPost', '&lt;span style=&quot;color: '+ColorPickerActual+';&quot;&gt;','&lt;/span&gt;'); return false;"/><img src="{$UrlTheme}img/Editor/arrow.gif" alt="Kolory" title="Kolory" onclick="WriteClass.ColorPicker(); return false;" id="ColorPicker" style="background:#000000;"/>
</div>
		
		<div class="EditToolFont" >
		<div style="margin-top: -2px; margin-left: 2px;">
		<span id="EditFontSize" title="Rozmiar czcionki" onclick="AddTag('EditArtPost', '&lt;span style=&quot;font-size: '+this.innerHTML+';&quot;&gt;','&lt;/span&gt;'); return false;">Normal</span> <img src="{$UrlTheme}img/Editor/arrow.gif" alt="Rozmiary" title="Rozmiary" onclick="showlayer('sm_2');;"/>
<div id="middlebar">
  <ul class="menu">
    <ul class="submenu" id="sm_2">
	
        <li><a href="#" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'TypeFontLayer'); showlayer('sm_2');  return false;"><span>Normal</span></a></li>
          
		  <li><span style="font-size: smaller;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">smaller</span></li>
<li><span style="font-size: xx-small;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">xx-small</span></li>
<li><span style="font-size: x-small;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">x-small</span></li>
<li><span style="font-size: small;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">small</span></li>
<li><span style="font-size: larger;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">larger</span></li>
<li><span style="font-size: large;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">large</span></li>
<li><span style="font-size: x-large;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">x-large</span></li>
<li><span style="font-size: xx-large;" onclick="ChangeObiekt('EditFontSize', this.innerHTML, 'SizeFontLayer'); showlayer('sm_2'); return false;">xx-large</span></li>
		 
		   
		   
		   
    </ul>
  </ul>
</div>
		</div>
		</div>
		

		
		<div class="EditToolFont" >
		


		<div style="margin-top: -1px; margin-left: 2px;">
		<span id="EditFontType" title="Rodzaj czcionki" onclick="showlayer('sm_1'); AddTag('EditArtPost', '&lt;font face=&quot;'+this.innerHTML+'&quot;&gt;', '&lt;/font&gt;');  return false; ">Normal</span> <img src="{$UrlTheme}img/Editor/arrow.gif" onclick="showlayer('sm_1'); return false;" alt="Rodzaje" title="Rodzaje" /> 
				<div id="middlebar">
  <ul class="menu">
    <ul class="submenu" id="sm_1">
        <li><a href="#" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1'); return false;"><span>Normal</span></a></li>
          <li><span style="font-family: Arial" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1'); return false;">Arial</span></li>
          <li><span style="font-family: Arial Black" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1'); return false;">Arial Black</span></li>
		  
		   <li><span style="font-family: Arial Black" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1'); return false;">Arial Black</span></li>
		   <li><span style="font-family: Century Gothic"onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Century Gothic</span></li>
<li><span style="font-family: Impact" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Impact</span></li>
<li><span style="font-family: Tahoma" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Tahoma</span></li>
<li><span style="font-family:  comic sans ms" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Comic Sans MS</span></li>
<li><span style="font-family: Times New Roman" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Times New Roman</span></li>
<li><span style="font-family: Trebuchet MS" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Trebuchet MS</span></li>
<li><span style="font-family: Verdana" onclick="ChangeObiekt('EditFontType', this.innerHTML, 'TypeFontLayer'); showlayer('sm_1');  return false;">Verdana</span></li>
		   
		   
		   
    </ul>
  </ul>
</div>
		</div>

		</div>
		
		
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;a href=&quot;http://adres&quot;&gt;Nazwa linku&lt;/a&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/insertlink.gif" alt="Wstaw link" title="Wstaw link" />
		</div>
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;img src=&quot;http://adres.obrazka&quot;/&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/insertimage.gif" alt="Wstaw obrazek" title="Wstaw obrazek" />
		</div>
		
		
		<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;hr /&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/hr.gif" alt="Wstaw linie" title="Wstaw linie" />
		</div>
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
				<div class="EditToolBg" onclick="AddTag('EditArtPost', '&lt;nohtml&gt;', '&lt;/nohtml&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/nohtml.gif" alt="Wstaw link" title="Wstaw tekst bez formatowania HTML" />
		</div>
		

		
		</div>
		
		
		
		
		<div class="EditPanel">
		
<div class="EditPreTool">
	<div class="EditTool">
	<div class="EditToolBg"  style="margin-top: 3px;" onclick="AddTag('EditArtPost', '&lt;php&gt;', '&lt;/php&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/php-icon.png"  style="width : 20px; height : 20px;" alt="Wstaw kod PHP" title="Wstaw kod PHP" />
		</div>
		
		<div class="EditToolBg"  style="margin-top: 3px;" onclick="AddTag('EditArtPost', '&lt;cpp&gt;', '&lt;/cpp&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/cpp.gif"  style="width : 20px; height : 20px;" alt="Wstaw kod C++" title="Wstaw kod C++" />
		</div>
		
		<div class="EditToolBg"  style="margin-top: 3px;" onclick="AddTag('EditArtPost', '&lt;delphi&gt;', '&lt;/delphi&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/delphi.gif"  style="width : 20px; height : 20px;" alt="Wstaw kod Delphi" title="Wstaw kod Delphi" />
		</div>
		
		<div class="EditToolBg"  style="margin-top: 3px;" onclick="AddTag('EditArtPost', '&lt;javascript&gt;', '&lt;/javascript&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/js.gif"  style="width : 20px; height : 20px;" alt="Wstaw kod JavaScript" title="Wstaw kod JavaScript" />
		</div>
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
		<div class="EditToolBg"  style="margin-top: 3px;" onclick="AddTag('EditArtPost', '&lt;youtube&gt;', '&lt;/youtube&gt;'); return false;">
		<img src="{$UrlTheme}img/Editor/youtube.png"  style="width : 20px; height : 20px;" alt="Wstaw kod JavaScript" title="Wstaw kod JavaScript" />
		</div>
		<img src="{$UrlTheme}img/Editor/seperator.gif" alt="Seperator" style="float : left; " />
		<div class="EditToolBg" style="margin: 3px;">
		<select class="StyleForm" size="1" name="LanguageOption" onchange="AddTag('EditArtPost', '&lt;code lang=\''+options[selectedIndex].value+'\'&gt;', '&lt;/code&gt;');">
			<option value="text" selected="selected">Zwykły tekst</option>
			<option value="c">C</option>
			<option value="cpp">C++</option>
			<option value="csharp">C#</option>
			<option value="css">CSS</option>
			<option value="delphi">Delphi</option>
			<option value="html4strict">HTML (4.0.1)</option>
			<option value="java">Java</option>
			<option value="javascript">Javascript</option>
			<option value="perl">Perl</option>
			<option value="php">PHP</option>
			<option value="vb">VisualBasic</option>
			<option value="vbnet">VB.NET</option>
			<option value="xml">XML</option>
			<option value="text">--------------------</option>
<option value="4cs">GADV 4CS</option> 
	<option value="abap">ABAP</option> 
	<option value="actionscript">ActionScript</option> 
	<option value="actionscript3">ActionScript 3</option> 
	<option value="ada">Ada</option> 
	<option value="apache">Apache configuration</option> 
	<option value="applescript">AppleScript</option> 
	<option value="apt_sources">Apt sources</option> 
	<option value="asm">ASM</option> 
	<option value="asp">ASP</option> 
	<option value="autoconf">Autoconf</option> 
	<option value="autohotkey">Autohotkey</option> 
	<option value="autoit">AutoIt</option> 
	<option value="avisynth">AviSynth</option> 
	<option value="awk">awk</option> 
	<option value="bash">Bash</option> 
	<option value="basic4gl">Basic4GL</option> 
	<option value="bf">Brainfuck</option> 
	<option value="bibtex">BibTeX</option> 
	<option value="blitzbasic">BlitzBasic</option> 
	<option value="bnf">bnf</option> 
	<option value="boo">Boo</option> 
	<option value="c">C</option> 
	<option value="c_mac">C (Mac)</option> 
	<option value="caddcl">CAD DCL</option> 
	<option value="cadlisp">CAD Lisp</option> 
	<option value="cfdg">CFDG</option> 
	<option value="cfm">ColdFusion</option> 
	<option value="chaiscript">ChaiScript</option> 
	<option value="cil">CIL</option> 
	<option value="clojure">Clojure</option> 
	<option value="cmake">CMake</option> 
	<option value="cobol">COBOL</option> 
	<option value="cpp">C++</option> 
	<option value="cpp-qt">C++ (QT)</option> 
	<option value="csharp">C#</option> 
	<option value="css">CSS</option> 
	<option value="cuesheet">Cuesheet</option> 
	<option value="d">D</option> 
	<option value="dcs">DCS</option> 
	<option value="delphi">Delphi</option> 
	<option value="diff">Diff</option> 
	<option value="div">DIV</option> 
	<option value="dos">DOS</option> 
	<option value="dot">dot</option> 
	<option value="ecmascript">ECMAScript</option> 
	<option value="eiffel">Eiffel</option> 
	<option value="email">eMail (mbox)</option> 
	<option value="erlang">Erlang</option> 
	<option value="fo">FO (abas-ERP)</option> 
	<option value="fortran">Fortran</option> 
	<option value="freebasic">FreeBasic</option> 
	<option value="fsharp">F#</option> 
	<option value="gambas">GAMBAS</option> 
	<option value="gdb">GDB</option> 
	<option value="genero">genero</option> 
	<option value="genie">Genie</option> 
	<option value="gettext">GNU Gettext</option> 
	<option value="glsl">glSlang</option> 
	<option value="gml">GML</option> 
	<option value="gnuplot">Gnuplot</option> 
	<option value="groovy">Groovy</option> 
	<option value="gwbasic">GwBasic</option> 
	<option value="haskell">Haskell</option> 
	<option value="hicest">HicEst</option> 
	<option value="hq9plus">HQ9+</option> 
	<option value="html4strict">HTML</option> 
	<option value="icon">Icon</option> 
	<option value="idl">Uno Idl</option> 
	<option value="ini">INI</option> 
	<option value="inno">Inno</option> 
	<option value="intercal">INTERCAL</option> 
	<option value="io">Io</option> 
	<option value="j">J</option> 
	<option value="java">Java</option> 
	<option value="java5">Java(TM) 2 Platform Standard Edition 5.0</option> 
	<option value="javascript">Javascript</option> 
	<option value="jquery">jQuery</option> 
	<option value="kixtart">KiXtart</option> 
	<option value="klonec">KLone C</option> 
	<option value="klonecpp">KLone C++</option> 
	<option value="latex">LaTeX</option> 
	<option value="lisp">Lisp</option> 
	<option value="locobasic">Locomotive Basic</option> 
	<option value="logtalk">Logtalk</option> 
	<option value="lolcode">LOLcode</option> 
	<option value="lotusformulas">Lotus Notes @Formulas</option> 
	<option value="lotusscript">LotusScript</option> 
	<option value="lscript">LScript</option> 
	<option value="lsl2">LSL2</option> 
	<option value="lua">Lua</option> 
	<option value="m68k">Motorola 68000 Assembler</option> 
	<option value="magiksf">MagikSF</option> 
	<option value="make">GNU make</option> 
	<option value="mapbasic">MapBasic</option> 
	<option value="matlab">Matlab M</option> 
	<option value="mirc">mIRC Scripting</option> 
	<option value="mmix">MMIX</option> 
	<option value="modula2">Modula-2</option> 
	<option value="modula3">Modula-3</option> 
	<option value="mpasm">Microchip Assembler</option> 
	<option value="mxml">MXML</option> 
	<option value="mysql">MySQL</option> 
	<option value="newlisp">newlisp</option> 
	<option value="nsis">NSIS</option> 
	<option value="oberon2">Oberon-2</option> 
	<option value="objc">Objective-C</option> 
	<option value="ocaml">OCaml</option> 
	<option value="ocaml-brief" class="sublang">&nbsp;&nbsp;OCaml (brief)</option> 
	<option value="oobas">OpenOffice.org Basic</option> 
	<option value="oracle11">Oracle 11 SQL</option> 
	<option value="oracle8">Oracle 8 SQL</option> 
	<option value="oxygene">Oxygene (Delphi Prism)</option> 
	<option value="oz">OZ</option> 
	<option value="pascal">Pascal</option> 
	<option value="pcre">PCRE</option> 
	<option value="per">per</option> 
	<option value="perl">Perl</option> 
	<option value="perl6">Perl 6</option> 
	<option value="pf">OpenBSD Packet Filter</option> 
	<option value="php" selected="selected">PHP</option> 
	<option value="php-brief" class="sublang">&nbsp;&nbsp;PHP (brief)</option> 
	<option value="pic16">PIC16</option> 
	<option value="pike">Pike</option> 
	<option value="pixelbender">Pixel Bender 1.0</option> 
	<option value="plsql">PL/SQL</option> 
	<option value="postgresql">PostgreSQL</option> 
	<option value="povray">POVRAY</option> 
	<option value="powerbuilder">PowerBuilder</option> 
	<option value="powershell">PowerShell</option> 
	<option value="progress">Progress</option> 
	<option value="prolog">Prolog</option> 
	<option value="properties">PROPERTIES</option> 
	<option value="providex">ProvideX</option> 
	<option value="purebasic">PureBasic</option> 
	<option value="python">Python</option> 
	<option value="q">q/kdb+</option> 
	<option value="qbasic">QBasic/QuickBASIC</option> 
	<option value="rails">Rails</option> 
	<option value="rebol">REBOL</option> 
	<option value="reg">Microsoft Registry</option> 
	<option value="robots">robots.txt</option> 
	<option value="rpmspec">RPM Specification File</option> 
	<option value="rsplus">R / S+</option> 
	<option value="ruby">Ruby</option> 
	<option value="sas">SAS</option> 
	<option value="scala">Scala</option> 
	<option value="scheme">Scheme</option> 
	<option value="scilab">SciLab</option> 
	<option value="sdlbasic">sdlBasic</option> 
	<option value="smalltalk">Smalltalk</option> 
	<option value="smarty">Smarty</option> 
	<option value="sql">SQL</option> 
	<option value="systemverilog">SystemVerilog</option> 
	<option value="tcl">TCL</option> 
	<option value="teraterm">Tera Term Macro</option> 
	<option value="text">Text</option> 
	<option value="thinbasic">thinBasic</option> 
	<option value="tsql">T-SQL</option> 
	<option value="typoscript">TypoScript</option> 
	<option value="unicon">Unicon (Unified Extended Dialect of Icon)</option> 
	<option value="vala">Vala</option> 
	<option value="vb">Visual Basic</option> 
	<option value="vbnet">vb.net</option> 
	<option value="verilog">Verilog</option> 
	<option value="vhdl">VHDL</option> 
	<option value="vim">Vim Script</option> 
	<option value="visualfoxpro">Visual Fox Pro</option> 
	<option value="visualprolog">Visual Prolog</option> 
	<option value="whitespace">Whitespace</option> 
	<option value="whois">Whois (RPSL format)</option> 
	<option value="winbatch">Winbatch</option> 
	<option value="xbasic">XBasic</option> 
	<option value="xml">XML</option> 
	<option value="xorg_conf">Xorg configuration</option> 
	<option value="xpp">X++</option> 
	<option value="z80">ZiLOG Z80 Assembler</option> 
			</select>
		</div>
		</div>	
</div>
 </div>
		</div>
		</div>
		<textarea class="EditArt xv-edit-content" id="EditArtPost" name="EditArtPost"  >{$ContextEdit}</textarea></td>
	</tr>
	<tr>
		<td height="20" style="vertical-align:top;" class="StyleForm" colspan="2"><b>{$language.AdditionalSigns}</b>: 
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">?</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">?</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">±</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">?</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">÷</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">×</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">·</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">~</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">»</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">ˇ</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">›</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">^</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">‹</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">•</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">‰</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">§</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">†</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">®</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">©</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">€</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">c</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">$</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">?</a>
		<a href="#" onclick="AddTag('EditArtPost', this.innerHTML, ''); return false;">!</a>
		</td>
		
		<tr>
		<td height="20" style="vertical-align:top;" class="StyleForm" colspan="2">

	{if $WriteUrlArticle}
		 <b>{$language.WriteURL}</b>: <input type="text" id="UrlArticleID" name="xv-path" class="StyleForm" value="{$smarty.get.url|escape:'html'|default:$UrlWrite}" style="width: 200px;" /><br /><br />
	{/if}
	{if $WriteDescription}
		 <b><label for="DescriptionID">{$language.DescriptionOfChanges}</label></b>: <input type="text" id="DescriptionID" name="xv-description" class="StyleForm" style="width: 200px;" /><br /><br />
		{if "Amendments"|perm}<b><label for="amendmentID">{$language.Amendment}</label></b>: <input type="checkbox" id="amendmentID" name="amendment" class="icheckbox" value="true" /><br /><br />{/if}
		{/if}
		<b>{$language.Title}</b>: <input type="text" id="TitleID" name="arttitle" class="StyleForm" style="width: 200px;" value="{$TitleArt}" /><br /><br />
		
			<div class="xv-comment-spambot">
				{$language.RewriteKey} : <span class="xv-comment-spambot-key">{$JSVars.SIDUser|substr:0:5}</span> : <input type="text" name="xv-captcha" value="" class="xv-comment-spambot-field" />
			</div>
		<!--<input type="checkbox" name="AceptRules" id ="AceptRulesID" value="on" /> {$language.QuestionRules} <br />-->
<input type="button" name="btn1" id="btn1id" id="SendArticle" onclick="ValidateArt(); return false;" class="StyleForm" value="{$language.Send}" /> <input type="button" name="PreView" onclick="$('#PreviewArticle').show('slow'); sendPost('PreviewArticle', 'ArticleEditForm', '{$UrlScript}Write/?PreView'); window.location.hash='#fp_article';" class="StyleForm" value="Podgląd" />
		
		</td>
		</tr>
	</tr>
</table>
</form>