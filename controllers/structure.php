<?php 
class structure {
	
	//declaring page structures
	private $page_structure = array(
		"/decks" => array(
			"title" => "Scrolldier Decks",
			"page" => "deck",
			"style" => ""
		),
		
		"/" => array(
			"title" => "Scrolldier.com",
			"page" => "main.php",
			"style" => ""
		)
	);
	
	private function _completeUrl($page) {
		return "view/".$page.".php";
	}
	
	public function get_content($page) {
		//inclueds
		
		return $this->_completeUrl($this->$page_structure[$page]['page']);
		
	}
	
	public function get_title($page) {
		//echo
		
		return $this->_completeUrl($this->$page_structure[$page]['title']);
		
	}
	
	public function get_styles($page) {
		//echo
		
		return $this->_completeUrl($this->$page_structure[$page]['style']);
		
	}
	
	
}

