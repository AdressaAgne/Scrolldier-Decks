<?php 
//declaring page structures

class Base {
	public $pagestructure = array(
		"/" => array( 						//url extension
			"title" 	=> "Scrolldier", 	//title
			"page" 		=> "main", 			//file name without .php
			"menu" 		=> true, 			//if its included in the menu or not
			"name" 		=> "Home", 			//name of the page
			"style" 	=> "" 				//additional styles
		),
	
		"/decks" => array(
			"title" 	=> "Scrolldier - Decks",
			"page" 		=> "deck",
			"menu" 		=> true,
			"name" 		=> "Decks",
			"style" 	=> ""
		),
		
		"/deck" => array(
			"title" 	=> "Scrolldier - Deck",
			"page" 		=> "view_deck",
			"menu" 		=> true,
			"name" 		=> "Deck",
			"style" 	=> ""
		),
		
		"404" => array(
			"title" 	=> "404 Error",
			"page" 		=> "404",
			"name" 		=> "Error 404, page does not exist",
			"style" 	=> ""
		)
	);
}