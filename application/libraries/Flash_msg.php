<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Message 
 *
 * Message library for Code Igniter.
 *
 * @package		Message
 * @author		Adam Jacox
 * @version		1.0
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */

class Flash_msg {

	function __construct() {

		$this->ci =& get_instance();

		$this->ci->load->library('session');
	}


	/**
	 * create new flashdata message
	 *
	 * @param  string
	 * @return void
	 */
	
	function set_message($msg, $name='message') {
		
		$this->ci->session->set_flashdata($name, $msg);
	}


	/**
	 * get flashdata messages 
	 *
	 * @param  string
	 * @return string
	 */
	
	function get_message($msg='message') {
		
		return $this->ci->session->flashdata($msg);
	}


} // end class	