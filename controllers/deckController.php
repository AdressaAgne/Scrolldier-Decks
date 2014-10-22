<?php 
class Deck extends Database {
	
	public function totalDecks() {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks");
		
		try {
			$query->execute();
			return $query->rowCount();
			
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	public function get_decks($var) {
		
		
	
		
	}
	
	
}