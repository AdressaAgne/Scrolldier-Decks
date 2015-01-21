<?php 
class AccountController extends Database {

	function page_setup($base) {
		
		$query = $this->_db->prepare("SELECT * FROM pages");
		
		if ($query->execute()) {
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$new_page = array(
					"id" => $row['id'],
					"title" => $row['title'],
					"name" => $row['name'],
					"page" => $row['file'],
					"menu" => $row['menu'],
					"tool" => $row['tool'],
					"image" => $row['image'],
					"restricted" => $row['restricted'],
					"grade" => $row['grade'],
					"style" => $row['style'],
					'footer' => $row['footer']
					
				);
				if (isset($base->pagestructure[$row['url']])) {
					$base->pagestructure[uniqid("error_")] = $new_page;
				} else {
					$base->pagestructure[$row['url']] = $new_page;
				}
				
			}
		}
		
		
		
	}
	
	public function login($username, $password, $remember, $use_token = false) {
		
		if ($use_token) {
			$query = $this->_db->prepare("SELECT * FROM accounts WHERE ign = :username AND token = :token");
			$arr = array(
			    'username' => $username,
			    'token' => $password
			);
			$this->arrayBinder($query, $arr);
		} else {
			$query = $this->_db->prepare("SELECT * FROM accounts WHERE ign = :username AND password = :password");
			$arr = array(
			    'username' => $username,
			    'password' => sha1($password)
			);
			$this->arrayBinder($query, $arr);
		}
		
		
		if ($query->execute()) {
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			$_SESSION['ign'] = $row['ign'];
			$_SESSION['rank'] = $row['rank'];
			$_SESSION['hasDonated'] = $row['hasDonated'];
			$_SESSION['mail'] = $row['mail'];
			$_SESSION['mailConfirmed'] = $row['mailConfirmed'];

			
			if ($remember) {
				$expire=time()+60*60*24*30;
				setcookie("remember_user", true, $expire);
				setcookie("scrolldier_usernmae", $row['username'], $expire);
				setcookie("scrolldier_token", $row['token'], $expire);
			}
			
			return true;
		} else {
			return false;
		}
		
	}
	
	public function logout() {
		unset($_SESSION['ign']);
		unset($_SESSION['rank']);
		unset($_SESSION['hasDonated']);
		unset($_SESSION['mail']);
		unset($_SESSION['mailConfirmed']);
		
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
	
	public $donor = false;
	
	public $mail = "";
	
	public $main_confirmed = false;
	
	
}