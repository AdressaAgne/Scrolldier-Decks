<?php 
class Structure extends Base{

	protected $_page;
	protected $_vars;
	
	//Define the variable divider
	protected $variableDevider = "/";
	
	//getting the current page the user are viewing
	function __construct() {
		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = $request["path"];
		
		$this->_vars = explode("/", $path);
		$this->_page = "/".$this->_vars[1];
	}
	

	
	
	// completes the page/file url
	private function _completeUrl($page) {
		return "view/".$page.".php";
	}
	
	
	//gets the real name of a url to feed to the _checkPage, so we can have variables
	public function _get_page_name() {
	
		return substr($this->_page, strpos($this->_page, $this->variableDevider), 6);
	}
	
	
	//check the if the page exists, if it does not display 404 page
	private function _checkPage() {
		$page = $this->_get_page_name();
		if (!empty($this->_page)) {
			if (array_key_exists($this->_page, $this->pagestructure)) {
				return $this->_page;
			} else {
				return "404";
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
	
	//gets additional styles to link up
	public function get_name() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['name'];
		
	}
	
	//gets additional styles to link up
	public function get_page() {
		//echo
		
		return $this->_page;
		
	}
	
	//get a variable assigned to the specific page
	public function get_var($var) {
		if (isset($this->_vars[$var + 1])) {
			return $this->_vars[$var + 1];
		} else {
			return "none";
		}
	
		
	}
	
	
}

