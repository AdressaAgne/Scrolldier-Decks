<div class="container">
	<div class="row">
		<div class="col-12">
		<?php 
			function flavorReplace($searchText) {
				return preg_replace("/\\\\n/u", "<br />", $searchText);
			}
		//SELECT * FROM decks WHERE JSON LIKE '%\"id\":scrollsCard.id%' AND isHidden = 0 ORDER BY vote DESC LIMIT 5
	
		
			$query = $deck->_db->prepare("SELECT * FROM scrollsCard ORDER BY costdecay,costgrowth, costenergy, costorder, name");
			if ($query->execute()) {
				$row = 0;
				$max_row = 3;
				$faction = [
					"growth" => 0,
					"order" => 0,
					"energy" => 0,
					"decay" => 0
				];
				$delay = [];
				while ($scroll = $query->fetch(PDO::FETCH_ASSOC)) { 
				array_push($delay, $scroll);
				$row++;
				if ($faction[$deck->getFaction($scroll)] == 0) {
					?>
					<div class="row">
					<div class="page-header">
						<h2><i class="icon-<?= $deck->getFaction($scroll) ?> text"></i>  <?= ucfirst($deck->getFaction($scroll)) ?></h2>
					</div>
					</div>
					<?php
					$faction[$deck->getFaction($scroll)] = 1;
				}
				
				if ($row == 1) { echo("<div class='row'>"); }
				?>
				<div class="col-3 col-tab-6 col-phone-6 scroll-container hand" data-name="<?= $scroll['name'] ?>" data-id="<?= $scroll['id'] ?>">
					<div class="col-12 scroll-header" style="background-image: url('img/scrolls/<?= $scroll['image'] ?>.png');">
						<i class="number-<?= $deck->getFactionCost($scroll) ?>"></i><i class="icon-<?= $deck->getFaction($scroll) ?>"></i> 
					</div>
					<div class="col-12">
						<h4><?= $scroll['name'] ?> <br /><small><?= $scroll['kind'] ?>: <?= $scroll['types'] ?></small></h4>
					</div>
				</div>
			<?php
				if ($row > $max_row) {
					echo("</div>");
					$row = 0;
					
					for ($i = 0; $i < count($delay); $i++) {
						if ($delay[$i]['kind'] == "CREATURE" || $delay[$i]['kind'] == "STRUCTURE") {
							$stats = $delay[$i]['ap']."/".$delay[$i]['ac']."/".$delay[$i]['hp'];
						} else {
							$stats = "";
						}
					
						?>
						<div class="col-12" id="scroll-<?= $delay[$i]['id'] ?>"  hidden>
							<div class="col-5 align-center">
								<img src="img/scrolls/<?= $delay[$i]['image'] ?>.png" alt="" />
							</div>
							
							<div class="col-7">
								<div class="col-12">
								<h4>
									<i class="number-<?= $deck->getFactionCost($delay[$i]) ?> text"></i>
									<i class="icon-<?= $deck->getFaction($delay[$i]) ?> text"></i>
									<?= $delay[$i]['name']." ".$stats ?><small class="right">Set: <?= $delay[$i]['scrollsSet'] ?></small><br />
									<small><?= $delay[$i]['kind'] ?>: <?= $delay[$i]['types'] ?></small></h4>
								</div>
								<div class="col-12">
									<?php 
										if (!empty($delay[$i]['passiverules_1'])) {
											echo("<p><i>* ".$delay[$i]['passiverules_1']."</i></p>");
										}
										if (!empty($delay[$i]['passiverules_2'])) {
											echo("<p><i>* ".$delay[$i]['passiverules_2']."</i></p>");
										}
										if (!empty($delay[$i]['passiverules_3'])) {
											echo("<p><i>* ".$delay[$i]['passiverules_3']."</i></p>");
										}
									 ?>
									<p><?= $delay[$i]['description'] ?></p>
								</div>
								<?php if (!empty($delay[$i]['flavor'])) { ?>
									<div class="col-8 col-offset-2 tag align-center">
										<p><i><?= flavorReplace($delay[$i]['flavor']) ?></i></p>
									</div>
								<?php } ?>
							</div>
							
							<div class="col-12">
								<div class="col-12">
									<h4>Decks</h4>
									<?php 
									$decks = $deck->_db->prepare("SELECT id, deck_title, JSON, vote FROM decks WHERE JSON LIKE '%\"id\":".$delay[$i]['id']."%' AND isHidden = 0 ORDER BY vote DESC LIMIT 6");
										if ($decks->execute()) {
											while ($deckRow = $decks->fetch(PDO::FETCH_ASSOC)) {  ?>
													<div class="col-4">
														<p><?= $deckRow['vote'] ?> <i class="fa fa-star"></i> <a href="/deck/<?= $deckRow['id'] ?>" target="_blank"><?= $deckRow['deck_title'] ?></a></p>
													</div>
											<?php }
										}
									
									?>
								</div>
							</div>
							<div class="col-12">
								<p><a href="http://api.scrolldier.com/view/php/api/scrollimage.php?id=<?= $delay[$i]['id'] ?>"  target="_blank">Full Scroll</a></p>
							</div>
						</div>
						
						<?php
					}
					$delay = [];
				}
			
			   }
			}
			 ?>
		</div>
	</div>
</div>
<script>
$(function() {
	$(".scroll-container").click(function() {
		$("[id*=scroll-]").slideUp();
		
		if ($("#scroll-"+$(this).attr("data-id")).css("display") == "block") {
			$("#scroll-"+$(this).attr("data-id")).slideUp();
		} else {
			$("#scroll-"+$(this).attr("data-id")).slideDown();
		}
	});
});

</script>