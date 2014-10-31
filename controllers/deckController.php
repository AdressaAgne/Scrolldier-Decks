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
	
	/**
	 * Retrieves the faction of a scroll
	 * @param array $scroll
	 * @return string Returns the faction of the scroll
	 */
	function getFaction($scroll)
	{
		if ($scroll['costgrowth'] > 0)
		{
			return 'growth';
		}
		elseif ($scroll['costorder'] > 0)
		{
			return 'order';
		}
		elseif ($scroll['costenergy'] > 0)
		{
			return 'energy';
		}
		elseif ($scroll['costdecay'] > 0)
		{
			return 'decay';
		}
	}
	
	/**
	 * Gets the cost of the scroll stack
	 * @param Scroll $scroll
	 * @return int The total price of the stack
	 */
	function getStackCost($scroll)
	{
		$cost = 100;
		if ($scroll->rarity == 1)
		{
			$cost = 500;
		}
		elseif ($scroll->rarity == 2)
		{
			$cost = 1000;
		}
		return $cost * $scroll->count;
	}
	
	
	/**
	 * Retrieves a deck
	 * @param int $id The ID of the deck to retrieve
	 * @return DeckData|boolean Returns a deck if the specified ID exists, FALSE otherwise
	 */
	public function get_deck_data($id)
	{
		// Get deck from database
		$query = $this->_db->prepare("SELECT * FROM decks WHERE id = :id");
		$arr = array(
		    'id' => $id
		);
		$this->arrayBinderInt($query, $arr);
		$query->execute();	
		$data = $query->fetch(PDO::FETCH_ASSOC);
		
		// Check deck exists
		if (empty($data))
		{
			return FALSE;
		}
		
		$json = json_decode($data['JSON'], TRUE);
		
		// Set metadata
		$deck_data = new DeckData();
		$deck_data->id           = $id;
		$deck_data->name         = $data['deck_title'];
		$deck_data->author       = $data['deck_author'];
		$deck_data->text         = $data['text'];
		$deck_data->meta_version = $data['meta'];
		$deck_data->time         = $this->ago($data['time']) . ' ago';
		$deck_data->vote_up      = $data['vote'];
		$deck_data->vote_down    = $data['vote_down'];
		
		// Parse scroll IDs
		$scroll_ids = [];
		$scrolls_count = [];
		foreach ($json['data']['scrolls'] as $scroll)
		{
			$scroll_ids[] = $scroll['id'];
			$scrolls_count[$scroll['id']] = $scroll['c'];
		}
		
		// Retrieve scrolls
		$prepare = implode(',', array_fill(0, count($scroll_ids), '?'));
		$query = $this->_db->prepare("SELECT * FROM scrollsCard WHERE id IN ($prepare)");
		$query->execute($scroll_ids);
		
		// Populate deck with scrolls
		$scrolls_data = $query->fetchAll();
		$total = 0;
		foreach ($scrolls_data as $scroll_data)
		{
			$scroll          = new Scroll();
			$scroll->id      = $scroll_data['id'];
			$scroll->name    = $scroll_data['name'];
			$scroll->count   = $scrolls_count[$scroll->id];
			$scroll->rarity  = $scroll_data['rarity'];
			$scroll->faction = $this->getFaction($scroll_data);
			$scroll->image   = $scroll_data['image'];
			
			$faction = $scroll->faction;
			$cost = $scroll_data["cost$faction"];
			$kind = $scroll_data['kind'];
			
			$deck_data->scrolls[]     = $scroll;
			$deck_data->scroll_count += $scroll->count;
			$deck_data->total_cost   += $this->getStackCost($scroll);
			
			$deck_data->addKind($kind, $scroll->count);
			$deck_data->addRarity($scroll->rarity, $scroll->count);
			$deck_data->addResource($faction, $scroll->count);
			
			$types = explode(',',$scroll_data['types']);
			foreach ($types as $type)
			{
				if ($type === '')
				{
					$type = 'None';
				}
				$deck_data->addType($type, $scroll->count);
			}
			
			$deck_data->addCurve($faction, 'all', $cost, $scroll->count);
			$deck_data->addCurve($faction, $kind, $cost, $scroll->count);
			
			$total += $scroll->count;
		}
		
		// Sort deck fields
		ksort($deck_data->curve);
		arsort($deck_data->types);
		
		// Calculate faction percentage
		foreach ($deck_data->resources as $faction => $count)
		{
			if ($count > 0)
			{
				$deck_data->percentage[$faction] = $count * 100 / $total;
			}
		}
		
		// Set image from most used faction
		arsort($deck_data->percentage);
		$most_used = array_keys($deck_data->percentage);
		$rand      = rand(1,4);
		
		$deck_data->image = $most_used[0] . "-$rand.jpg";
		
		return $deck_data;
	}
	
	
}

/**
 * A deck containing multiple scrolls
 */
class DeckData
{
	/**
	 * The deck ID number
	 * @var int
	 */
	public $id = 0;
	/**
	 * The name of the deck
	 * @var string
	 */
	public $name = '';
	/**
	 * Author of the deck
	 * @var string
	 */
	public $author = '';
	/**
	 * Description of the deck
	 * @var string 
	 */
	public $text = '';
	/**
	 * The meta version of the deck
	 * @var string
	 */
	public $meta_version = '';
	/**
	 * The filename of the cover image.<br>
	 * Determined by most used faction and a random integer between 1 and 4.
	 * @var string
	 */
	public $image = '';
	/**
	 * Creation time of the deck in human readable format
	 * @var string
	 */
	public $time = '';
	/**
	 * Faction usage in percentages
	 * @var int[] 
	 */
	public $percentage = [];
	
	/**
	 * The amount of scrolls in the deck
	 * @var int
	 */
	public $scroll_count = 0;
	/**
	 * The total cost of the deck
	 * @var int
	 */
	public $total_cost = 0;
	/**
	 * The number of upvotes
	 * @var int
	 */
	public $vote_up = 0;
	/**
	 * The number of downvotes
	 * @var int
	 */
	public $vote_down = 0;
	
	/**
	 * The amount of each kind<br>
	 * Possible kinds: CREATURE, ENCHANTMENT, SPELL, STRUCTURE
	 * @var int[]
	 */
	public $kinds = array(
	    'CREATURE'    => 0,
	    'ENCHANTMENT' => 0,
	    'SPELL'       => 0,
	    'STRUCTURE'   => 0
	);
	/**
	 * The amount of each type<br>
	 * Examples: None, Artillery, Automation, Destruction, Human, Masked
	 * @var int[]
	 */
	public $types = [];
	/**
	 * The amount of each rarity
	 * @var int[] 
	 */
	public $rarities = array(
	    0 => 0,
	    1 => 0,
	    2 => 0
	);
	/**
	 * The amount of each resource
	 * @var int[]
	 */
	public $resources = [];
	/**
	 * The curve for each faction
	 * @var array[]
	 */
	public $curve = array(
	    'growth' => [],
	    'order'  => [],
	    'energy' => [],
	    'decay'  => []
	);
	
	/**
	 * An array of scrolls
	 * @var Scroll[]
	 */
	public $scrolls = [];
	
	/**
	 * 
	 * @param string $type
	 * @param int $count
	 */
	public function addType($type, $count)
	{
		if( ! isset($this->types[$type]) )
		{
			$this->types[$type] = 0;
		}
		$this->types[$type] += $count;
	}
	
	/**
	 * 
	 * @param string $kind
	 * @param int $count
	 */
	public function addKind($kind, $count)
	{
		if( ! isset($this->kinds[$kind]) )
		{
			$this->kinds[$kind] = 0;
		}
		$this->kinds[$kind] += $count;
	}
	
	/**
	 * 
	 * @param string $rarity
	 * @param int $count
	 */
	public function addRarity($rarity, $count)
	{
		if( ! isset($this->rarities[$rarity]) )
		{
			$this->rarities[$rarity] = 0;
		}
		$this->rarities[$rarity] += $count;
	}
	
	/**
	 * 
	 * @param string $resource
	 * @param int $count
	 */
	public function addResource($resource, $count)
	{
		if( ! isset($this->resources[$resource]) )
		{
			$this->resources[$resource] = 0;
		}
		$this->resources[$resource] += $count;
	}
	
	/**
	 * Make sure the curve for a kind is available to increment
	 * @param string $faction
	 * @param string $kind
	 */
	public function initCurve($faction, $kind)
	{
		if (isset($this->curve[$faction][$kind]))
		{
			return;
		}
		for ($i=1; $i < 10; $i++)
		{
			$this->curve[$faction][$kind][$i] = 0;
		}
	}
	
	/**
	 * 
	 * @param string $faction
	 * @param string $kind
	 * @param int $cost
	 * @param int $count
	 */
	public function addCurve($faction, $kind, $cost, $count)
	{
		$this->initCurve($faction, $kind);
		$this->curve[$faction][$kind][$cost] += $count;
	}
	
	/**
	 * Supresses warnings about non-object<br>
	 * Unsure why this only happens with view-deck.php
	 */
	public function supressWarnings() {}
}

/**
 * Scroll with extra metadata
 */
class Scroll
{
	/**
	 * The ID of the scroll
	 * @var int
	 */
	public $id = 0;
	/**
	 * The name of the scroll
	 * @var string
	 */
	public $name = '';
	/**
	 * The amount of times the scroll appears in a deck
	 * @var id
	 */
	public $count = 0;
	/**
	 * The rarity level of the scroll.<br>
	 * 0:  100g<br>
	 * 1:  500g<br>
	 * 2: 1000g
	 * @var int
	 */
	public $rarity = 0;
	/**
	 * The faction name of the scroll
	 * @var string
	 */
	public $faction = '';
	/**
	 * The image name
	 * @var string 
	 */
	public $image = '';
}

