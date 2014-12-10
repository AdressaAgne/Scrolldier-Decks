<div class="container">
	<div class="row">
		<div class="col-12">
			<form method="post" action="">
				<div class="row">
					<div class="col-5 col-tab-8">
						<div class="form-element">
							<label for="deck_name"><i class="fa fa-search"></i> Search <small>tags, deck name, author</small></label>
							<input id="deck_name" type="text" class="" name="deck_name" value="" placeholder="Search..."/>
						</div>
					</div>
					
					<div class="col-3 col-tab-4">
						<div class="form-element">
							<label>Ressources <small>1+</small></label>
							<div class="row align-center">
								<label class="icon">
									<input type="checkbox" name="faction" value="growth" /> <span><i class="icon-growth"></i></span>
								</label>
								<label class="icon">
									<input type="checkbox" name="faction" value="order" /> <span><i class="icon-order"></i></span>
								</label>
								<label class="icon">
									<input type="checkbox" name="faction" value="energy" /> <span><i class="icon-energy"></i></span>
								</label>
								<label class="icon">
									<input type="checkbox" name="faction" value="decay" /> <span><i class="icon-decay"></i></span>
								</label>
								<label class="icon">
									<input type="checkbox" name="faction" value="wild" /> <span><i class="icon-wild"></i></span>
								</label>
							</div>
						</div>
					</div>
					
					<div class="col-4 col-tab-6">
						<div class="form-element">
							<label for="contains_scroll">Contains Scroll <small>3+ chars for suggestion</small></label>
							<input id="contains_scroll" class="typeahead" type="text" name="contains_scroll" value="" placeholder="Scroll Name" />
						</div>
					</div>
					<div class="col-6 col-tab-6">
						<div class="form-element">
							<label>Server <small>Test or Live</small></label>
							<div class="row">
								<label>
									<input type="radio" name="server" checked value="" /> <span>Latest Live Server</span>
								</label>
								<label>
									<input type="radio" name="server" value="" /> <span>Lastest Test Server</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6 col-tab-12">
						<div class="form-element">
							<button class="btn"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row">
	<table class="even divider hover border">
		<thead class="">
			<tr class="">
				<td class=""><i class="fa fa-star"></i></td>
				<td class="">Title</td>
				<td class="">Scrolls</td>
				<td class="">Ressources</td>
				<td class=""><i class="fa fa-user"></i></td>
			</tr>
		</thead>
		
		
		
		<tbody id="table_content">
		<?php 	
			$query = $deck->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 ORDER BY meta desc, vote desc, time DESC LIMIT 30");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
		?>
	
		
			<tr class="">
				<td class=""><?= $row['vote'] ?></td>
				<td class=""><a href="/deck/<?= $row['id'] ?>" class=""><?= $row['deck_title'] ?></a></td>
				<td class=""><?= $row['scrolls'] ?></td>
				<td class="">
					<?php 
						if (!empty($row['tOrder'])) {
							echo("<i class='icon-order'></i> ");
						}
						if (!empty($row['growth'])) {
							echo("<i class='icon-growth'></i> ");
						}
						if (!empty($row['energy'])) {
							echo("<i class='icon-energy'></i> ");
						}
						if (!empty($row['decay'])) {
							echo("<i class='icon-decay'></i> ");
						}
						if (!empty($row['wild'])) {
							echo("<i class='icon-wild'></i>");
						}
					 ?>
				</td>
				<td class=""><?= $row['deck_author'] ?></td>
			</tr>
				
		<?php } ?>
		
		</tbody>
	</table>
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
		 
		$('#contains_scroll').typeahead({
		  hint: false,
		  highlight: true,
		  minLength: 3
		},
		{
		  name: 'scrolls',
		  displayKey: 'value',
		  source: substringMatcher(scrolls)
		});
	});
</script>