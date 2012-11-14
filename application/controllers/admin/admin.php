<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('/../../libraries/phpass-0.1/PasswordHash.php');

/**
 * Admin section for base CMS
 *
 * @author		Adam Jacox
 * @version		1.0
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */

class Admin extends CI_Controller {

	private $site_settings;

	function __construct() {

		parent::__construct();

		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library('tank_auth');
		$this->load->library('flash_msg');
		$this->load->model('admin/admin_model');

		// get site settings
		$this->load->model('admin/admin_model');
		$this->site_settings = $this->admin_model->get_all_site_settings();

		// form validation
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error" id="admin-err">', '</p>');

		// ensure admin is logged in 
		$this->tank_auth->user_not_admin_redirect();
	}


	/**
	 * index method - dashboard
	 *
	 * @param  none
	 * @return none
	 */
	
	function index() {

		/*** google analytics report api ***/
		/*$init_arr = array(
					'uri'	=> 'http://localhost/ci/admin/admin',
					'db'	=> array('settings_table' => 'settings', 'token_table' => 'ga_token')
				);
		$this->load->library('analytics_kit', $init_arr);

		if($this->analytics_kit->get_authorized_status()) {  // check if oAuth authorized

			$ga_auth['status'] = TRUE;
			$ga_auth['url'] = '';

			// get start and end dates for last 10 days (not including today)
			$end_time = time() - (3600 * 24);
			$start_time = time() - (3600 * 24 * 11);  // 10 days ago

			$end_date = date('Y-m-d', $end_time);
			$start_date = date('Y-m-d', $start_time);

			$ga_data = $this->analytics_kit->get_data($start_date, $end_date, array('visits', 'visitors'), array('date'));

			$foot_scripts = array();
			$ga_err = TRUE;
			if(!$this->analytics_kit->get_errors()) {  // no errors found in api call
			
				//print_r($ga_data);
				// prep returned analytics data for chart
				$visit_arr = array();	
				$visitors_arr = array();
				foreach($ga_data as $ga) {
					$visit_arr[] = $ga[1];
					$visitors_arr[] = $ga[2];
				}
				$first_date = substr($ga_data[0][0], 0, 4) .', '. (substr($ga_data[0][0], 4, 2) - 1) .', '. substr($ga_data[0][0], 6, 2);

				// foot_scripts for chart
				$chart = 'chart1 = new Highcharts.Chart({
							chart: {
								renderTo: "ga-container",
								type: "line",
								marginRight: 45,
								marginLeft: 50,
								height: 300
							},
							title: {
								text: "Site Traffic",
								margin: 45
							},
							xAxis: {
								type: "datetime",
								dateTimeLabelFormats: {
									day: "%b %e"
								},
								tickInterval: 48 * 3600 * 1000
							},
							yAxis: {
								min: 0,
								title: {
									text: ""
								}
							},
							series: [{
								name: "Total Visits",
								//showInLegend: false,
								data: ['. implode(", ", $visit_arr) .'],
								pointStart: Date.UTC('. $first_date .'),
								pointInterval: 24 * 3600 * 1000 // one day
							}, { 
								name: "Visitors",
								//showInLegend: false,
								data: ['. implode(", ", $visitors_arr) .'],
								pointStart: Date.UTC('. $first_date .'),
								pointInterval: 24 * 3600 * 1000 // one day
							}]
						});'; // end $chart

				$foot_scripts = array(
								'<script src="'. base_url() .'resources/js/admin/libs/highcharts-2.3.1/js/highcharts.js"></script>', 
								'<script>'. $chart .'</script>'
								);

			} else {  // analytics api error

				$ga_err = FALSE;
				//$ga_err_msg = $this->analytics_kit->get_errors();
				//$ga_err_msg = implode('<br/>', $ga_err_msg);
			}	

		} else {   // not oAuth authorized
			
			$ga_auth['status'] = FALSE;
			$ga_auth['url'] = $this->analytics_kit->get_auth_url();		
		}*/
		/*** end analytics ***/

		$foot_scripts = array('<script src="'. base_url() .'resources/js/admin/libs/highcharts-2.3.1/js/highcharts.js"></script>', '<script src="'. base_url() .'resources/js/admin/admin-ga.js"></script>');

		// get settings data for blog url
		$settings = $this->admin_model->get_settings_by_type(array('site'));

		// get admin dashboard data
		$date_inv = array('num' => 1, 'type' => 'DAY'); // prep date interval to count new users
		$dash_arr = $this->admin_model->get_dashboard_data($date_inv);

		$view_data = array(
				'page' => 'admin/admin/admin_dashboard_view',
				'head_data' => array('title' => 'Admin Dashboard | CMS'),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => array('dashboard' => $dash_arr, /*'ga_err' => $ga_err, 'ga_auth' => $ga_auth,*/ 'settings' => $settings),
				'footer_active' => TRUE,
				'footer_data' => array('foot_scripts' => $foot_scripts)
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}
	

	/**
	 * settings controller
	 *
	 * @param  void
	 * @return void
	 */
	
	function settings() {

		// start form validation 
		$this->form_validation->set_rules('company_name', 'Company name', 'trim|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('site_url', 'Site URL', 'trim|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('site_title', 'Site title', 'trim|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('company_email', 'Company email', 'trim|valid_email|xss|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('admin_send_email', 'Admin notification', 'trim|xss|is_natural');
		$this->form_validation->set_rules('blog_url', 'Blog URL', 'trim|xss|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('smtp_server', 'SMTP server', 'trim|xss|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('smtp_port', 'SMTP port', 'trim|xss|numeric|min_length[2]|max_length[4]');
		$this->form_validation->set_rules('smtp_user', 'SMTP username', 'trim|xss|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('smtp_pass', 'SMTP password', 'trim|xss|min_length[3]|max_length[255]');
		//$this->form_validation->set_rules('users_plugin', 'Users module', 'trim|xss|is_natural');
		//$this->form_validation->set_rules('pages_plugin', 'Pages module', 'trim|xss|is_natural');
		$this->form_validation->set_rules('analytics', 'Google analytics', 'trim|xss');
		$this->form_validation->set_rules('ga_profile_id', 'analytics profile id', 'trim|xss');
		$this->form_validation->set_rules('ga_account_id', 'analytics account id', 'trim|xss');

		if($this->form_validation->run()) {    //passed validation

			// encrypt password
			$this->load->library('encrypt');
			$enc_password = $this->encrypt->encode($this->input->post('smtp_pass'));
			
			$update_array = array(
					'company_name' 		=> $this->input->post('company_name'),
					'site_url' 			=> $this->input->post('site_url'),
					'site_title' 		=> $this->input->post('site_title'),
					'company_email'		=> $this->input->post('company_email'),
					'admin_send_email'	=> ((int)$this->input->post('admin_send_email') == 1) ? 1 : 0,
					'blog_url'			=> $this->input->post('blog_url'),
					'smtp_server' 		=> $this->input->post('smtp_server'),
					'smtp_port' 		=> $this->input->post('smtp_port'),
					'smtp_user' 		=> $this->input->post('smtp_user'),
					'smtp_pass' 		=> $enc_password,
					//'users_plugin' 		=> ((int)$this->input->post('users_plugin') == 1) ? 1 : 0,
					//'pages_plugin'		=> ((int)$this->input->post('pages_plugin') == 1) ? 1 : 0,
					'analytics'			=> $this->input->post('analytics'),
					'ga_profile_id'		=> $this->input->post('ga_profile_id'),
					'ga_account_id'		=> $this->input->post('ga_account_id')
				);	

			// check if saved

			if($this->admin_model->update_settings($update_array)) {
				$this->flash_msg->set_message('Settings saved successfully');
			} else {
				$this->flash_msg->set_message('Error saving settings');
			}
			redirect(base_url() . 'admin/admin/settings');
			
		} // end form validation

		// get all settings 
		$settings_obj = $email = $this->admin_model->get_all_site_settings();

		// add external files
		$foot_scripts = '<script type="text/javascript" src="/ci/resources/js/libs/jquery.qtip.min.js"></script>';
		$head_css = '<link rel="stylesheet" href="/ci/resources/css/admin/jquery.qtip.css" type="text/css">';
		
		$view_data = array(
				'page' => 'admin/admin/admin_settings_page_view',
				'head_data' => array('title' => 'Site Settings | CMS', 'head_scripts' => $head_css),
				'header_active' => TRUE,
				'header_data' => array('site_title' => $this->site_settings->site_title, 'message' => $this->flash_msg->get_message()),
				'page_data' => array('settings' => $settings_obj),
				'footer_active' => TRUE,
				'footer_data' => array('foot_scripts' => $foot_scripts)
			);
		$this->load->view('admin/general/admin_template', $view_data);
	
	}


	//-------------------------------------------------------------------------------//
	//    ajax functions	
	//-------------------------------------------------------------------------------//


	//-------------------------------------------------------------------------------//
		
	/**
	 * google analytics - ajax
	 *
	 * @param  
	 * @return 
	 */
	
	function analytics_data() {

		if($this->input->is_ajax_request()) {

			$data = array();
		
			/*** google analytics report api ***/
			$init_arr = array(
						'uri'	=> 'http://localhost/ci/admin/admin',
						'db'	=> array('settings_table' => 'settings', 'token_table' => 'ga_token')
					);
			$this->load->library('analytics_kit', $init_arr);

			if($this->analytics_kit->get_authorized_status()) {  // check if oAuth authorized

				$ga_auth['status'] = TRUE;
				$ga_auth['url'] = '';

				// get start and end dates for last 10 days (not including today)
				$end_time = time() - (3600 * 24);
				$start_time = time() - (3600 * 24 * 11);  // 10 days ago

				$end_date = date('Y-m-d', $end_time);
				$start_date = date('Y-m-d', $start_time);

				$ga_data = $this->analytics_kit->get_data($start_date, $end_date, array('visits', 'visitors'), array('date'));

				$ga_err = TRUE;
				if(!$this->analytics_kit->get_errors()) {  // no errors found in api call
				
					// prep returned analytics data for chart
					$visit_arr = array();	
					$visitors_arr = array();
					foreach($ga_data as $ga) {
						$visit_arr[] = (int)$ga[1];
						$visitors_arr[] = (int)$ga[2];
					}
					$first_date = substr($ga_data[0][0], 0, 4) .', '. (substr($ga_data[0][0], 4, 2) - 1) .', '. substr($ga_data[0][0], 6, 2);

					$data['success'] = TRUE;
					$data['visits'] = $visit_arr;
					$data['visitors'] = $visitors_arr;

					//$data['firstDate'] = $first_date;
					$data['firstDate'] = array(
							'year' => (int)substr($ga_data[0][0], 0, 4),
							'month' => (int)(substr($ga_data[0][0], 4, 2) - 1),
							'day' => (int)substr($ga_data[0][0], 6, 2)
							);

				} else {  // analytics api error

					$data['success'] = FALSE;
					$data['message'] = 'google analytics api error';
				}	

			} else {   // not oAuth authorized

				$data['success'] = FALSE;
				$data['message'] = 'oAuth';
				$data['oauthUrl'] = $this->analytics_kit->get_auth_url();	
			}

			echo json_encode($data);

		} else { // end is_ajax_request()	
			echo json_encode(array('success' => FALSE, 'message' => 'access restricted'));
		}	
	
	}
	
	



} // end class