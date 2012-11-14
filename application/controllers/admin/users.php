<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin section for base CMS
 *
 * @author		Adam Jacox
 * @version		1.0
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */

class Users extends CI_Controller {

	private $site_settings;

	function __construct() {

		parent::__construct();

		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library('tank_auth');
		$this->load->library('flash_msg');
		$this->load->model('tank_auth/users_model');
		$this->lang->load('tank_auth');

		// get site settings
		$this->load->model('admin/admin_model');
		$this->site_settings = $this->admin_model->get_all_site_settings();

		// form validation
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		// ensure admin is logged in 
		$this->tank_auth->user_not_admin_redirect();
	}


	/**
	 *	default method - ensure user is logged in, if so, display user managment view
	 *	
	 * @return void	
	 */

	function index() {

		// get user role from GET string
		$get_query['user_role'] = ($this->input->get('sort')) ? $this->input->get('sort') : 'all';

		// get sort_by column from GET string
		$get_query['sort_col'] = ($this->input->get('col')) ? $this->input->get('col') : '';

		// get sort_by direction from GET string
		$get_query['sort_dir'] = ($this->input->get('dir') == 'desc') ? 'desc' : 'asc';
		$get_query['sort_dir_opp'] = ($get_query['sort_dir'] == 'asc') ? 'desc' : 'asc';

		// prep pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() .'admin/users/?sort='. $get_query['user_role'] .'&col='. $get_query['sort_col'];
		$config['total_rows'] = $this->users_model->count_users($get_query['user_role']);
		$config['per_page'] = 15;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();

		// get all user data
		$users_data = $this->users_model->get_all_users($get_query['user_role'], $config['per_page'], (int)$this->input->get('per_page', TRUE), $get_query['sort_col'], $get_query['sort_dir']);

		// count number of total current users
		$count['total'] = $this->users_model->count_users();

		// count number of admins
		$count['admin'] = $this->users_model->count_users('admin');

		// calc number of regular users
		$count['users'] = $count['total'] - $count['admin'];

		$data = array(
				'page' => 'admin/users/admin_users_main_view',
				'head_data' => array('title' => 'Manage Users | CMS'),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()), 
				'page_data' => array('users' => $users_data, 'user_count' => $count, 'pagination' => $pagination, 'get_query' => $get_query),
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $data);

	}


	/**
	 * delete user
	 *
	 * @param  string
	 * @return void
	 */
	
	function delete() {
		
		// get user id param
		if($user_id = $this->uri->segment(4)) {

			$user_id = explode('-', $user_id);

			$validate = TRUE;
			foreach($user_id as $id) {
				if(! is_numeric($id)) {
					$validate = FALSE;
				}
			}

			if($validate) {
				if($this->users_model->delete_user($user_id)) {
					$msg = 'User successfully deleted';
				} else {
					$msg = 'Error deleting user, please try again';
				}	
			} else {
				$msg = 'No valid user selected';
			}	

		} else {
			$msg = 'No user selected, please try again';
		}

		// set message then redirect
		$this->flash_msg->set_message($msg);
		redirect(base_url() . 'admin/users');
	}
	

	/**
	 * create new user
	 *
	 * @param  
	 * @return bool
	 */
	
	function add() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('first_name', 'First name', 'trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
		$this->form_validation->set_rules('role', 'Admin', 'trim|xss_clean|max_length[1]');

		$data['errors'] = array();

		$email_activation = FALSE; //$this->config->item('email_activation', 'tank_auth');

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->create_user(
					$this->form_validation->set_value('username'),
					$this->form_validation->set_value('email'),
					$this->form_validation->set_value('password'),
					$email_activation,
					$this->form_validation->set_value('first_name'),
					$this->form_validation->set_value('last_name'),
					($this->form_validation->set_value('role') == '1')? 1 : 0
				))) {									// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				/* uncomment for email notifications
				if ($email_activation) {									// send "activate" email
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					unset($data['password']); // Clear password (just for any case)

					$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

				} else {
					if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

						$this->_send_email('welcome', $data['email'], $data);
					}
					unset($data['password']); // Clear password (just for any case)

					$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
				}*/

				$this->flash_msg->set_message('User created successfully');
				redirect('admin/users');

			} else {
				$this->flash_msg->set_message('Error creating user');
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		}
		
		$view_data = array(
				'page' => 'admin/users/admin_add_user_view',
				'head_data' => array('title' => 'Create New User | CMS'),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => $data,
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $view_data);	
	
	}


	/**
	 * edit user data
	 *
	 * @param  none
	 * @return void
	 */
	
	function edit() {

		// get user id from uri
		if(is_numeric($this->uri->segment(4))) {
			$user_id = $this->uri->segment(4);
		} else {
			$this->flash_msg->set_message('No valid user selected');
			redirect(base_url() . 'admin/users');
			exit();
		}	
		
		// get current user data from db
		$current_user_data = $this->users_model->get_user_by_id_only($user_id);

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('first_name', 'First name', 'trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|xss_clean|matches[password]');
		$this->form_validation->set_rules('role', 'Admin', 'trim|xss_clean|max_length[1]');
		$this->form_validation->set_rules('banned', 'Banned', 'trim|xss_clean|max_length[1]');
		$this->form_validation->set_rules('ban_reason', 'Ban reason', 'trim|xss_clean|max_length[255]');

		$errors_arr = array();

		$email_activation = FALSE; //$this->config->item('email_activation', 'tank_auth');

		if ($this->form_validation->run()) {								// validation ok
			if ($this->tank_auth->update_user(array(
					'user_id'		=> $user_id,
					'cur_username'	=> $current_user_data->username,
					'username' 		=> $this->form_validation->set_value('username'),
					'cur_email'		=> $current_user_data->email,
					'email' 		=> $this->form_validation->set_value('email'),
					'password' 		=> $this->form_validation->set_value('password'),
					'first_name'	=> $this->form_validation->set_value('first_name'),
					'last_name' 	=> $this->form_validation->set_value('last_name'),
					'role' 			=> ($this->form_validation->set_value('role') == '1')? 1 : 0,
					'banned'		=> ($this->form_validation->set_value('banned') == '1')? 1 : 0,
					'ban_reason'	=> $this->form_validation->set_value('ban_reason')
				))) {									// success

				$this->flash_msg->set_message('User updated successfully');
				redirect(base_url() . 'admin/users');

			} else {
				$this->flash_msg->set_message('Error updating user');
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$errors_arr[$k] = $this->lang->line($v);
			}
		}
		
		$view_data = array(
				'page' => 'admin/users/admin_edit_user_view',
				'head_data' => array('title' => 'Edit User | CMS'),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => array('errors' => $errors_arr, 'user_data' => $current_user_data),
				'footer_active' => TRUE
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}
	
	






} // end Admin class	