<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xv_api_texts {
	/**
	 * Get stats for user
	 * Usage : get_user_stats("user")
	 * 
	 * @param string $parent
	 * @return array
	 */	
	function get_categories($parent){
		global $XVwebEngine, $URLS;
			include_once(ROOT_DIR.'plugins/texts/libs/texts.class.php');
			$xv_texts = &$XVwebEngine->load_class("xv_texts");
		return xvp()->get_categories($xv_texts, $parent);
	}
		
	/**
	 * Convert title to URL
	 * 
	 * @param string $parent
	 * @return string
	 */	
	function convert_title_to_url($title){
		global $XVwebEngine;
			include_once(ROOT_DIR.'plugins/texts/libs/texts.class.php');
			$xv_texts = &$XVwebEngine->load_class("xv_texts");
		return xvp()->convert_title_to_url($xv_texts, $title);
	}
	
    public function __wakeup(){
       
    }

	
}
