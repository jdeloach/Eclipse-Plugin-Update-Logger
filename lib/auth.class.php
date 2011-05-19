<?php

class Auth {
	

	
	function __construct($users) {
		$this->users = $users;
	}
	function login($user, $passwd) {
		if( $this->users[$user] == md5($passwd) ) {
			$_SESSION['user'] = $user;
			$_SESSION['logged'] = true;
			return true;
			print "Logged in.";
			exit;
		}else{
			print $this->errorMsg = 'Your password did not match your user account or your user account does not exist.';
			return false;
		}
	}
	function logout() { // get out and deystroy all our info
		session_destroy();
	}
	
	// is's \\
	
	function is_logged() {
		if(isset($_SESSION['logged'])) {
			return true;
		}else{
			return false;
		}
	} 
	
	// misc \\
	function addUser($user, $passwd) {
		$fh = fopen('lib/.users.php', 'a') or die('Failed to open users file.');
		$string = '$users["'.$user.'"] = \''.md5($passwd)."';\n";
		fwrite($fh, $string);
		fclose($fh);
	}
	function error() { // get any errors from logging in
		return $this->errorMsg;
	}
}