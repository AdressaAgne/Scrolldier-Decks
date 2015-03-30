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
					<label for="text">Cover Image</label>
					
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
				<div class="form-element">
					<label for="text">Tags <small>comma separeted(,)</small></label>
					<input id="text" type="text" class="typeahead" name="" value="" placeholder="Write a tag" />
					<input type="hidden" id="hidden_tags" name="tags" value="" />
				</div>
				
				<div class="form-element">
					<span id="tags"></span>
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
				$("#tags").append("<span class='tag' style='margin: 5px; display: inline-block;'>"+$(this).val().replace(/,/,'')+"</span>");
				$(this).val("");
			}
			update()
		});
		
		$("#text").keydown(function(e) {
			
			if ((e.keyCode == 8) && ($("#text").val() == "")) {
				tags.pop();
				$("#tags").html("");
				for (var i = 0; i < tags.length; i++) {
					$("#tags").append("<span class='tag' style='margin: 5px; display: inline-block;'>"+tags[i]+"</span>");
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