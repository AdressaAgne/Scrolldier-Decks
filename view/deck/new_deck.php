<div class="container">
	<div class="page-header">
		<h2>New Deck</h2>
	</div>
	
	
	<div class="row">
	
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
					<label for="text">Cover Image <small>if no cover image is selected a random image will be choosen</small></label>
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
					<label>
						<input type="checkbox" name="" value="" /> Make Deck Hidden
					</label>
					
				</div>
				<div class="form-element">
					<label>
						<input type="checkbox" name="" value="" /> Deck is Made for Competitive play
					</label>
					
				</div>
			</div>
			<div class="col-6">
				<div class="form-element" id="preset">
					<label>Preset Tags <small>Click a tag to select it</small></label>
					<div class="col-12">
						<span class="tag small hand" id="preset-tag" data-type="Aggro">Aggro</span>
						<span class="tag small hand" id="preset-tag" data-type="Late Game">Late Game</span>
						<span class="tag small hand" id="preset-tag" data-type="Control">Control</span>
						<span class="tag small hand" id="preset-tag" data-type="Combo">Combo</span>
						<span class="tag small hand" id="preset-tag" data-type="Tempo">Tempo</span>
						<span class="tag small hand" id="preset-tag" data-type="Counter">Counter</span>
						<span class="tag small hand" id="preset-tag" data-type="Ramp">Ramp</span>
						<span class="tag small hand" id="preset-tag" data-type="Synergy">Synergy</span>
						<span class="tag small hand" id="preset-tag" data-type="Judgement">Judgement</span>
					</div>
				</div>
				<div class="form-element">
					<label for="text">Tags <small>comma separeted(,)</small></label>
					<input id="text" type="text" class="typeahead" name="" value="" placeholder="Write a tag" />
					<input type="hidden" id="hidden_tags" name="tags" value="" />
					<input type="hidden" name="cover_image" id="cover_image" value="" />
				</div>
				
				<div class="form-element">
					<div class="col-12" id="tags"></div>
				</div>
			</div>
		</div>
	
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
		
		
		
		
		$("img[class*=col-3]").click(function() {
			$("img[class*=col-3]").removeClass("active");
			$(this).addClass("active");
			
			$("#cover_image").val($(this).attr("alt"));
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