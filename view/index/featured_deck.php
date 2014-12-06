	<?php 
		//834
		$deckData = $deck->get_deck_data(5);
		
		if ($deckData !== FALSE) {
	 ?>
	<div class="page-header">
		<h2>Featured Deck</h2>
	</div>
	
	
	<div class="col-12">
		
		<div class="col-4 col-t-12">
			<a href="/deck/<?=$deckData->id ?>">
				<div class="deck-thumbnail">
					<div class="deck-header" style="background-image: url(img/decks/<?=$deckData->image ?>);">
						
						<?php 
							foreach ($deckData->resources as $resource => $count) {
								echo '<i class="icon-gold-'.$resource.'"></i>';
							}
						?>
					</div>
					<div class="deck-bar">
						<?php foreach ($deckData->percentage as $faction => $percentage) {
							echo('<div class="bar bar-'.$faction.'" style="width: '.$percentage.'%;"></div>');
						} ?>
					</div>
					<div class="deck-content" >
						<ul class="scroll-content-featured">
							<li><?=$deckData->kinds['CREATURE'] ?> Creatures</li>
							<li><?=$deckData->kinds['ENCHANTMENT'] ?> Enchantments</li>
							<li><?=$deckData->kinds['STRUCTURE'] ?> Structures</li>
							<li><?=$deckData->kinds['SPELL'] ?> Spells</li>
						</ul>
					</div>
				</div>
			</a>
			<div class="col-12">
				<div class="col-12 deck-scrolls">
					<?php 	
						foreach ($deckData->scrolls as $scroll) { ?>
							
							<div class="col-12 scroll-front" data-id="<?=$scroll->id ?>" data-count="<?=$scroll->count ?>">
								 <div class=" scroll scroll-stack-<?=$scroll->count ?>" style="background-image: url('/img/scrolls/<?=$scroll->image ?>.png');">
									
									<div class="col-12 text">
										<i class="icon-<?=$scroll->faction ?> front-text"></i>
										x<?=$scroll->count ?> <?=$scroll->name ?>
									</div>
								</div>
								
							</div>
							
						<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="col-8 col-t-12">
			<h3><?=substr($deckData->name,0,30) ?> <small>By: <?=$deckData->author ?> - <?=$deckData->time ?></small></h3>
			<p class="col-12 col-t-10 col-t-offset-1">
				<?=$deckData->text ?>
			</p>

			<p class="col-12  col-t-offset-1"><a href="deck/<?=$deckData->id ?>" class="btn ">Read More</a></p>
		</div>

</div>
	<?php } ?>	