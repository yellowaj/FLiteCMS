<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extend CI security class
 *
 * description
 *
 * @author	Adam Jacox
 */

class MY_Security extends CI_Security {


	/**
	 * clean string 	
	 *
	 * @param str
	 * @return str
	 */
	
	function var_clean($str, $strip=FALSE) {

		if($strip) { 
			$str = strip_tags($str); 
		}
		return  htmlentities($str, ENT_QUOTES, "UTF-8");

	}	
	

} // end class