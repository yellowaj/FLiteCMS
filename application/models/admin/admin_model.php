<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin
 *
 * model for admin section
 *
 * @author	Adam Jacox
 */

class Admin_model extends CI_Model {

	private $settings_table = 'settings';
	private $settings_id = 1;


	/**
	 * get all dashboard data
	 *
	 * @param  none
	 * @return array (obj)
	 */
	
	function get_dashboard_data($date_inv) {

		$data = array();
		
		// get users data
		$this->load->model('tank_auth/users_model');
		// count new users
		$data['new_users'] = $this->users_model->count_new_users($date_inv['num'], $date_inv['type']);
		// count total users
		$data['total_users'] = $this->users_model->count_users();
		// count paending users
		$data['pending_users'] = $this->users_model->count_activated_users(TRUE);  //param is true to count unactivated users

		// get page data
		$this->load->model('admin/pages_model');
		// count active pages
		$data['published_pages'] = $this->pages_model->count_published_pages();
		// count total pages
		$data['total_pages'] = $this->pages_model->count_pages();
		// calculate draft pages
		$data['draft_pages'] = $data['total_pages'] - $data['published_pages'];

		// get page data
		$this->load->model('admin/quote_model');
		// count active pages
		$data['open_quotes'] = $this->quote_model->count_quotes_by_status('open');
		// count total pages
		$data['total_quotes'] = $this->quote_model->count_all_quotes();
		// calculate draft pages
		$data['closed_quotes'] = $data['total_quotes'] - $data['open_quotes'];

		// get pending data

		// get analytics api data

		return $data;
	
	}


	/**
	 * get all site settings
	 *
	 * @param	none
	 * @return	object
	 */

	function get_all_site_settings() {		

		$query = $this->db->get($this->settings_table, 1);
		return $query->row();
	}


	/**
	 * update site settings
	 *
	 * @param  array
	 * @return bool
	 */
	
	function update_settings($update_arr) {
		
		$this->db->where('id', $this->settings_id);
		$this->db->update($this->settings_table, $update_arr);

		if($this->db->affected_rows() == 1) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * get settings by type (mail, site, etc.)
	 *
	 * @param  array
	 * @return obj
	 */
	
	function get_settings_by_type($type_arr) {
		
		$select = '';
		foreach($type_arr as $type) {
			if($type == 'smtp') { $select .= 'smtp_server, smtp_port, smtp_user, smtp_pass '; }
			if($type == 'site') { $select .= 'company_name, site_url, site_title, company_email, admin_send_email, blog_url '; }
			if($type == 'plugins') { $select .= 'users_plugin, pages_plugin '; }
			if($type == 'analytics') { $select .= 'analytics, ga_app_name, ga_account_id, ga_profile_id, ga_client_id, ga_client_secret, ga_dev_key '; }
		}	

		$this->db->select($select);
		$query = $this->db->get($this->settings_table, 1);

		if($query->num_rows() == 1) {
			return $query->row();
		}
		return FALSE;
		
	}
	
	


} // end class