<?php 
class AccountController extends Database {
	
	
	public function login($username, $password, $remember, $use_token) {
		
		$query = $this->_db->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password");
		$arr = array(
		    'username' => $username,
		    'password' => sha1($password)
		);
		$this->arrayBinder($query, $arr);
		
		if ($query->execute()) {
			
		}
		$query->fetch(PDO::FETCH_ASSOC);
		
	}
	
	public function logout() {
		unset($_SESSION['username']);
		
		setcookie('scrolldier_usernmae', null, -1, '/');
		setcookie('scrolldier_token', null, -1, '/');
		
		unset($_COOKIE['scrolldier_usernmae']);
		unset($_COOKIE['scrolldier_token']);
		
		session_destroy();
	}
	
}

class Account {
	
	public $username = "";
	
	public $rank = 0;
	
	public $auth_token = "";
	
	public $donor = false;
	
	public $mail = "";
	
	public $main_confirmed = false;
	
	
}