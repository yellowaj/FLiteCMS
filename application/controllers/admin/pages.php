<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages section for base CMS
 *
 * @author		Adam Jacox
 * @version		1.0
 * 
 */

class Pages extends CI_Controller {

	private $site_settings;

	function __construct() {

		parent::__construct();

		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library('tank_auth');
		$this->load->library('flash_msg');

		// get site settings
		$this->load->model('admin/admin_model');
		$this->site_settings = $this->admin_model->get_all_site_settings();

		// form validation
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		$this->load->model('admin/pages_model');

		// ensure admin is logged in 
		$this->tank_auth->user_not_admin_redirect();

	}


	/**
	 * Pages dashboard
	 *
	 * @param  none
	 * @return void
	 */
	
	function index() {

		// prep pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/pages/index/';
		$config['total_rows'] = $this->pages_model->count_all_pages();
		$config['per_page'] = 15;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;

		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();

		// get all pages data
		$pages_obj = $this->pages_model->get_all_pages($config['per_page'], (int)$this->uri->segment(4));

		$view_data = array(
				'page' => 'admin/pages/admin_index_page_view',
				'head_data' => array('title' => 'Pages | CMS', 'message' => $this->flash_msg->get_message()),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title),
				'page_data' => array('pages' => $pages_obj, 'pagination' => $pagination),
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $view_data);

	}


	/**
	 * Add new page 
	 *
	 * @param  none
	 * @return void
	 */
	
	function create() {

		$this->form_validation->set_rules('page_type', 'Page Type', 'trim|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('title', 'Page Title', 'trim|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('url', 'Page URL', 'trim|xss|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('description', 'Page description', 'trim|xss|max_length[255]');

		if($this->form_validation->run()) {    //passed validation

			$create_arr = array(
					'page_type'				=> $this->input->post('page_type'),
					'title' 				=> $this->input->post('title'),
					'url' 					=> $this->pages_model->prep_page_url($this->input->post('url')),
					'description' 			=> $this->input->post('description'),
				);	

			// check if standard page with content has been posted - then add to create array
			if($this->input->post('content')) { 
				$create_arr['content'] = $this->input->post('content');
			}

			// check if contact page with emails posted - then add to create array
			if($this->input->post('receive_email')) {
				$create_arr['receive_email'] = implode('|', $this->input->post('receive_email'));
			}
			
			// check if saved
			if($this->input->post('save')) {	
				$create_arr['publish'] = 0;
				$save_msg['error'] = 'Error saving page';
				$save_msg['success'] = 'Page added successfully';
			
			} 
			// check in published
			elseif($this->input->post('publish')) {
				$create_arr['publish'] = 1;
				$save_msg['error'] = 'Error publishing page';
				$save_msg['success'] = 'Page published successfully';
			}	

			if($page_id = $this->pages_model->create_page($create_arr)) {

				// add custom fields to db
				$field_key = $this->input->post('field_key');
				if($field_key && !empty($field_key[(count($field_key)-1)])) {

					$this->pages_model->add_custom_fields($field_key, $this->input->post('field_value'), $page_id);
				}	

				// check if contact form items have been posted - then prep and add to db
				if($this->input->post('form_item')) {

					if(!$this->pages_model->add_contact_form_item($this->input->post('form_item'), $page_id, TRUE)) {
						$message = $save_msg['error'];
					} 
					$message = $save_msg['success'];
				} else {
					$message = $save_msg['success'];
				}

			} else {
				$message = $save_msg['error'];
			}

			$this->flash_msg->set_message($message);
			redirect(base_url() . 'admin/pages/edit/' . $page_id);

		} // end form validation


		// get website name
		$this->config->load('cms');
		$site_url = 'www.' . $this->config->item('site_url');

		// set script tags for <head>
		$head_scripts = array();

		// set editor script for footer
		$foot_scripts = array('<script src="'.base_url().'resources/js/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>');
		
		$view_data = array(
				'page' => 'admin/pages/admin_add_page_view',
				'head_data' => array('title' => 'Create New Page | CMS', 'head_scripts' => $head_scripts),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => array('site_url' => $site_url),
				'footer_active' => TRUE,
				'footer_data' => array('foot_scripts' => $foot_scripts)
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}


	/**
	 * edit page
	 *
	 * @param  void
	 * @return void
	 */
	
	function edit() {
		
		if($this->uri->segment(4)) {

			// get page id from uri
			$page_id = (int) $this->uri->segment(4);

			// get page data from db
			if($page_obj = $this->pages_model->get_page_by_id($page_id)) {   // page data found

				// perform form validation
				$this->form_validation->set_rules('title', 'Page title', 'trim|xss|required|min_length[3]|max_length[255]');
				$this->form_validation->set_rules('url', 'Page URL', 'trim|xss|required|min_length[3]|max_length[255]');
				$this->form_validation->set_rules('description', 'Page description', 'trim|xss|max_length[255]');

				if($this->form_validation->run()) {    //passed validation

					$update_arr = array(
							'title' 		=> $this->input->post('title'),
							'url' 			=> $this->pages_model->prep_page_url($this->input->post('url')),
							'description' 	=> $this->input->post('description')
						);	

					// check if standard page with content has been posted - then add to create array
					// otherwise set as NULL
					if($this->input->post('content')) { 
						$update_arr['content'] = $this->input->post('content'); 
					} else {
						$update_arr['content'] = NULL;
					}

					// check if contact page with emails posted - then add to create array
					if($this->input->post('receive_email')) {
						$update_arr['receive_email'] = implode(',', $this->input->post('receive_email'));
					}

					/* contact form items */
					// test if contact form items has been posted - then prep and add to db
					if($this->input->post('form_item')) {

						// delete all current items
						$this->pages_model->delete_form_items_by_page_id($page_id);
						
						// add new items to db
						$this->pages_model->add_contact_form_item($this->input->post('form_item'), $page_id, TRUE);

					} else {
						// no form items posted = all form items were deleted by user on front end
						// delete all current items
						$this->pages_model->delete_form_items_by_page_id($page_id);
					}

					/* custom fields */
					// test if custom fields have been posted - then prep and add to db
					$field_key = $this->input->post('field_key');
					if($field_key && !empty($field_key[(count($field_key)-1)])) {

						// delete all current items
						$this->pages_model->delete_fields_by_page_id($page_id);
						
						// add new items to db
						$this->pages_model->add_custom_fields($this->input->post('field_key'), $this->input->post('field_value'), $page_id);

					} else {
						// no fields posted = all fields were deleted by user on front end
						// delete all current fields by page id
						$this->pages_model->delete_fields_by_page_id($page_id);
					}

					// check if saved
					if($this->input->post('save')) {	
						$update_arr['publish'] = 0;
						$message['success'] = 'Page saved successfully';
						$message['error'] = 'Error saving page';
					}

					// check if published
					elseif($this->input->post('publish')) {
						$update_arr['publish'] = 1;
						$message['success'] = 'Page published successfully';
						$message['error'] = 'Error publishing page';	
					}

					// check if unpublished
					elseif($this->input->post('unpublish')) {
						$update_arr['publish'] = 0;
						$message['success'] = 'Page unpublished successfully';
						$message['error'] = 'Error unpublishing page';
					}

					// check if unpublished
					elseif($this->input->post('update')) {
						$update_arr['publish'] = 1;
						$message['success'] = 'Page updated successfully';
						$message['error'] = 'Error updating page';
					}

					// check if preview
					elseif($this->input->post('preview')) {
						if($this->pages_model->update_page($update_arr, $page_id)) {
							$this->flash_msg->set_message('Page preview');
							redirect(base_url() . 'admin/pages/preview/' . $page_id);
						} else {
							$message['error'] = 'Error previewing page';
						}
					}

					// check if testimonial added (no save/publish/preview/update was submitted)
					if($this->input->post('testimonial_submit')) {

						$testimonial_arr = array(
								'page_id'		=> $page_id,
								'name' 			=> $this->input->post('testimonial_name'),
								'location' 		=> $this->input->post('testimonial_location'),
								'testimonial'	=> $this->input->post('testimonial')
							);

						if($this->pages_model->add_testimonial($testimonial_arr)) {
							$this->flash_msg->set_message('Testimonial added successfully');
						} else {
							$this->flash_msg->set_message('Error adding testimonial');
						}
						redirect(base_url() . 'admin/pages/edit/' . $page_id); exit();
					}


					// finally - perform update, set flash message and redirect
					if($this->pages_model->update_page($update_arr, $page_id)) {
						$flash_msg = $message['success'];
					} else {
						$flash_msg = $message['error'];
					}

					$this->flash_msg->set_message($flash_msg);
					redirect(base_url() . 'admin/pages/edit/' . $page_id);

				} // end form validation


				// get website name
				$this->config->load('cms');
				$site_url = 'www.' . $this->config->item('site_url');

				// get all testimonials for page id
				$testimonials = $this->pages_model->get_testimonials_by_id($page_id);

				// get all contact form items
				$form_items = $this->pages_model->get_form_items_by_id($page_id);

				// get all custom page fields
				$fields = $this->pages_model->get_fields_by_page_id($page_id);

				// prep receive emails
				$emails = explode('|', $page_obj->receive_email);

				// set script tags for <head>
				$head_scripts = array();

				// set editor script for footer
				$foot_scripts = array('<script src="/ci/resources/js/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>');


				$view_data = array(
						'page' => 'admin/pages/admin_edit_page_view',
						'head_data' => array('title' => 'Edit Page | CMS', 'head_scripts' => $head_scripts),
						'header_active' => TRUE,
						'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
						'page_data' => array('site_url' => $site_url, 'page_obj' => $page_obj, 'testimonials' => $testimonials, 'form_items' => $form_items, 'emails' => $emails, 'fields' => $fields),
						'footer_active' => TRUE,
						'footer_data' => array('foot_scripts' => $foot_scripts)
					);
				$this->load->view('admin/general/admin_template', $view_data);

			} else { 
				// no page data returned
				$this->flash_msg->set_message('Page cannot be found, please try again or create a new page');
				redirect(base_url() . 'admin/pages');
			}	

		} else {
			// no page id in uri
			$this->flash_msg->set_message('No page selected');
			redirect(base_url() . 'admin/pages');
		}
	
	}


	/**
	 * delete page
	 *
	 * @param  void
	 * @return void
	 */
	
	function delete() {
		
		if($page_id = $this->uri->segment(4)) {

			$page_id = explode('-', $page_id);
			$page_arr = array();
			foreach($page_id as $page) {
				$page_arr[] = (int) $page;
			}

			if($this->pages_model->delete_page($page_id)) {
				$msg = 'Page successfully deleted';
			} else {
				$msg = 'Error deleting page';
			}

		} else {
			// no page id in uri
			$msg = 'No valid page selected';
			
		}	
		$this->flash_msg->set_message($msg);
		redirect(base_url() . 'admin/pages');
	
	}
	

	/**
	 * preview a page
	 *
	 * @param  void
	 * @return void
	 */
	
	function preview() {
		
		if($page_id = $this->uri->segment(4)) {

			$page_id = (int)$page_id;

			// get page data
			$page_obj = $this->pages_model->get_page_by_id($page_id);

			$view_data = array(
					'page' => 'admin/pages/admin_preview_page_view',
					'head_data' => array('title' => $page_obj->title, 'message' => 'You are previewing a page'),
					'header_active' => FALSE,
					'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
					'page_data' => array('page_obj' => $page_obj),
					'footer_active' => FALSE
				);
			$this->load->view('admin/general/admin_template', $view_data);

		} else {
			$this->flash_msg->set_message('Error previewing page: invalid page');
			redirect(base_url() . 'admin/pages');
		}	
	
	}


	/**
	 * menu manager
	 *
	 * @param  void
	 * @return void
	 */
	
	function menu() {

		if($this->input->post('menu_submit')) { // form submitted

			// test if menu items were posted
			if($this->input->post('menu_item')) {
				if($this->pages_model->update_menu($this->input->post('menu_item'))) {
					$msg = 'Menu successfully updated';
				} else {
					$msg = 'Error updating menu';
				}
			} else {  // no menu items - all deleted
				$this->pages_model->delete_menu_items();
				$msg = 'Menu successfully updated';
			}

			$this->flash_msg->set_message($msg);
			redirect(base_url() . 'admin/pages/menu');
		}
		
		//get all menu data
		$menu_obj = $this->pages_model->get_all_menu_data();

		// get all pages data
		$pages_obj = $this->pages_model->get_all_pages();

		// prepare pages dropdown array
		$pages_arr = array('null' => 'select page');
		if(!empty($pages_obj)) {	
			foreach($pages_obj as $obj) {
				$pages_arr[$obj->title] = $obj->title;
			}
		}

		// prepare additional head css link 
		$head_scripts = '<link rel="stylesheet" href="'. base_url() .'resources/js/libs/jquery-ui-1.8.23.custom/css/ui-lightness/jquery-ui-1.8.23.custom.css" type="text/css">';
		
		$view_data = array(
				'page' => 'admin/pages/admin_menu_view',
				'head_data' => array('title' => 'Menu Manager | CMS', 'scripts' => $head_scripts),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => array('pages' => $pages_arr, 'menus' => $menu_obj),
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}
	
	
	


	/****************************/
	/*		AJAX methods 		*/					
	/****************************/
	
	/**
	 * ajax check if page url already exists
	 *
	 * @param  none
	 * @return bool
	 */
			
	function check_url() {

		if($this->input->is_ajax_request()) {
		
			$url = $this->input->post('url');

			if($this->pages_model->page_url_available($url)) {
				echo 1;
			} else {
				echo 0;
			}

		} else {
			exit();
		}	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * ajax - add testimonial
	 *
	 * @param  
	 * @return json
	 */
	
	function ajax_add_testimonial() {
		
		if($this->input->is_ajax_request()) {
		
			$data = json_decode($this->input->post('testimonial'), TRUE);

			$insert_arr = array(
				'page_id' => (int)$data['pageId'],
				'name' => $data['name'],
				'location' => $data['location'],
				'testimonial' => $data['testimonial']
			);

			if($result = $this->pages_model->add_testimonial($insert_arr)) {
				$message = array('success' => TRUE, 'testimonialId' => (int)$result);	

			} else {
				$message = array('success' => FALSE, 'message' => 'error adding testimonial');	
			}
			echo json_encode($message);

		} else {
			echo json_encode(array('success' => FALSE, 'message' => 'access restricted'));
			exit();
		}
	
	}
	


	/**
	 * ajax delete testimonial by id
	 *
	 * @param  
	 * @return bool
	 */
	
	function ajax_delete_testimonial() {

		if($this->input->is_ajax_request()) {
		
			$id = (int) $this->input->post('testimonial_id');

			$message = array();
			if($this->pages_model->delete_testimonial_by_id($id)) {
				$message['success'] = TRUE;
			} else {
				$message['success'] = FALSE;
			}
			echo json_encode($message);

		} else {
			echo json_encode(array('success' => FALSE, 'message' => 'access restricted'));
			exit();
		}		

	}
	

	/**
	 * ajax check if form internal name already exists
	 *
	 * @param  none
	 * @return bool
	 */
	
	function ajax_internal_name_exists() {

		if($this->input->is_ajax_request()) {

			$name = $this->input->post('name');	
			
			if($this->pages_model->internal_name_exists($name)) {
				echo 1;
			} else {
				echo 0;
			}

		} else {
			exit();
		}	
	
	}
	
	
	





} // end class	