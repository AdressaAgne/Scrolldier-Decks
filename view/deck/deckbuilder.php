<style>
	.library-scrolls{
		height: 400px;
		overflow: scroll;
	}
</style>
<div class="container">
	<div class="page-header">
		<h2 id="test">Deck Builder</h2>
	</div>
	<div class="col-12">
		<div class="col-4">
			<div class="form-element">
				<input type="text" name="" value="" placeholder="Search Does not work" />
			</div>
		</div>
		<div class="col-4">
			<div class="form-element">
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
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
	
		<div class="col-2">
			<img id="previewImage" src="http://a.scrollsguide.com/image/screen?name=Blessing of Haste&size=large" alt="" />
			<!--<div class="col-12 align-center">
				<h2><i class="icon-growth"></i>Scrolls name <br /><small>Spell: Countdown</small></h2>
			</div>
			<div class="col-12 deck-scrolls">
				 <div class="scroll" style="background-image: url('/img/scrolls/490.png');"></div>
			</div>
			<div class="col-12">
				ap: 3, cd:4 ,hp: 4 
			</div>
			<div class="col-12">
				Description
			</div>
			<div class="col-12 align-center">
				<i>Falvor</i>
			</div>-->
		</div>
		
		<div class="col-8 deck-scrolls" id="deck-scrolls"></div>
	
		<div class="col-2 deck-scrolls library-scrolls">
				<?php
				$query = $deck->_db->prepare("SELECT * FROM scrollsCard ORDER BY costGrowth DESC, costEnergy DESC, costDecay DESC, costOrder DESC");
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
					$cost = 0;
					$faction = "";
					
					if (!empty($row['costorder'])) {
							
						$cost = $row['costorder'];
						$faction = "order";
						
					}
					if (!empty($row['costgrowth'])) {
					
						$cost = $row['costgrowth'];	
						$faction = "growth";
						
					}
					if (!empty($row['costenergy'])) {
					
						$cost = $row['costenergy'];
						$faction = "energy";
					
					}
					if (!empty($row['costdecay'])) {
					
						$cost = $row['costdecay'];
						$faction = "decay";
					}
				
				?>
				<div class="col-12 scroll-front hand" id="addScrollScroll"
					 data-faction="<?= $faction ?>"
					 data-name="<?=$row['name']?>"
					 data-id="<?=$row['id']?>"
					 data-image="<?=$row['image']?>">
					 <div class=" scroll" style="background-image: url('/img/scrolls/<?=$row['image']?>.png');">
						
						<div class="col-12 text">
							<?=$cost ?> <i class="icon-<?= $faction ?> front-text"></i><?=$row['name'] ?>
						</div>
					</div>
					
				</div>
				<?php } ?>
		</div>
	</div>
</div>

<script src="/js/min/deckbuilder-min.js"></script>