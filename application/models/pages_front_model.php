<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Front_pages
 *
 * model for the front end pages
 *
 * @author	Adam Jacox
 */

class Pages_front_model extends CI_Model {

	private $table_pages = 'pages';
	private $table_custom = 'custom_fields';
	private $table_contact = 'contact_forms';
	private $table_testimonials = 'testimonials'; 

	function __construct() {

		parent::__construct();

		$this->load->model('admin/pages_model');

	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * check if url exists in db
	 *
	 * @param str
	 * @return bool
	 */
	
	function url_exists($url) {
		
		// prep url
		$url = $this->prep_url($url);

		// check if url exists in db
		$this->db->where('url', $url);
		$this->db->select('id');
		$query = $this->db->get($this->table_pages);

		if($query->num_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * get page data by url, if not found return false
	 *
	 * @param str
	 * @return array/bool
	 */
	
	function get_page_by_url($url) {
		
		// prep url
		$url = $this->prep_url($url);

		// check if url exists in db
		$this->db->where('url', $url);
		$query = $this->db->get($this->table_pages);

		if($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * prep url
	 * get rid of any file extensions
	 *
	 * @param str
	 * @return str
	 */
	
	function prep_url($url) {
		
		// prep url
		$url = pathinfo($url);
		$url = $url['filename'];

		return preg_replace('/[^a-zA-Z0-9-]/', '', $url);
	
	}
	

	//-------------------------------------------------------------------------------//
		
	/**
	 * get custom fields for page by page id
	 *
	 * @param  int
	 * @return array
	 */
	
	function get_custom_fields_by_page_id($id) {
		
		$this->db->where('page_id', $id);
		$query = $this->db->get($this->table_custom);

		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * get all the contact form items by page id
	 *
	 * @param  int
	 * @return array
	 */
	
	function get_contact_form_items_by_page_id($id) {
		
		$this->db->where('page_id', $id);
		$query = $this->db->get($this->table_contact);

		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * get all the testimonials by page id
	 *
	 * @param int
	 * @return array
	 */
	
	function get_testimonials_by_page_id($id) {
		
		$this->db->where('page_id', $id);
		$query = $this->db->get($this->table_testimonials);

		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}
	
	
	
	
	

} // end class