<?php 
class Structure {
	
	//declaring page structures
	private $pagestructure = array(
		"/decks" => array(
			"title" => "Scrolldier Decks",
			"page" => "deck",
			"style" => ""
		),
		
		"" => array(
			"title" => "Scrolldier.com",
			"page" => "main",
			"style" => ""
		),
		
		"404" => array(
			"title" => "Scrolldier 404 Error",
			"page" => "404",
			"style" => ""
		)
	);
	
	private function _completeUrl($page) {
		return "view/".$page.".php";
	}
	
	private function _checkPage($page) {
		if (array_key_exists($page, $this->pagestructure)) {
			return $page;
		} else {
			return "404";
		}
	}
	
	public function get_content($page) {
		//inclueds
		$page = $this->_checkPage($page);
		
		return $this->_completeUrl($this->pagestructure[$page]['page']);
		
	}
	
	public function get_title($page) {
		//echo
		
		$page = $this->_checkPage($page);
		
		return $this->pagestructure[$page]['title'];
		
	}
	
	public function get_styles($page) {
		//echo
		
		$page = $this->_checkPage($page);
		
		return $this->pagestructure[$page]['style'];
		
	}
	
	
}

