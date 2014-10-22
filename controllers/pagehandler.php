<?php 
//declaring page structures

class Base {
	public $pagestructure = array(
		"/" => array( 						//url extension
			"title" 	=> "Scrolldier",	//title
			"page" 		=> "main", 			//file name without .php
			"menu" 		=> true, 			//if its included in the menu or not
			"name" 		=> "Home", 			//name of the page
			"style" 	=> "" 				//additional styles
		),
	
		"/decks" => array(
			"title" 	=> "Scrolldier - Decks",
			"page" 		=> "deck",
			"menu" 		=> true,
			"name" 		=> "View Decks",
			"style" 	=> ""
		),
		
		"/deck" => array(
			"title" 	=> "Scrolldier - Deck",
			"page" 		=> "view_deck",
			"menu" 		=> false,
			"name" 		=> "Deck",
			"style" 	=> ""
		),
		
		"/guide" => array(
			"title" 	=> "Scrolldier - Deck guides",
			"page" 		=> "guide",
			"menu" 		=> true,
			"name" 		=> "Deck Guides",
			"style" 	=> ""
		),
		
		"/new" => array(
			"title" 	=> "Scrolldier - Deckbuilder",
			"page" 		=> "deckbuilder",
			"menu" 		=> true,
			"name" 		=> "New Deck",
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