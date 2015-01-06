<?php 

class ScrollController extends Database {

	public function getMostUsedScrolls($id) {
	
		$scroll = new MostUsedScrolls();
//		$query = $this->_db->prepare("SELECT json, id FROM decks WHERE json like %:id% ");
		$query = $this->_db->prepare("SELECT id, JSON FROM decks WHERE JSON LIKE '%\"id\":".$id.",%'");
//		$arr = array(
//		    'id' => $id
//		);
//		$this->arrayBinderInt($query, $arr);
		$query->execute();
		
		//{"msg":"success","data":{"scrolls":[{"id":135,"c":2},
		
		
		// Populate deck with scrolls
		$decks = $query->fetchAll();
		foreach ($decks as $deck_data) {
			$json = json_decode($deck_data['JSON'], TRUE);
			
			
			foreach ($json['data']['scrolls'] as $key => $value) {
				$scroll->scrolls[$value['id']] += $value['c'];
			}
		
			$scroll->total++;
		}
		
		unset($scroll->scrolls[$id]);
		arsort($scroll->scrolls);
		//$scroll->scrolls = array_keys($scroll->scrolls);
		$scroll->mostused = array_keys($scroll->scrolls, max($scroll->scrolls))[0];
		
		return $scroll;
	
	
	}
}

class MostUsedScrolls {
	
	public $mostused = 0;
	
	public $total = 0;
	
	public $scrolls = [];
	
	public $percentage = [];
	
}