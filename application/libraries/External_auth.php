<?php

/**
 * class name
 *
 * description
 *
 * @author	Adam Jacox
 */

class External_auth {

	private $session_data;

	/**
	 * get the session data for user from cookie
	 *
	 * @param  
	 * @return bool
	 */

	function get_session_data() {

		if(isset($_COOKIE['ci_session'])) {

			// get session id from cookie
			$cookie = unserialize($_COOKIE['ci_session']);
			$session_id = $cookie['session_id'];  

			// get serialized session from db
			$host = '';
			$dbname = '';
			$user = '';
			$pass = '';

			$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

			$stmt = $dbh->prepare("SELECT user_data FROM ci_sessions WHERE session_id = :sess_id");
			$stmt->bindParam(':sess_id', $session_id);
			$stmt->execute();

			// unserialize 
			while($row = $stmt->fetch(PDO::FETCH_NUM)) {
			    $row_arr = unserialize($row[0]);
			}

			// close db connection
			$dbh = NULL;

			$this->session_data = $row_arr;
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * check user is logged in and has admin role
	 *
	 * @param  
	 * @return bool
	 */
	
	function user_logged_in_admin() {
		
		$this->get_session_data();

		if($this->session_data['status'] == '1' && $this->session_data['role'] == '1') {
			return TRUE;
		}
		return FALSE;
	
	}
	

	
} // end class			