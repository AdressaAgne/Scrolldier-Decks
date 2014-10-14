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
	
	public function get_content($page) {
		//inclueds
		if (!array_key_exists($page, $this->pagestructure)) {
			$page = "404";
		}
		
		return $this->_completeUrl($this->pagestructure[$page]['page']);
		
	}
	
	public function get_title($page) {
		//echo
		
		if (!array_key_exists($page, $this->pagestructure)) {
			$page = "404";
		}
		
		return $this->pagestructure[$page]['title'];
		
	}
	
	public function get_styles($page) {
		//echo
		
		if (!array_key_exists($page, $this->pagestructure)) {
			$page = "404";
		}
		return $this->pagestructure[$page]['style'];
		
	}
	
	
}

