

<div class="container">
	<div class="page-header">
		<h2>Top Decks for 0.133.0</h2>
	</div>
	<div class="row">
		
		<?php 
			
			$query = $deck->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND competative = 1
								   ORDER BY meta DESC, vote DESC,
								   time DESC LIMIT 6");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			$deckData = $deck->get_deck_data($row['id']);
		 ?>
		
			<div class="col-4 col-tab-6" >
			<a href="/deck/<?php echo($row['id']) ?>">
				<div class="deck-thumbnail">
					<div class="deck-header" style="background-image: url(img/decks/small-<?=$deckData->image ?>);">
						
						<?php 
							foreach ($deckData->resources as $resource => $count) {
								echo '<i class="icon-gold-'.$resource.'"></i>';
							}
						?>
					</div>
					<div class="deck-bar">
						<?php foreach ($deckData->percentage as $faction => $percentage) {
							echo '<div class="bar bar-'.$faction.'" style="width: '.$percentage.'%;"></div>';
						} ?>
					</div>
					<div class="deck-content" >
						<h3><?=substr($row['deck_title'],0,30) ?></h3>
						<small><?='By: '.$deckData->author." - ".$deckData->time ?></small>
						<ul class="scroll-content">
							<li><?=$deckData->kinds['CREATURE'] ?> Creatures</li>
							<li><?=$deckData->kinds['ENCHANTMENT'] ?> Enchantments</li>
							<li><?=$deckData->kinds['STRUCTURE'] ?> Structures</li>
							<li><?=$deckData->kinds['SPELL'] ?> Spells</li>
						</ul>
						<ul class="scroll-content">
							<li></li>
							<li><?=($deckData->vote_up - $deckData->vote_down) ?> Stars</li>
						</ul>
					</div>
				</div>
			</a>
				
			</div>
			
		<?php } ?>
	</div>
	
	
	
	
	
	<div class="row news">
		<div class="page-header">
			<h2>News &amp; Spoilers</h2>
		</div>
		<?php 
			
			$query = $deck->_db->prepare("SELECT * FROM scrolls ORDER BY time DESC LIMIT 10");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>
		<div class="col-8 col-offset-2 col-tab-10 col-tab-offset-1">
			<div class="col-12">
				<h3><a href="/post/<?=$row['id']?>"><?=$row['header']?></a><br />
					<small>By: <?=$row['byName']?>, <?=$row['time']?></small>
				</h3>
			</div>
			<div class="col-12 news-front">
				<?=$row['html']?>
			</div>
			
			
			<p class="col-12"><a href="/post/<?=$row['id']?>" class="btn ">Read More</a></p>
		</div>
		
		<div class="post-devider"></div>
		
		<?php } ?>
	
</div>
</div>