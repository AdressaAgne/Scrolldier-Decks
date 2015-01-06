<?php 
	

	if (isset($_POST['scroll'])) {
		$name = preg_replace("/(.+) \\(id: (.+)\\)/ui", "$1", $_POST['scroll']);
		$id = preg_replace("/(.+) \\(id: (.+)\\)/ui", "$2", $_POST['scroll']);
		
		
		$scrollArray = $ScrollController->getMostUsedScrolls($id);
	}
	
	
 ?>
<div class="container">
	<div class="page-header">
		<h2>Most Used scrolls with X Scroll in decks on Scrolldier.com</h2>
	</div>
	<form method="post" action="">
		<div class="col-6 col-tab-6 col-offset-3">
			<div class="col-12">
				<div class="form-element">
					<label for="contains_scroll">Scroll Name <small>3+ chars for suggestion</small></label>
					<input id="contains_scroll" class="typeahead" type="text" name="scroll" value="" placeholder="Scroll Name" />
				</div>
			</div>
			<div class="col-12">
				<div class="form-element">
					<div class="col-12">
						<label>Show x Results</label>
					</div>
					<div class="col-3 align-center">
						<label><input type="radio" name="count" value="4" /> 4</label>
					</div>
					<div class="col-3 align-center">
						<label><input type="radio" name="count" checked value="8" /> 8</label>
					</div>
					<div class="col-3 align-center">	
						<label><input type="radio" name="count" value="12" /> 12</label>
					</div>
					<div class="col-3 align-center">	
						<label><input type="radio" name="count" value="16" /> 16</label>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="form-element align-center">
					<button type="submit" class="btn big" name="">Check Scroll</button>
				</div>
			</div>
		</div>
	</form>
	<?php if (isset($_POST['scroll'])) { ?>
	<div class="row">
		<h3>Scrolls Used with <?= $name ?></h3>
		
		<?php 
			if (isset($_POST['count'])) {
				$count = $_POST['count'];
			} else {
				$count = 4;
			}
			
			$i = 0;
			foreach ($scrollArray->scrolls as $key => $value) { ?>
				
				<div class="col-3">	
					<p class="align-center"><?= $i + 1 ?>. Used <?= $value ?> times</p>
					<img src="http://api.scrolldier.com/view/php/api/scrollimage.php?id=<?= $key ?>" alt="" />
				</div>
				
			<?php	if (++$i == $count) break;
			} 
		?>
	</div>
	<?php } ?>
</div>

<?php 

$arrayString = array();

$query = $deck->_db->prepare("SELECT name, id FROM scrollsCard");
$query->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	array_push($arrayString, $row['name']." (id: ".$row['id'].")");
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