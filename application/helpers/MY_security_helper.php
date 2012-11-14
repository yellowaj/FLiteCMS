<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	/**
	 * clean output variables - for xss prevention
	 *
	 * @param  
	 * @return 
	 */
	
	function clean_var($str, $strip=FALSE) {

		if($strip) { 
			$str = strip_tags($str); 
		}
		return  htmlentities($str, ENT_QUOTES, "UTF-8");

	}