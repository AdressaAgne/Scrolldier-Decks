<?php 
class Structure{
	
	
	protected $_request;
	protected $_path;
	protected $_page;
		
	function __construct() {
		$this->_request = parse_url($_SERVER['REQUEST_URI']);
		$this->_path = $this->_request["path"];
		$this->_page = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $this->_path), '/');
	}
	
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
		return substr($page, strpos($page, $this->variableDevider), 6);
	}
	
	
	//check the if the page exists, if it does not display 404 page
	private function _checkPage() {
		if (!empty($this->_page)) {
			if (array_key_exists($this->_page, $this->pagestructure)) {
				return $this->_page;
			} else {
				
				$page = $this->_get_page_name($this->_page);
				
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
	public function get_content() {
		//inclueds
		$page = $this->_checkPage($this->_page);
		
		return $this->_completeUrl($this->pagestructure[$page]['page']);
		
	}
	
	//gets page title
	public function get_title() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['title'];
		
	}
	
	//gets additional styles to link up
	public function get_styles() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['style'];
		
	}
	
	
	//get a variable assigned to the specific page
	public function get_var($var) {
		return substr(strrchr($this->_page, $this->variableDevider), 1);
	}
	
	
}

