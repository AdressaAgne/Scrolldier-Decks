<?php 

	//cover_image, tags, name(title), json_string, competetive, isHidden
	if (isset($_POST['submit'])) {
		if (!empty($_POST['json_string']) && !empty($_POST['name'])) {
			$isHidden = isset($_POST['isHidden']) ? 1 : 0;
			$comp = isset($_POST['competetive']) ? 1 : 0;
			$guide = isset($_POST['guide']) ? 1 : 0;
		
			if ($deck_id_or_error = $deck->insertDeck($comp, $isHidden, $_POST['json_string'], $_POST['name'], $_POST['tags'], $_POST['cover_image'], $guide)) {
				$_GET['success'] = "Deck successfully added. View it <a href='/deck/".$deck_id_or_error."'>Here</a>";
			} else {
				$_GET['error'] = "An error occurred while submitting your deck: ".$deck_id_or_error;
			}
		} else {
			$_GET['error'] = "Your deck must have a name and a JSON string";
		}
	}
 ?>
<div class="container">
	<div class="page-header">
		<h2>New Deck</h2>
	</div>
	
	
	<div class="row">
		<form method="post" action="">
		<div class="row">
			<div class="col-6 col-tab-12">
				<div class="form-element">
					<label for="json_string">Export String</label>
					<input id="json_string" type="text" name="json_string" value="" placeholder="JSON string" />
				</div>
			</div>
			<div class="col-6 col-tab-12">
				<div class="form-element">
					<label for="name">Deck Name</label>
					<input id="name" type="text" name="name" value="" placeholder="Deck Name" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="form-element">
					<label for="text">Cover Image <small>if no cover image is selected a random image will be chosen</small></label>
					<div class="col-12">
						<img src="img/decks/small-decay-1.jpg" alt="decay-1.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-decay-2.jpg" alt="decay-2.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-decay-3.jpg" alt="decay-3.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-decay-4.jpg" alt="decay-4.jpg" class="col-3 clickable"/>
						
						<img src="img/decks/small-energy-1.jpg" alt="energy-1.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-energy-2.jpg" alt="energy-2.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-energy-3.jpg" alt="energy-3.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-energy-4.jpg" alt="energy-4.jpg" class="col-3 clickable"/>
						
						<img src="img/decks/small-growth-1.jpg" alt="growth-1.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-growth-2.jpg" alt="growth-2.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-growth-3.jpg" alt="growth-3.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-growth-4.jpg" alt="growth-4.jpg" class="col-3 clickable"/>
						
						<img src="img/decks/small-order-1.jpg" alt="order-1.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-order-2.jpg" alt="order-2.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-order-3.jpg" alt="order-3.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-order-4.jpg" alt="order-4.jpg" class="col-3 clickable"/>
						
						<img src="img/decks/small-nutural-1.jpg" alt="nutural-1.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-nutural-2.jpg" alt="nutural-2.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-nutural-3.jpg" alt="nutural-3.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-nutural-4.jpg" alt="nutural-4.jpg" class="col-3 clickable"/>
						<img src="img/decks/small-nutural-5.jpg" alt="nutural-5.jpg" class="col-3 clickable"/>
					</div>
				</div>
					
				<div class="form-element">
					<label class="hand">
						<input type="checkbox" name="isHidden" value="" /> Make Deck Hidden
					</label>
				</div>
				<div class="form-element">
					<label class="hand">
						<input type="checkbox" name="competetive" value="" /> Deck is Made for Competitive play
					</label>
				</div>
				<div class="form-element">
					<label class="hand">
						<input type="checkbox" name="guide" value="" /> Deck Guide <small>deck must have a Description with the guide</small>
					</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-element" id="preset">
					<label>Preset Tags <small>Click a tag to select it</small></label>
					<div class="col-12">
						<span class="tag small hand" id="preset-tag" data-type="Aggro">Aggro
							<div class="tag-hover tag hidden">Aggro refers to a type of deck that focuses on winning the game as fast as possible. Those decks usually feature a broad selection of aggressive creatures and damage spells.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Late Game">Late Game
							<div class="tag-hover tag hidden">The deck is designed for the long game, with powerful and very costly creatures</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Control">Control
							<div class="tag-hover tag hidden">This is a deck archetype which centers more around taking control of the game, preventing the other player from doing what they want. These types of decks usually use their control effects to stall the game until they can finish with powerful late-game scrolls or combos.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Combo">Combo
							<div class="tag-hover tag hidden">This can refer to two or more scrolls that do something together. Sometimes it is used as a synonym for “synergy”, but it commonly refers to a certain, game-changing combination of scrolls. It may also refer to deck types that are built around combos.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Tempo">Tempo
							<div class="tag-hover tag hidden">Like most games, CCGs will typically have one player "driving" the interactions and one player "reacting" to those actions. Tempo is an extremely important advantage and usually defaults to whoever goes first. Creating a disparity between the rate at which you are casting scrolls with increased quality and your opponent's ability to do the same. Whoever is in control of the Tempo of the match controls the game.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Counter">Counter
							<div class="tag-hover tag hidden">A deck constructed to counter a specific deck. These decks often utilise scrolls or mechanics which are usually not that viable, but are especially effective against the deck they mean to counter.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Ramp">Ramp
							<div class="tag-hover tag hidden">Permanently increasing your resources, aside from sacrificing a scroll. For example, playing Imperial Resources increases your Order resources by 1.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Synergy">Synergy
							<div class="tag-hover tag hidden"> Scrolls that go well together and should be used together as much as possible are referred to as having synergy. Game-changing synergy effects are usually referred to as a combo.</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Judgement">Judgement
							<div class="tag-hover tag hidden">A Judgment deck created with the in-game draft</div>
						</span>
						<span class="tag small hand" id="preset-tag" data-type="Other">Other
							<div class="tag-hover tag hidden">Other type of deck</div>
						</span>
					</div>
				</div>
				<div class="form-element">
					<label for="text">Tags <small>comma separeted(,), Backspace to remove last tag</small></label>
					<input id="text" type="text" class="typeahead" name="" value="" placeholder="Write a tag" />
					<input type="hidden" id="hidden_tags" name="tags" value="" />
					<input type="hidden" name="cover_image" id="cover_image" value="" />
				</div>
				
				<div class="form-element">
					<div class="col-12" id="tags"></div>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="form-element align-center">
				<button type="submit" class="btn btn-big success" name="submit">Submit Deck</button>
			</div>
		</div>
	</form>
		
	</div>
	
</div>

<?php 

$arrayString = array();

$query = $deck->_db->prepare("SELECT name, id FROM scrollsCard");
$query->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	array_push($arrayString, $row['name']);
}


 ?>
<script>
	$(function() {
		var tags = [];
	
		$("#text").keyup(function(e) {
			if (($(this).val().slice(-1) == ",") && ($(this).val() != "" && $(this).val() != ",") || (e.keyCode == 13 && $(this).val() != "" && $(this).val() != ",")) {
				tags.push($(this).val().replace(/,/,''));
				$("#tags").append("<span class='tag small success'>"+$(this).val().replace(/,/,'')+"</span>");
				$(this).val("");
			}
			update()
		});
		$("#text").keydown(function(e) {
			
			if ((e.keyCode == 8) && ($("#text").val() == "")) {
				tags.pop();
				$("#tags").html("");
				for (var i = 0; i < tags.length; i++) {
					$("#tags").append("<span class='tag small success'>"+tags[i]+"</span>");
				}
				
			}
			update()
		});
		function update() {
			$("#hidden_tags").val("");
			for (var i = 0; i < tags.length; i++) {
				$("#hidden_tags").val($("#hidden_tags").val()+tags[i]+",");
			}
			
		}
		$("[id*=preset-tag]").click(function() {
			tags.push($(this).attr("data-type"));
			$("#text").val("");
			$("#tags").append("<span class='tag small success'>"+$(this).attr("data-type")+"</span>");
			update();
		});
		
		$("[id*=preset-tag]").hover(function() {
			$(this).find(".tag-hover").show();
		}, function() {
			$(this).find(".tag-hover").hide();
		})
		
		
		$("img[class*=col-3]").click(function() {
			if ($(this).hasClass("active")) {
				$("img[class*=col-3]").removeClass("active");
				$("#cover_image").val("");
			} else {
				$("img[class*=col-3]").removeClass("active");
				$(this).addClass("active");
				$("#cover_image").val($(this).attr("alt"));
			}
		});
		
	});
	
		$(function() {
			var substringMatcher = function(strs) {
			  return function findMatches(q, cb) {
			    var matches, substrRegex;
			 
			    // an array that will be populated with substring matches
			    matches = [];
			 
			    // regex used to determine if a string contains the substring `q`
			    substrRegex = new RegExp(q, 'i');
			 
			    // iterate through the pool of strings and for any string that
			    // contains the substring `q`, add it to the `matches` array
			    $.each(strs, function(i, str) {
			      if (substrRegex.test(str)) {
			        // the typeahead jQuery plugin expects suggestions to a
			        // JavaScript object, refer to typeahead docs for more info
			        matches.push({ value: str });
			      }
			    });
			 
			    cb(matches);
			  };
			};
			 
			var scrolls = <?php echo json_encode($arrayString) ?>;
			 
			$('#text').typeahead({
			  hint: false,
			  highlight: true,
			  minLength: 1
			},
			{
			  name: 'scrolls',
			  displayKey: 'value',
			  source: substringMatcher(scrolls)
			});
		});
</script>