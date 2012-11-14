<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Front end pages controller
 *
 * for all pages displayed on the front end
 *
 * @author	Adam Jacox
 */

class Pages_front extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->helper(array('url', 'form', 'security'));
		$this->load->model('pages_front_model');

	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * index - gets and routes each url to page from pages table in db
	 *
	 * @param  
	 * @return 
	 */
	
	function index($url='home') {
	
		// find the url in the db
		$page_data = $this->pages_front_model->get_page_by_url($url);

		if($page_data && (int)$page_data->publish === 1) {

			$view_data = array('page_data'=> array('page_data' => $page_data));

			// get any custom fields
			$view_data['page_data']['custom_fields'] = $this->pages_front_model->get_custom_fields_by_page_id($page_data->id);

			// check what type of page it is then get that type of content
			// contact page type
			if($page_data->page_type == 'contact') {

				// check if contact form was submitted and passes validation
				$this->form_validation->set_rules('', '', 'required|xss_clean|min_length[3]|max_length[255]|trim');
				
				$view_data['page'] = 'front/pages/contact_page_view';
				$view_data['page_data']['page_type_data'] = $this->pages_front_model->get_contact_form_items_by_page_id($page_data->id);

			// testimonial page type
			} elseif($page_data->page_type == 'testimonial') {

				$view_data['page'] = 'front/pages/testimonial_page_view';
				$view_data['page_data']['page_type_data'] = $this->pages_front_model->get_testimonials_by_page_id($page_data->id);
			
			// standard page type
			} else {

				if($url == 'home') {
					$view_data['page'] = 'front/pages/index_home_page_view';
				} else {
					$view_data['page'] = 'front/pages/standard_page_view';
				}	
				$view_data['page_data']['page_type_data'] = NULL;
			}

			// prep page title 
			$title = $page_data->title . ' | test';

			$view_data['head_data'] = array('title' => $title, 'meta_desc' => $page_data->description);
			$view_data['header_active'] = TRUE;
			$view_data['header_data'] = array();
			$view_data['footer_active'] = TRUE;

			$this->load->view('front/general/template', $view_data);

		} else {
			// url not found - return 404
			show_404(base_url() . $url);
		}

	}




} // end class