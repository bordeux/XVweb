  <!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
<div id="ContentDiv">
	{if $smarty.get.msg}
		<div class="{if $smarty.get.success}success{else}failed{/if}">
		{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
			{$smarty.get.msg|escape:"html"}
			{if $smarty.get.list}
			<ul>
				{foreach from=$smarty.get.list item=Value name=minimap}
				<li>{$Value|escape:"html"}</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	{/if}
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
		{$Value.Name}
		{else}
		<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div class="xv-text-wrapper">
<!-- TEXT -->
<fieldset>
<legend>PastCode</legend>
<form  method="post" action="http://titek.pl/xvweb/Write/?save=192">

<textarea  name="PastCodeText" id="PastCodeTextID"></textarea>
<fieldset>
<legend>Opcje</legend>
Rodzaj kodu: <select class="StyleForm" size="1" name="LanguageOption" onchange="AddTag('EditArtPost', '&lt;code='+options[selectedIndex].value+'&gt;', '&lt;/code&gt;');">
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
			<option value="abap">ABAP</option>
				<option value="actionscript">ActionScript</option>

				<option value="actionscript-french" style="font-size: 80%; font-style: oblique;">&nbsp;&nbsp;ActionScript (French Doc Links)</option>
				<option value="ada">Ada</option>
				<option value="apache">Apache Log File</option>
				<option value="applescript">AppleScript</option>
				<option value="asm">ASM (NASM based)</option>
				<option value="asp">ASP</option>

				<option value="autoit">AutoIT</option>
				<option value="bash">Bash</option>
				<option value="blitzbasic">BlitzBasic</option>
				<option value="bnf">Backus-Naur form</option>
				<option value="c">C</option>
				<option value="c_mac">C for Macs</option>

				<option value="caddcl">CAD DCL</option>
				<option value="cadlisp">CAD Lisp</option>
				<option value="cfdg">CFDG</option>
				<option value="cfm">ColdFusion</option>
				<option value="cpp">C++</option>
				<option value="cpp-qt" style="font-size: 80%; font-style: oblique;">&nbsp;&nbsp;C++/QT</option>

				<option value="csharp">C#</option>
				<option value="css">CSS</option>
				<option value="d">D</option>
				<option value="delphi">Delphi</option>
				<option value="diff">Diff</option>
				<option value="div">DIV</option>

				<option value="dos">DOS</option>
				<option value="dot">GraphViz</option>
				<option value="eiffel">Eiffel</option>
				<option value="fortran">Fortran</option>
				<option value="freebasic">FreeBasic</option>
				<option value="genero">Genero (4GL)</option>

				<option value="gml">GML</option>
				<option value="groovy">Groovy</option>
				<option value="haskell">Haskell</option>
				<option value="html4strict">HTML (4.0.1)</option>
				<option value="idl">Uno IDL</option>
				<option value="inno">Inno</option>

				<option value="io">IO</option>
				<option value="java">Java</option>
				<option value="java5" style="font-size: 80%; font-style: oblique;">&nbsp;&nbsp;Java 5</option>
				<option value="javascript">Javascript</option>
				<option value="latex">LaTeX</option>
				<option value="lisp">Lisp</option>

				<option value="lua">Lua</option>
				<option value="matlab">Matlab</option>
				<option value="mirc">mIRC</option>
				<option value="mpasm">MPASM</option>
				<option value="mysql">MySQL</option>
				<option value="nsis">NullSoft Installer</option>

				<option value="objc">Objective C</option>
				<option value="ocaml">OCaml</option>
				<option value="ocaml-brief" style="font-size: 80%; font-style: oblique;">&nbsp;&nbsp;OCaml (Brief)</option>
				<option value="oobas">Openoffice.org BASIC</option>
				<option value="oracle8">Oracle 8</option>
				<option value="pascal">Pascal</option>

				<option value="per">Per (4GL)</option>
				<option value="perl">Perl</option>
				<option value="php">PHP</option>
				<option value="php-brief" style="font-size: 80%; font-style: oblique;">&nbsp;&nbsp;PHP (Brief version)</option>
				<option value="plsql">PL/SQL</option>
				<option value="python">Python</option>

				<option value="qbasic">QBasic/QuickBASIC</option>
				<option value="rails">Rails</option>
				<option value="reg">Windows Registry</option>
				<option value="robots">robots.txt</option>
				<option value="ruby">Ruby</option>
				<option value="sas">SAS</option>

				<option value="scheme">Scheme</option>
				<option value="sdlbasic">SDLBasic</option>
				<option value="smalltalk">Smalltalk</option>
				<option value="smarty">Smarty</option>
				<option value="sql">SQL</option>
				<option value="tcl">TCL</option>

				<option value="text">Zwykły tekst</option>
				<option value="thinbasic">thinBasic</option>
				<option value="tsql">T-SQL</option>
				<option value="vb">VisualBasic</option>
				<option value="vbnet">VB.NET</option>
				<option value="vhdl">VHDL</option>

				<option value="visualfoxpro">VisualFoxPro</option>
				<option value="winbatch">Winbatch</option>
				<option value="xml">XML</option>
				<option value="xpp">X++</option>
				<option value="z80">Z80 Assembler</option> 
			</select>
</fieldset>
</form>
</fieldset>

<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->