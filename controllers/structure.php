<?php 
class Structure {
	
	//Define the variable divider, and how you get a variable
	private $variableDevider = "/";
	
	//declaring page structures
	public $pagestructure = array(
		"/" => array(
			"title" => "Scrolldier",
			"page" => "main",
			"menu" => true,
			"name" => "Home",
			"style" => ""
		),
	
		"/decks" => array(
			"title" => "Scrolldier - Decks",
			"page" => "deck",
			"menu" => true,
			"name" => "Decks",
			"style" => ""
		),
		
		"/deck" => array(
			"title" => "Scrolldier - Deck",
			"page" => "deck",
			"style" => "",
			"var" => array(
				"deck_id" => null
			)
		),
		
		"404" => array(
			"title" => "404 Error",
			"page" => "404",
			"style" => ""
		)
	);
	
	
	// completes the page/file url
	private function _completeUrl($page) {
		return "view/".$page.".php";
	}
	
	
	//gets the real name of a url to feed to the _checkPage, so we can have variables
	public function _get_page_name($page) {
		return substr($page, 0, strpos($page, $this->variableDevider));
	}
	
	
	//check the if the page exists, if it does not display 404 page
	private function _checkPage($page) {
		if (!empty($page)) {
			if (array_key_exists($page, $this->pagestructure)) {
				return $page;
			} else {
				
				$page = $this->_get_page_name($page);
				
				if (array_key_exists($page, $this->pagestructure)) {
					return $page;
				} else {
					return "404";
				}
				
			}
		} else {
			return "/";	
		}
	}
	
	
	//gets the correct file to display
	public function get_content($page) {
		//inclueds
		$page = $this->_checkPage($page);
		
		return $this->_completeUrl($this->pagestructure[$page]['page']);
		
	}
	
	//gets page title
	public function get_title($page) {
		//echo
		
		$page = $this->_checkPage($page);
		
		return $this->pagestructure[$page]['title'];
		
	}
	
	//gets additional styles to link up
	public function get_styles($page) {
		//echo
		
		$page = $this->_checkPage($page);
		
		return $this->pagestructure[$page]['style'];
		
	}
	
	
	//get a variable assigned to the specific page
	public function get_var($page, $var) {
		return substr($page, strpos($page, $this->variableDevider) +1);
	}
	
	
}

