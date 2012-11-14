<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages model
 *
 *
 * @author	Adam Jacox
 * @version 1.0
 */

class Pages_model extends CI_Model {

	private $table_pages = 'pages';
	private $table_menu = 'menu';
	private $table_testimonial = 'testimonials';
	private $table_forms = 'contact_forms';
	private $table_fields = 'custom_fields';


	//-------------------------------------------------------------------------------//

	/**
	 * get all page data
	 *
	 * @param	str(opt), str(opt)
	 * @return	array of objects
	 */

	function get_all_pages($limit='', $offset='') {

		if(!empty($limit)) {
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get($this->table_pages);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;

	}


	//-------------------------------------------------------------------------------//

	/**
	 * get pages for a specific page
	 *
	 * @param  int
	 * @return obj
	 */
	
	function get_page_by_id($id) {
		
		$this->db->where('id', $id);
		$query = $this->db->get($this->table_pages);

		if($query->num_rows() == 1) {
			return $query->row();
		} 
		return FALSE;
	
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * count number of pages in db
	 *
	 * @param  
	 * @return int
	 */
	
	function count_all_pages() {
		
		return $this->db->count_all($this->table_pages);
	
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * create new page
	 *
	 * @param  array
	 * @return bool
	 */
	
	function create_page($create_arr) {
		
		$this->db->insert($this->table_pages, $create_arr);

		if($this->db->affected_rows() == 1) {
			return $this->db->insert_id();
		}
		return FALSE;
	}


	//-------------------------------------------------------------------------------//

	/**
	 * update page data
	 *
	 * @param  array
	 * @return bool
	 */
	
	function update_page($update_arr, $page_id) {
		
		$this->db->where('id', $page_id);
		$this->db->update($this->table_pages, $update_arr);

		//if($this->db->affected_rows() > 0) {
			//return TRUE;
		//}
		return TRUE;
		//return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * delete page by id
	 *
	 * @param  int
	 * @return bool
	 */
	
	function delete_page($page_id, $delete_forms=TRUE, $delete_testimonials=TRUE) {
		
		if(is_array($page_id)) { 
			$this->db->where_in('id', $page_id); 
		} else {
			$this->db->where('id', $page_id);
		}
		$this->db->delete($this->table_pages);

		$return = TRUE;
		if($this->db->affected_rows() == 0) { $return = FALSE; }

		if($delete_forms) {
			// delete all form data by page id
			$this->delete_form_items_by_page_id($page_id);
		}

		if($delete_testimonials) {
			// delete all form data by page id
			$this->delete_testimonial_by_page_id($page_id);
		}

		return $return;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * insert custom fields into db
	 *
	 * @param  array
	 * @return bool
	 */
	
	function insert_fields($insert_arr, $batch=FALSE) {
		
		if($batch) {  // insert batch
			$this->db->insert_batch($this->table_fields, $insert_arr);
		} else {
			$this->db->insert($this->table_fields, $insert_arr);
		}

		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * add custom fields
	 *
	 * @param  array
	 * @return bool
	 */
	
	function add_custom_fields($keys, $values, $page_id) {
		
		// prep custom fields
		$fields_arr = array(); 
		$i = 0;
		foreach($keys as $key) {
			//if($key != '' && $key != NULL) {
				$fields_arr[] = array(
						'page_id'	=> $page_id,
						'field'		=> $key,
						'value'		=> $values[$i]
					); 
			//}	
			$i++;
		}	

		return $this->insert_fields($fields_arr, TRUE);  // 2nd param set to true to 
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * get all custom fields by page id
	 *
	 * @param  int
	 * @return array
	 */
	
	function get_fields_by_page_id($page_id) {
		
		$this->db->where('page_id', $page_id);

		$query = $this->db->get($this->table_fields);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;

	}


	//-------------------------------------------------------------------------------//

	/**
	 * delete custom fields by page id
	 *
	 * @param  int
	 * @return bool
	 */
	
	function delete_fields_by_page_id($page_id) {
		
		$this->db->where('page_id', $page_id);
		$this->db->delete($this->table_fields);

		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}
	
	
	//-------------------------------------------------------------------------------//

	/**
	 * check if page url already exists
	 *
	 * @param  string
	 * @return bool
	 */
	
	function page_url_available($url) {
		
		$this->db->where('url', $url);
		$this->db->select('id');
		$query = $this->db->get($this->table_pages);

		if($query->num_rows() < 1) {
			return TRUE;
		}
		return FALSE;
	}


	//-------------------------------------------------------------------------------//

	/**
	 * update values and order of menu items in db
	 *
	 * @param  array, str
	 * @return bool
	 */
	
	function update_menu($menu_arr, $prep_needed=TRUE) {

		if($prep_needed) {
			$menu_arr = $this->prep_menu_items($menu_arr);
		}

		// clear out old menu data
		$this->delete_menu_items(); 
		// insert new menu data
		$this->db->insert_batch($this->table_menu, $menu_arr);

		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//
		
	/**
	 * delete all menu items
	 *
	 * @param  
	 * @return bool
	 */
	
	function delete_menu_items() {
		
		// clear out all menu data
		$this->db->empty_table($this->table_menu);
	
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * get all menu data
	 *
	 * @param  none
	 * @return array (of objects)
	 */
	
	function get_all_menu_data() {
		
		$query = $this->db->get($this->table_menu);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * prepare menu items for update
	 *
	 * @param  array
	 * @return array
	 */
	
	function prep_menu_items($menu_arr) {
		
		$new_arr = array();
		$i = 1;
		foreach($menu_arr as $menu) {
			$values_arr = explode(',', $menu);
			$new_arr[] = array('title' => $values_arr[0], 'target' => $values_arr[1], 'type' => $values_arr[2], 'order' => $i);
			$i++;
		}	
		return $new_arr;
	}
	

	//-------------------------------------------------------------------------------//
	
	/**
	 * prep page url 
	 *
	 * @param  string
	 * @return string
	 */
	
	function prep_page_url($url) {
		
		return strtolower(preg_replace('/ /', '-', $url));
	}


	//-------------------------------------------------------------------------------//

	/**
	 * count all pages
	 *
	 * @param  void
	 * @return int
	 */
	
	function count_pages() {
		
		return $this->db->count_all($this->table_pages);
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * count number of published pages
	 *
	 * @param  bool
	 * @return int
	 */
	
	function count_published_pages($unpublished=FALSE) {

		$publish_type = 1;
		if($unpublished) {
			$publish_type = 0;
		}
		
		$this->db->where('publish', $publish_type);
		$this->db->from($this->table_pages);

		return $this->db->count_all_results();
	}


	//-------------------------------------------------------------------------------//

	/**
	 * insert new testimonial into db
	 *		
	 * @param array 
	 * @return bool
	 */
	
	function add_testimonial($create_arr) {
		
		$this->db->insert($this->table_testimonial, $create_arr);

		if($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * get all testimonials
	 *
	 * @param  none
	 * @return array
	 */
	
	function get_all_testimonials() {
		
		$query = $this->db->get($this->table_testimonial);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * get testimonials by page id
	 *
	 * @param  int
	 * @return array
	 */
	
	function get_testimonials_by_id($page_id) {
		
		$this->db->where('page_id', $page_id);
		$query = $this->db->get($this->table_testimonial);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * delete testimonial by id
	 *
	 * @param  int
	 * @return bool
	 */
	
	function delete_testimonial_by_id($id) {
		
		$this->db->where('id', $id);
		$this->db->delete($this->table_testimonial);

		if($this->db->affected_rows() == 1) {
			return TRUE;
		}
		return FALSE;

	}


	//-------------------------------------------------------------------------------//

	/**
	 * delete testimonial by page id
	 *
	 * @param  int
	 * @return bool
	 */
	
	function delete_testimonial_by_page_id($page_id) {
		
		if(is_array($page_id)) { 
			$this->db->where_in('page_id', $page_id); 
		} else {
			$this->db->where('page_id', $page_id);
		}
		$this->db->delete($this->table_testimonial);

		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * delete all contact from items by page id
	 *
	 * @param  int
	 * @return bool
	 */
	
	function delete_form_items_by_page_id($page_id) {

		if(is_array($page_id)) { 
			$this->db->where_in('page_id', $page_id); 
		} else {
			$this->db->where('page_id', $page_id);
		}
		$this->db->delete($this->table_forms);

		if($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;

	}
	

	//-------------------------------------------------------------------------------//

	/**
	 * add new contact form item
	 *
	 * @param  array
	 * @return bool
	 */
	
	function add_contact_form_item($form_arr, $page_id, $prep_needed=TRUE) {
			
		if($prep_needed) {
			$form_arr = $this->prep_form_items($form_arr, $page_id);
		}

		// insert new menu data
		$this->db->insert_batch($this->table_forms, $form_arr);

		if($this->db->affected_rows() > 0) { 
			return TRUE; 
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * prep the form items for insert
	 *
	 * @param  array
	 * @return array
	 */
	
	function prep_form_items($form_arr, $page_id) {
		
		$new_arr = array();
		$i = 1;
		foreach($form_arr as $form) {
			$values_arr = explode(',', $form);
			$new_arr[] = array('title' => $values_arr[0], 'input_type' => $values_arr[1], 'name' => $values_arr[2], 'page_id' => $page_id, 'order' => $i);
			if(isset($values_arr[3])) {
				$new_arr[($i-1)]['values'] = $values_arr[3];
			} else {
				$new_arr[($i-1)]['values'] = '';
			}
			$i++;
		}	
		return $new_arr;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * get all contact form items by page id
	 *
	 * @param  int
	 * @return array
	 */
	
	function get_form_items_by_id($page_id, $order_by='order', $dir='asc') {
		
		$this->db->where('page_id', $page_id);
		$this->db->order_by($order_by, $dir);
		$query = $this->db->get($this->table_forms);
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	
	}


	//-------------------------------------------------------------------------------//

	/**
	 * check if form internal name already exists
	 *
	 * @param  string
	 * @return bool
	 */
	
	function internal_name_exists($name) {
		
		$this->db->select('id');
		$this->db->where('name', $name);
		$query = $this->db->get($this->table_forms);

		if($query->num_rows() > 0) {
			return TRUE;
		}
		return FALSE;

	}
	
	


} // end class