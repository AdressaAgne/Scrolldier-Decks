<?php 
class Deck extends Database {
	
	private function ago($datetime, $full=false)
	{
	   	   $now = new DateTime;
	       $ago = new DateTime($datetime);
	       $diff = $now->diff($ago);
	   
	       $diff->w = floor($diff->d / 7);
	       $diff->d -= $diff->w * 7;
	   
	       $string = array(
	           'y' => 'year',
	           'm' => 'month',
	           'w' => 'week',
	           'd' => 'day',
	           'h' => 'hour',
	           'i' => 'minute',
	           's' => 'second',
	       );
	       foreach ($string as $k => &$v) {
	           if ($diff->$k) {
	               $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	           } else {
	               unset($string[$k]);
	           }
	       }
	   
	       if (!$full) $string = array_slice($string, 0, 1);
	       return $string ? implode(', ', $string) : 'just now';
	 }
	
	public function totalDecks() {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks");
		
		try {
			$query->execute();
			return $query->rowCount();
			
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	public function get_top_decks() {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND competative = 1 AND vote > 3
							   ORDER BY meta DESC, vote DESC,
							   time DESC LIMIT 6");
		
		try {
			$query->execute();
			return $query->fetch(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	
	public function get_deck_data($id) {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks WHERE id = :id");
		$query_arr = array(
				'id' => $id
			);
		$this->arrayBinderInt($query, $query_arr);	
		$query->execute();	
		$data = $query->fetch(PDO::FETCH_ASSOC);
		
		$deck_data = array(
			"name" => $data['deck_title'],
			"author" => $data['deck_author'],
			"meta" => $data['meta'],
			"scrolls" => 0,
			"id" => $data['id'],
			"time" => $this->ago($data['time'])." ago",
			"raw_time" => $data['time'],
			"vote_up" => $data['vote'],
			"vote_down" => $data['vote_down'],
			"scrolls" => "",
			"cost" => 0,
			"image" => "decay-1",
			"ressourses" => array(),
			"percentage" => array(),
			"types" => array(),
//			"traits" => array(),
			"subtype" => array(),
			"rarities" => array(
				0 => 0,
				1 => 0,
				2 => 0
			),
			"curve" => array(
			
			),
			"sets" => array(
				1 => 0,
				2 => 0,
				3 => 0,
				4 => 0,
				5 => 0,
				6 => 0,
				7 => 0
			),
			"attack" => array(),
			"countdown" => array(),
			"health" => array(),
			"scrolls_values" => array(),
			"text" => ""
		);
		
		
		//cost: Budget, Normal, Expensive
		
		$json = json_decode($data['JSON'], TRUE);
		
		if ($json['msg'] == "success") {
			for ($i = 0; $i < count($json['data']['scrolls']); $i++) {
				
				$scroll_id = $json['data']['scrolls'][$i]['id'];
				$scroll_count = $json['data']['scrolls'][$i]['c'];
				
				$query = $this->_db->prepare("SELECT * FROM scrollsCard WHERE id = :id");
				$arr = array(
						'id' => $scroll_id
					);
				
				$this->arrayBinderInt($query, $arr);
				$query->execute();		
				$scroll = $query->fetch(PDO::FETCH_ASSOC);
				
				
				
				$thisScrollFaction = "";
				
				if (!empty($scroll['costgrowth'])) {
					
				
					$deck_data['ressourses']["growth"] += $scroll_count;
					$deck_data['curve']['growth']['all'][$scroll['costgrowth']] += $scroll_count;
					
					$thisScrollFaction = "growth";
					ksort($deck_data['curve']['growth']['all']);
					
					$deck_data['curve']['growth'][$scroll['kind']][$scroll['costgrowth']] += $scroll_count;
				}
				if (!empty($scroll['costorder'])) {
					
				
					$deck_data['ressourses']["order"] += $scroll_count;
					$deck_data['curve']['order']['all'][$scroll['costorder']] += $scroll_count;
					$deck_data['curve']['order'][$scroll['kind']][$scroll['costorder']] += $scroll_count;
					
					$thisScrollFaction = "order";
					ksort($deck_data['curve']['order']['all']);
				}
				if (!empty($scroll['costenergy'])) {
					
				
					$deck_data['ressourses']["energy"]+= $scroll_count;
					$deck_data['curve']['energy']['all'][$scroll['costenergy']] += $scroll_count;
					
					$deck_data['curve']['energy'][$scroll['kind']][$scroll['costenergy']] += $scroll_count;
					$thisScrollFaction = "energy";
					ksort($deck_data['curve']['energy']['all']);
				}
				if (!empty($scroll['costdecay'])) {
					
					
				
					$deck_data['ressourses']["decay"]+= $scroll_count;
					$deck_data['curve']['decay']['all'][$scroll['costdecay']] += $scroll_count;
					
					$deck_data['curve']['decay'][$scroll['kind']][$scroll['costdecay']] += $scroll_count;
					$thisScrollFaction = "decay";
					ksort($deck_data['curve']['decay']['all']);
				}
				
				$deck_data['types'][$scroll['kind']] += $scroll_count;
				
				$thisScrolls = array(
					"id" => $scroll['id'],
					"name" => $scroll['name'],
					"count" => $scroll_count,
					"rarity" => $scroll['rarity'],
					"ressours" => $thisScrollFaction,
					"image" => $scroll['image']
				);
				
				array_push($deck_data['scrolls_values'], $thisScrolls);
				
				
				$deck_data['rarities'][$scroll['rarity']] += $scroll_count;
				
				if ($scroll['kind'] == "CREATURE" || $scroll['kind'] == "STRUCTURE") {
					$deck_data['attack'][$scroll['ap']] += $scroll_count;
					$deck_data['countdown'][$scroll['ac']] += $scroll_count;
					$deck_data['health'][$scroll['hp']] += $scroll_count;
				}
				
				ksort($deck_data['attack']);
				ksort($deck_data['countdown']);
				ksort($deck_data['health']);
				
				switch ($scroll['rarity']) {
					
					case 0:
						$deck_data['cost'] += 100 * $scroll_count;
					break;
					case 1:
						$deck_data['cost'] += 500 * $scroll_count;
					break;
					case 2:
						$deck_data['cost'] += 1000 * $scroll_count;
					break;
				}
				
				$deck_data['sets'][$scroll['scrollsSet']] += $scroll_count;

				$sub_types = explode(",", $scroll['types']);
				
				
				foreach ($sub_types as $key => $value) {
					if (empty($value)) {
						$deck_data['subtype']['none'] += $scroll_count;
					} else {
						$deck_data['subtype'][$value] += $scroll_count;
					}
				}
				
				arsort($deck_data['subtype']);
				
//				if (!empty($scroll['passiverules_1'])) {
//					$deck_data['traits'][$scroll['passiverules_1']] += $scroll_count;
//				}
//				if (!empty($scroll['passiverules_2'])) {
//					$deck_data['traits'][$scroll['passiverules_2']] += $scroll_count;
//				}
//				if (!empty($scroll['passiverules_3'])) {
//					$deck_data['traits'][$scroll['passiverules_3']] += $scroll_count;
//				}
				
				
			
				
				$deck_data['scrolls'] += $scroll_count;
			}
			
			$maxs = array_keys($deck_data['ressourses'], max($deck_data['ressourses']));
			
			$deck_data['image'] = $maxs[0]."-".rand(1, 4).".jpg";
			
			$total = 0;
			
			foreach ($deck_data['ressourses'] as $key => $value) {
				$total += $deck_data['ressourses'][$key];
			}
			
			foreach ($deck_data['ressourses'] as $key => $value) {
				$deck_data['percentage'][$key] = intval(($deck_data['ressourses'][$key] / $total) * 100);
			}
			
			foreach ($deck_data['curve'] as $faction => $value) {
			
				foreach ($deck_data['curve'][$faction] as $type => $type_valu) {
					for ($i = 1; $i < 10; $i++) {
						if (!isset($deck_data['curve'][$faction][$type][$i])) {
							$deck_data['curve'][$faction][$type][$i] = 0;
						}
					}
					
					ksort($deck_data['curve'][$faction][$type]);
				}
			}
			
			$deck_data['text'] = $data['text'];
			//$deck_data['sets'] = array_values($deck_data['sets']);
		} else {
			return "No Deck with this ID";
		}
		
		return $deck_data;
		
	}
	
	
}