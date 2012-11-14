<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'google-api-php-client/src/apiClient.php';
require_once 'google-api-php-client/src/contrib/apiAnalyticsService.php';

/**
 * Analytics Kit
 *
 * Google analytics report api library for Code Igniter.
 *
 * NOTE! In order for this library to work - you must set a valid redirect uri in the  
 * constructor param and in your google api console
 *
 *
 * @package		Analytics_kit
 * @author		Adam Jacox
 * @version		1.0
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */

class Analytics_kit {
	
	private $analytics;   // main analytics object - created in constructor
	private $profile_id;  // profile specific id - pulled from db
	private $account_id;  // account id - pulled from db

	// db config vars
	private $settings_table;
	private $token_table;

	// api config vars - pulled from settings table in db
	private $app_name;
	private $client_id;
	private $client_secret;
	private $redirect_uri;
	private $dev_key;
	private $scopes = array('https://www.googleapis.com/auth/analytics.readonly');

	// api call results
	private $error = array();
	private $results;
	private $profile_name;
	private $auth_url;
	private $authorized;


	function __construct($params) {

		// CI loading
		$this->ci =& get_instance();
		$this->ci->load->database();

		// initialize config settings
		$this->settings_table = $params['db']['settings_table'];
		$this->token_table = $params['db']['token_table'];

		// initialize GA api config settings
		$acct = $this->get_account_info_from_settings();
		$this->client_id = $acct->ga_client_id;
		$this->client_secret = $acct->ga_client_secret;
		$this->dev_key = $acct->ga_dev_key;
		$this->app_name = $acct->ga_app_name;
		$this->profile_id = $acct->ga_profile_id;
		$this->account_id = $acct->ga_account_id;

		// set redirect uri from constructor param
		$this->redirect_uri = $params['uri'];

		// initialize client object for auth
		$client = new apiClient();
		$client->setApplicationName($this->app_name);

		$client->setClientId($this->client_id);
		$client->setClientSecret($this->client_secret);
		$client->setRedirectUri($this->redirect_uri);
		$client->setDeveloperKey($this->dev_key);
		$client->setScopes($this->scopes);
		// Returns objects from the Analytics Service instead of associative arrays.
		$client->setUseObjects(true);

		// check if 'code' is in GET string from uri redirect
		// if so, set session cookie and redirect back again
		if (isset($_GET['code'])) {
		  $client->authenticate();
		  $this->save_token($client->getAccessToken());
		  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}

		if($token_data = $this->get_token_data()) {
			$client->setAccessToken($token_data->token);
		}

		// authenticate
		if (!$client->getAccessToken()) {  // not authorized
			$this->authorized = FALSE;
			$this->auth_url = $client->createAuthUrl();

		} else {  // authorized
			$this->authorized = TRUE;
			// Create analytics service object
			$this->analytics = new apiAnalyticsService($client);
		}

	}


	/**
	 * save access token in db
	 *
	 * @param str
	 * @return bool
	 */
	
	function save_token($token) {

		$update_arr = array('token' => $token);
		
		$this->ci->db->where('id', '1');
		$this->ci->db->update($this->token_table, $update_arr);

		if($this->ci->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	
	}


	/**
	 * get token from db
	 *
	 * @param  
	 * @return array
	 */
	
	function get_token_data() {
		
		$this->ci->db->select('token, reset_token');
		$this->ci->db->where('id', '1');
		$query = $this->ci->db->get($this->token_table);

		if($query->num_rows() == 1) {
			return $query->row();
		}
		return FALSE;
	
	}
	
	


	/**
	 * get all GA reporting data results
	 *
	 * @param str, str, array, array
	 * @return array
	 */

	function get_data($start_date, $end_date, $metric_arr, $dimension_arr=array()) {

		try {

			// set params for api call - (dates already set from function params)
			$id = 'ga:'. $this->get_profile_id();
			//$metrics = 'ga:'. implode(',ga:', $metric_arr);
			$metrics = 'ga:'. implode(',ga:', $metric_arr);
			$dimensions = 'ga:'. implode(',ga:', $dimension_arr);
			$opt_params = array('dimensions' => $dimensions);

	    	$results = $this->analytics->data_ga->get($id, $start_date, $end_date, $metrics, $opt_params);

	    	if (count($results->getRows()) > 0) {
			    
			    // set profile name
			    $this->profile_name = $results->getProfileInfo()->getProfileName();

			    $this->results = $results->getRows();
			    return $results->getRows();

		    } else {
		    	$this->error[] = 'No results found';
		    }	

		} catch (apiServiceException $e) {
			// Error from the API.
			$this->error[] = 'There was an API error : ' . $e->getCode() . ' : ' . $e->getMessage();

		} catch (Exception $e) {
			$this->error[] = 'There was a general error : ' . $e->getMessage();
		}
	
	}


	/**
	 * get user GA profile by array index
	 *
	 * @param int
	 * @return str
	 */

	function get_profile_by_index($index=0) {

	  if ($items = $this->get_all_profile_accts()) {
	    $firstAccountId = $items[$index]->getId();

	    $webproperties = $this->analytics->management_webproperties
	        ->listManagementWebproperties($firstAccountId);

	    if (count($webproperties->getItems()) > 0) {
	      $items = $webproperties->getItems();
	      $firstWebpropertyId = $items[0]->getId();

	      $profiles = $this->analytics->management_profiles
	          ->listManagementProfiles($firstAccountId, $firstWebpropertyId);

	      if (count($profiles->getItems()) > 0) {
	        $items = $profiles->getItems();
	        
	        // set profile id property
	        $this->profile_id = $items[0]->getId();
	        return $items[0]->getId();

	      } else {
	        throw new Exception('No profiles found for this user.');
	      }
	    } else {
	      throw new Exception('No webproperties found for this user.');
	    }
	  } else {
	    throw new Exception('No accounts found for this user.');
	  }
	
	}


	/**
	 * get all GA accounts
	 *
	 * @param none
	 * @return array
	 */

	function get_all_profile_accts() {
		
		$accounts = $this->analytics->management_accounts->listManagementAccounts();

		if (count($accounts->getItems()) > 0) {
			return $accounts->getItems();
		} 
		return FALSE;	

	}


	/**
	 * get GA account id from settings in db
	 *
	 * @param  	
	 * @return obj/bool
	 */
	
	function get_account_info_from_settings() {
		
		$this->ci->db->select('ga_profile_id, ga_account_id, ga_client_id, ga_client_secret, ga_dev_key, ga_app_name');
		$this->ci->db->where('id', '1');
		$query = $this->ci->db->get($this->settings_table);

		if($query->num_rows() == 1) {
			return $query->row();
		}
		return FALSE;
	
	}


	/**
	 * set all GA account properties
	 *
	 * @param array
	 * @return void
	 */
	
	function set_ga_acct_properties($acct) {
		
		// set developer credential properties
		$this->client_id = $acct->ga_client_id;
		$this->client_secret = $acct->ga_client_secret;
		$this->dev_key = $acct->ga_dev_key;
		$this->app_name = $acct->ga_app_name;

		// set profile properties
		$this->profile_id = $acct->ga_profile_id;
		$this->account_id = $acct->ga_account_id;
	
	}


	/**
	 * get GA profile id
	 *
	 * @param 
	 * @return str
	 */
	
	function get_profile_id() {
		
		return $this->profile_id;
	
	}


	/**
	 * get GA account id
	 *
	 * @param 
	 * @return str
	 */
	
	function get_account_id() {
		
		return $this->account_id;
	
	}	


	/**
	 * get profile name
	 *
	 * @param  
	 * @return str/bool
	 */
	
	function get_profile_name() {
		
		if(isset($this->profile_name)) {
			return $this->profile_name;
		}
		return FALSE;
	
	}
	

	/**
	 * get any errors
	 *
	 * @param  
	 * @return array/bool
	 */
	
	function get_errors() {
		
		if(!empty($this->error)) {
			return $this->error;
		}
		return FALSE;
	
	}
	

	/**
	 * get results of api call
	 *
	 * @param  
	 * @return array
	 */
	
	function get_results() {
		
		return $this->results;

	}


	/**
	 * get authorized status
	 *
	 * @param  
	 * @return bool
	 */
	
	function get_authorized_status() {
		
		return $this->authorized;
	
	}
	


	/**
	 * get auth url
	 *
	 * @param  
	 * @return str
	 */
	
	function get_auth_url() {
		
		return $this->auth_url;
		
	}
	
	



} // end class