<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Media management section for base CMS
 *
 * @author		Adam Jacox
 * @version		1.0
 * 
 */

class Media extends CI_Controller {

	private $site_settings;

	function __construct() {

		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->library('flash_msg');

		$this->load->model('admin/media_model');

		// get site settings
		$this->load->model('admin/admin_model');
		$this->site_settings = $this->admin_model->get_all_site_settings();

		// ensure admin is logged in 
		$this->tank_auth->user_not_admin_redirect();

	}


	/**
	 * display kcfinder file manager
	 *
	 * @param  
	 * @return 
	 */
	
	function index() {
		
		$view_data = array(
				'page' => 'admin/media/admin_media_view',
				'head_data' => array('title' => 'Media Manager | CMS', 'message' => $this->flash_msg->get_message()),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title,),
				'page_data' => array(),
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}
	




} // end class		