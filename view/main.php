
<div class="container clearfix">
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
				<div class="deck-thumbnail <?= $deckData->faction ?>">
					<div class="deck-bar">
						<?php foreach ($deckData->percentage as $faction => $percentage) {
							echo '<div class="bar bar-'.$faction.'" style="width: '.$percentage.'%;"></div>';
						} ?>
					</div>
					<div class="deck-header" style="background-image: url(img/decks/small-<?=$deckData->image ?>);">
						<span><?php 
							foreach ($deckData->resources as $resource => $count) {
								echo '<i class="icon-gold-'.$resource.'"></i>';
							}
						?></span>
						<span class="right"><?=($deckData->vote_up - $deckData->vote_down) ?></span>
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

					</div>
				</div>
			</a>
				
			</div>
			
		<?php } ?>
	</div>
</div>	

	
<div class="container">	
	
	<div class="row news">
		<?php 
			
			$query = $deck->_db->prepare("SELECT * FROM scrolls WHERE isHidden = 0 ORDER BY time DESC LIMIT 10");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>
		<div class="col-8 col-offset-2 col-tab-10 col-tab-offset-1">
			<div class="col-12 align-center">
				<h2 class=""><a href="/post/<?=$row['id']?>"><?=$row['header']?></a><br />
					<small>By: <?=$row['byName']?>, <?=$row['time']?></small>
				</h2>
			</div>
			<div class="col-12 news-front">
				<?php 
					$html_text = $formating->removeText('<p>&nbsp;</p>', $row['html']);
					$html_text = $formating->removeText('<p dir="ltr">&nbsp;</p>', $html_text);
					$html_text = $formating->surroundText('(<img src="(.*)">)', '<div class="image">$1</div>', $html_text);
				 ?>
				<?=$html_text?>
			</div>
			
			
			<p class="col-12"><a href="/post/<?=$row['id']?>" class="btn ">Read More</a></p>
		</div>
		
		<div class="post-devider"></div>
		<?php } ?>
	</div>
</div>