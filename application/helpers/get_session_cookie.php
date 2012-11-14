<?php 

/**
 * get session cookie outside of CI application folder to check user status
 *
 * @param none 
 * @return array
 */

function get_session_cookie() {
	
	// get session cookie
	if(isset($_COOKIE['ci_session'])) {
		$cookie = $_COOKIE['ci_session'];
		$cookie = unserialize($cookie);
		$session_id = $cookie['session_id'];  

		// get serialized session from db
		$host = 'localhost';
		$dbname = 'test';
		$user = 'root';
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

		return $row_arr;
	}
	return FALSE;	

}

