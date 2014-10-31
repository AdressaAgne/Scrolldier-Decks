

<div class="container">
	<div class="page-header">
		<h2>Top Decks for 0.133.0</h2>
	</div>
	<div class="col-12">
		
		<?php 
			
			$query = $deck->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND competative = 1
								   ORDER BY meta DESC, vote DESC,
								   time DESC LIMIT 6");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			$deckData = $deck->get_deck_data($row['id']);
		 ?>
		
			<div class="col-4 col-t-6" >
			<a href="/deck/<?php echo($row['id']) ?>">
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
	
	<div class="page-header">
		<h2>News &amp; Spoilers</h2>
	</div>
	<div class="col-12 news">
		<div class="col-8 col-offset-2 col-t-10 col-t-offset-1">
			<div class="col-12">
				<h3><a href="#">The New Scrolldier Design up and running</a><br />
					<small>By: Orangee, 27. October, 2014</small>
				</h3>
			</div>
			<div class="col-12">
				<img src="img/backgrounds/cover-1.jpg" alt="" />
			</div>
			<p class="col-12">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis, consequatur, ut, nesciunt obcaecati inventore odio tempora rerum at ipsa necessitatibus nihil impedit voluptatibus. Qui, maxime, fuga, esse, modi quo ullam provident officiis consequuntur libero nulla aut suscipit corporis rem numquam et distinctio unde laborum. Beatae quia atque a culpa animi!
			</p>
			<p class="col-12">Aliquam, et, est, recusandae, obcaecati nulla nesciunt commodi eius nostrum hic sequi dolore incidunt odio ut iure dignissimos eligendi corporis sunt nihil optio labore minus omnis suscipit debitis minima assumenda laboriosam asperiores facilis rerum unde provident laudantium cumque aperiam voluptas. Optio, totam nobis consectetur corrupti pariatur hic ex! Cum, dignissimos.
			</p>
			
			
			
			<p class="col-12"><a href="#" class="btn ">Write a comment</a></p>
		</div>
		
		<div class="post-devider"></div>
		
		<div class="col-8 col-offset-2 col-t-10 col-t-offset-1">
			<div class="col-12">
				<h3><a href="#">New Desing comming soon</a><br />
					<small>By: Orangee, 27. October, 2014</small>
				</h3>
			</div>
			<div class="col-12">
				<img src="img/backgrounds/cover-3.jpg" alt="" />
			</div>
			<p class="col-12">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis, consequatur, ut, nesciunt obcaecati inventore odio tempora rerum at ipsa necessitatibus nihil impedit voluptatibus. Qui, maxime, fuga, esse, modi quo ullam provident officiis consequuntur libero nulla aut suscipit corporis rem numquam et distinctio unde laborum. Beatae quia atque a culpa animi!
			</p>
			<p class="col-12">Aliquam, et, est, recusandae, obcaecati nulla nesciunt commodi eius nostrum hic sequi dolore incidunt odio ut iure dignissimos eligendi corporis sunt nihil optio labore minus omnis suscipit debitis minima assumenda laboriosam asperiores facilis rerum unde provident laudantium cumque aperiam voluptas. Optio, totam nobis consectetur corrupti pariatur hic ex! Cum, dignissimos.
			</p>
			
			
			
			<p class="col-12"><a href="#" class="btn ">Write a comment</a></p>
		</div>
		
		<div class="post-devider"></div>
		
	</div>
	
	
</div>