<?php
/**
* Smarty inline prefilter plugin
*
* File: prefilter.inline.php<br>
* Type: prefilter<br>
* Name: inline<br>
* Date: Dec 5, 2003<br>
* Purpose: resolve inlcuded templates at compile-time and include them
* Use: <code>$smarty->load_filter('pre','script_name');</code>
* from application.
* @author Messju Mohr <messju@lammfellpuschen.de>
* @version 0.3
* @param string (the template's sourcecode)
* @param Smarty_Compiler (the compiler)
*/


/*
* - tags like {inline file="foo.php"} are resolved
* - {inline file="foo.tpl" assign="foo"} assigns the contents
* instead of displaying them
* - {inline file="foo.tpl" var1=foo var2=bar} defines custom template
* variables to be used in the included tpl.
*/

function smarty_prefilter_inline($source, &$compiler) {
	$ld = $compiler->left_delimiter;
	$rd = $compiler->right_delimiter;

	if (empty($compiler->_inline_depth)) {
		$compiler->_inline_depth = 0;
		/* make compiler visbile to inline_callback-function */
		$GLOBALS['__compiler'] =& $compiler;
	}

	$compiler->_inline_depth++;
	$source = preg_replace_callback('!' . preg_quote($ld, '!') . 'inline(.*)'
	. preg_quote($rd, '!') . '!Us'
	, 'inline_callback', $source);

	if (--$compiler->_inline_depth==0) {
		/* clean up */
		unset($GLOBALS['__compiler']);
	}

	return $source;
}


function inline_callback($match) {
	global $__compiler;

	$ld = $__compiler->left_delimiter;
	$rd = $__compiler->right_delimiter;
	$source_content = '';

	/* get attributes to {inline...} */
	$_attrs = $__compiler->_parse_attrs($match[1]);

	/* "file" */
	if (!isset($_attrs['file'])) {
		$this->syntax_error('[inline] missing file-parameter');
		return false;
	}
	$resource_name = $__compiler->_dequote($_attrs['file']);
	unset($_attrs['file']);


	/* "assign" */
	if (isset($_attrs['assign'])) {
		$assign = $_attrs['assign'];
		unset($_attrs['assign']);

	} else {
		$assign = null;
	}

	/* handle all other attributes as custom-vars */
	if (!empty($_attrs)) {
		$source_content .= $ld.'php'.$rd;
		$source_content .= '$this->assign(array(';
		$_sep = '';
		foreach ($_attrs as $_name=>$_value) {
			$source_content .= "$_sep'$_name'=>$_value";
			$_sep = ',';
		}
		$source_content .= ')); '.$ld.'/php'.$rd;
	}

	/* read tpl-file */
	$params = array('resource_name'=>$resource_name);
	if ($__compiler->_fetch_resource_info($params)) {
		/* recursion */
		$source_content .= smarty_prefilter_inline($params['source_content'], $__compiler);
		/* handle assign */
		if (isset($assign)) {
			$source_content = $ld.'php'.$rd . 'ob_start();' . $ld.'/php'.$rd
			. $source_content
			. $ld.'php'.$rd . '$this->assign(' . $assign . ', ob_get_contents()); ob_end_clean();' . $ld.'/php'.$rd;
		}
	}

	/* return inline-replacement of tpl-file */
	return $source_content;

}


?> 