<?php
/**
 *  Wikipedia Table style diff formatter.
 * @author Foxmask (for Jelix)
 * @copyright 2008 Foxmask
 */
require_once(dirname(__FILE__).'/difflib.php');

class HtmlTableDiffFormatter extends DiffFormatter
{
var $ActualLine = 0;
  function __construct($version1,$version2,$type) {
    $this->type     = $type;
    $this->version1 = $version1;
    $this->version2 = $version2;
    $this->leading_context_lines = 2;
    $this->trailing_context_lines = 2;
  }

  function _pre($text){
    $text = htmlspecialchars($text);
    $text = str_replace('  ',' &nbsp;',$text);
    return $text;
  }

  function _block_header( $xbeg, $xlen, $ybeg, $ylen ) {
    global $lang;
    if ($this->type == 'sidebyside') {
        $r = '<table class="sidebyside">'.chr(13);
    }
    else {
        $r = '<table class="inline">'.chr(13).
        '<colgroup>'.chr(13).'<col class="lineno" />'.chr(13).'<col class="lineno" />'.chr(13).'<col class="content" />'.chr(13).'</colgroup>'.chr(13);
        if($this->version1 != '' || $this->version2 != '')
            $r .= '<thead><tr><th>'.$this->version1.":</th>".chr(13) .
            '<th>'.$this->version2.":</th><th>&nbsp;</th></tr></thead>".chr(13);
    }
    return $r;
  }

  function _start_block( $header ) {
    print( $header );
  }

  function _end_block() {
    echo '</table>'.chr(13);
  }

  function _lines( $lines, $prefix=' ', $color="white" ) {
  }

  function addedLine( $line,$class ) {
    $line = str_replace('  ','&nbsp; ',$line);
    if ($this->type == 'sidebyside')
        return '<td></td>'.chr(13).'<td class="'.$class.'">'.chr(13) .$line.chr(13).'</td>';
    else
        return '<th>&nbsp;</th><th>&nbsp;</th><td class="'.$class.'">' .$line.'</td>';
  }

  function deletedLine( $line, $class ) {
    $line = str_replace('  ','&nbsp; ',$line);
    if ($this->type == 'sidebyside')
        return '<td>-</td><td class="'.$class.'">' .$line.'</td>'.chr(13);
    else
        return '<th>&nbsp;</th><th>&nbsp;</th>'.chr(13).'<td class="'.$class.'">' .$line.'</td>'.chr(13);
  }

  function emptyLine() {
    //$line = str_replace('  ','&nbsp; ',$line);
    if ($this->type == 'sidebyside')
        return '<td colspan="2">&nbsp;</td>'.chr(13);
    else
        return '<th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td>'.chr(13);
  }

  function contextLine( $line , $class) {
    $line = str_replace('  ','&nbsp; ',$line);
    if ($this->type == 'sidebyside')
        return '<td></td><td class="'.$class.'">'.$line.'</td>';
    else
        return '<th>&nbsp;</th><th>&nbsp;</th><td class="'.$class.'">'.$line.'</td>';
  }

  function _added($lines) {
    foreach ($lines as $key=>$line) {
	$this->ActualLine = $key;
      if ($this->type == 'sidebyside')
        print( '<tbody class="add"><tr>' . $this->emptyLine() .
            $this->addedLine( $line,'r' ) . "</tr></tbody>\n" );
      else
        print( '<tbody class="add"><tr>'. $this->addedLine( $line,'r' ) . "</tr></tbody>\n" );
    }
  }

  function _deleted($lines) {
    foreach ($lines as $key=>$line) {
	$this->ActualLine = $key;
        if ($this->type == 'sidebyside')
            print( '<tbody class="rem"><tr>' . $this->deletedLine( $line,'orginal' ) . $this->emptyLine() . "</tr></tbody>\n" );
        else
            print( '<tbody class="rem"><tr>'. $this->deletedLine( $line,'orginal' ) ."</tr></tbody>\n" );

    }
  }

  function _context( $lines ) {
    foreach ($lines as $key=>$line) {
	$this->ActualLine = $key;
        if ($this->type == 'sidebyside')
            print( '<tbody><tr>' . $this->contextLine( $line, "orginal" ) .
                    $this->contextLine( $line,"r" ) . "</tr></tbody>\n" );
        else
            print( '<tbody><tr>' . $this->contextLine( $line, "orginal" ) ."</tr></tbody>\n" );

    }
  }

  function _changed( $orig, $closing ) {
    $diff = new WordLevelDiff( $orig, $closing );
    $del = $diff->orig();
    $add = $diff->_final();

    while ( $line = array_shift( $del ) ) {
        $aline = array_shift( $add );
        if ($this->type == 'sidebyside')
            print( '<tbody class="mod">'.chr(13).'<tr>' . $this->deletedLine( $line ,'orginal') . $this->addedLine( $aline ,'r') . "</tr></tbody>\n" );
        else
            print( '<tbody class="mod">'.chr(13).'<tr>' . $this->deletedLine( $line ,'orginal') . "</tr></tbody>\n" );
    }
    $this->_added( $add ); // If any leftovers
  }
}
?>