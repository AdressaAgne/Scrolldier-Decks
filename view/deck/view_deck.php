<?php 

$data = $deck->get_deck_data($base->get_var(1));

@$data->supressWarnings();

?>
<style>

.deck-head-container{
	padding-bottom: 0px;
	padding-top: 100px;
	height: 555px;
	
	background:  url(/img/decks/<?=$data->image?>);
	background-repeat: no-repeat;
	background-size: cover;
}

.deckImage{
	overflow: hidden;
	height: 200px;
}


</style>

<!-- Deck as Image export Box-->	
	<div class="tag clearfix hidden" id="img_box">
		<div class="container">
			
			<div class="row" style="height: 200px;">
				<div class="form-element">
					<h2><i class="fa fa-image"></i> Save deck as Image <small class="right hand" id="close_imgbox"><i class="fa fa-times"></i></small></h2>
				</div>
				<p>Right click on the chosen image and save it</p>
				<div class="col-3 deckImage">
					<img src="http://api.scrolldier.com/view/php/api/bigdeckimage.php?id=<?=$base->get_var(1)?>&bg=bg1" alt="" />
				</div>
				<div class="col-3 deckImage">
					<img src="http://api.scrolldier.com/view/php/api/bigdeckimage.php?id=<?=$base->get_var(1)?>&bg=bg2" alt="" />
				</div>
				<div class="col-3 deckImage">
					<img src="http://api.scrolldier.com/view/php/api/bigdeckimage.php?id=<?=$base->get_var(1)?>&bg=bg3" alt="" />
				</div>
				<div class="col-3 deckImage">
					<img src="http://api.scrolldier.com/view/php/api/bigdeckimage.php?id=<?=$base->get_var(1)?>&bg=bg4" alt="" />
				</div>
			</div>
			
		</div>
	</div>
<!-- end  Deck as Image export Box-->

<!-- JSON export Box-->	
	<div class="tag clearfix hidden" id="json_box">
		<div class="container">
			<div class="form-element">
				<h2><i class="fa fa-share"></i> Export to JSON or text string <small class="right hand" id="close_imgbox"><i class="fa fa-times"></i></small></h2>
			</div>
			<div class="row">
				
				<div class="col-6">
					<p>JSON Output</p>
					<textarea class="col-12 well"  disabled="" rows="4"><?= $data->export ?></textarea>
				</div>
				<div class="col-6">
					<p>Text Output</p>
					<textarea class="col-12 well"  disabled="" rows="4"></textarea>
				</div>
			</div>
			
		</div>
	</div>
<!-- end JSON export Box-->

<div class="deck-bar">
	<?php
	foreach ($data->percentage as $faction => $percent) {
		echo '<div class="bar bar-'.$faction.'" style="width: '.$percent.'%;"></div>';
	}
	?>
</div>
<!--style="background-image: url(/img/decks/);"-->


<div class="deck-head-container" > 
	
	<div class="container">
		
		
		<div class="deck-head clearfix">
			<div class="row">
				<div class="col-12">
				<a class="btn <?= $data->faction ?>" id="jsonOutput"><i class="fa fa-share"></i> Export</a>
				<a class="btn <?= $data->faction ?>" id="imageOutput"><i class="fa fa-share"></i> Image</a>
			
				<a class="btn <?= $data->faction ?> right"><i class="fa fa-edit"></i> Edit</a>
				<a class="btn <?= $data->faction ?> right"><i class="fa fa-trash"></i> Delete</a>
				</div>
			</div>
			
			<div class="col-12">
				<div class="col-12">
					<div class="page-header" style="margin-top: -11px;">
						<h2>
						<?php
							foreach ($data->resources as $resource => $count) {
								echo '<i class="icon-gold-'.$resource.' front-text"></i>';
							}
						?>
						<?php echo(substr($data->name, 0, 60)) ?> <br />
							<small>Score: <?=($data->vote_up - $data->vote_down) ?> - by <?=$data->author ?> - <?=$data->time ?></small></h2>
					</div>
				</div>
			</div>
			
			
			<?php if (isset($_SESSION['ign'])) { ?>
			<div class="col-12 align-center">
				<button class="btn big success" id="vote_up"><i class="fa fa-thumbs-up"></i> Vote Up</button>
				<button class="btn big danger" id="vote_down"><i class="fa fa-thumbs-down"></i> Vote Down</button>
			</div>
			<?php } ?>
			
			
			<div class="row">
				<div class="row">
					<div class="col-12 deck-scrolls">
						<?php foreach ($data->scrolls as $scroll) { ?>
							<div class="col-2 col-phone-6 col-tab-3" data-id="<?=$scroll->id ?>" data-count="<?=$scroll->count ?>">
								<div class="col-12 scroll scroll-stack-<?=$scroll->count ?>" style="background-image: url('/img/scrolls/<?=$scroll->image ?>.png');">
									<i class="icon-<?=$scroll->faction ?>"></i>
								</div>
								<div class="col-12 scroll-content">
									x<?=$scroll->count ?> <?=$scroll->name ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-12 col-tab-12">
						
					<div class="page-header">
						<h3><i class="fa fa-bar-chart"></i> Statistics <small>General</small></h3>
					</div>	
		
					<div class="col-12">
					<div class="col-12">
		
					<?php 
						foreach ($data->curve as $faction => $kind) {
							foreach ($kind as $name => $cost) { ?>
								<label class="btn small">
									<input type="radio" name="curve" value="barChartData<?=$name ?>" data="<?=$name ?>" /> <?=ucfirst(strtolower($name)) ?>
								</label>
							<?php }
						} 
					?>
					</div>
		
						<div class="col-4 col-tab-12">
							<h4 class="list-stats">Curve</h4>
							<div class="curveContainer">
								<canvas id="curve-all"></canvas>
								<canvas id="curve-SPELL" style="display: none;"></canvas>
								<canvas id="curve-CREATURE" style="display: none;"></canvas>
								<canvas id="curve-STRUCTURE" style="display: none;"></canvas>
								<canvas id="curve-ENCHANTMENT" style="display: none;"></canvas>
							</div>
						</div>
		
		
						<div class="col-4 col-tab-6">
							<h4 class="list-stats">General</h4>
							<ul class="list-stats">
								<li><span>Author</span> <span class="right"><?=$data->author ?></span></li>
								<li><span>Scrolls</span> <span class="right"><?=$data->scroll_count ?></span></li>
								<li><span>Hard Gold Cost</span> <span class="right"><?=$data->total_cost ?> <i class="icon-gold small"></i></span></li>
								<li><span>BM Gold Cost</span> <span class="right"><?=$data->black_market_cost ?> <i class="icon-gold small"></i></span></li>
								<li><span>Shards</span> <span class="right"><?=$data->shards ?> <i class="icon-shard small"></i></span></li>
								<li><span>Version</span> <span class="right"><?=$data->meta_version ?></span></li>
							</ul>
						</div>
		
						<div class="col-4 col-tab-6">
							<h4 class="list-stats">Types</h4>
							<div class="col-8">
								<ul class="list-stats">
									<?php foreach ($data->kinds as $kind => $count) {
										echo "<li><span><i class='ball-$kind'></i>".ucfirst(strtolower($kind)).":</span> <span class='right'>$count</span></li>";
									} ?>
		
								</ul>
							</div>
							<div class="col-4">
								<canvas id="chart-types" width="100px" height="100px" style="margin: 0 auto;"/>
							</div>
						</div>
					</div>
		
					<div class="page-header">	
						<h3><i class="fa fa-pie-chart"></i> Statistics <small>Specific</small></h3>
					</div>
					<div class="col-12">
						<div class="col-4">
							<h4 class="list-stats">Sub Types</h4>
							<ul class="list-stats">
								<?php foreach ($data->types as $type => $count) {
									echo "<li><span>".ucfirst(strtolower($type)).":</span> <span class='right'>$count</span></li>";
								} ?>
							</ul>
						</div>
		
						<div class="col-4">
							<h4 class="list-stats">Rarities</h4>
							<ul class="list-stats">
								<?php foreach ($data->rarities as $rarity => $count) {
		
									switch ($rarity) {
										case 0:
											echo "<li><span>Common:</span> <span class='right'>$count</span></li>";
										break;
		
										case 1:
											echo "<li><span>Uncommon:</span> <span class='right'>$count</span></li>";
										break;
		
										case 2:
											echo "<li><span>Rare:</span> <span class='right'>$count</span></li>";
										break;
									}
		
		
								} ?>
							</ul>
						</div>
					</div>
				</div>
				</div>
				
				<div class="row">
					<div class="col-8 col-offset-2">
						<?=$data->text ?>
					</div>
				</div>
				
				<?php if (!empty($data->tags)) { ?>
				
				<div class="row">
					<div class="col-12">
						<div class="page-header">
							<h3><i class="fa fa-tags"></i> Tags</h3>
						</div>
						<ul class="tags col-12">
							<?php foreach ($data->tags as $tag) {
								echo '<li class="tag left"><i class="fa fa-tag"></i> '.$tag.'</li>';
							} ?>
						</ul>
					</div>
				</div>
				<?php } ?>
				
			</div>
		</div>
	</div>
		
</div>

<script>
	$(function() {


	var decay = "#AD7FCC";
	var dark_decay = "#965bbd";
	
	var energy = "#CC9500";
	var dark_energy = "#997000";
	
	var order = "#94B2CC";
	var dark_order = "#7199bc";
	
	var growth = "#A0CC56";
	var dark_growth = "#88b837";
	
	
	var CREATURE = "#e2d5af";
	var STRUCTURE = "#b7ac83";
	var SPELL = "#bad6d8";
	var ENCHANTMENT = "#90b1a6";
	
	var pieData = [
			<?php foreach ($data->kinds as $kind => $count) { ?>
				
				{
					value: <?=$count ?>,
					color: <?=$kind ?>,
					highlight: <?=$kind ?>,
					label: "<?=ucfirst(strtolower($kind)) ?>"
				},
			<?php } ?>
			

	];
	
	window.onload = function(){
		var ctx = document.getElementById("chart-area").getContext("2d");
		window.myPie = new Chart(ctx).Pie(pieData);
	};
	
	
	<?php
		foreach ($data->curve as $faction => $kind) {
			foreach ($kind as $name => $cost) { ?>
				
				if(typeof barChartData<?=$name ?> === 'undefined') {
					var barChartData<?=$name ?> = {
						labels : [1,2,3,4,5,6,7,8,9],
						datasets : []
					};
				}
				
				barChartData<?=$name ?>.datasets.push(
					{
						label : "<?="$faction $name" ?>",
						fillColor : <?=$faction ?>,
						highlightFill: dark_<?=$faction ?>,
						data : [
							<?=implode(',',$cost) ?>
						]
					});
			<?php }
		}
	?>
	
	
	
	window.onload = function(){
		<?php
			foreach ($data->curve as $faction => $kind) {
				foreach ($kind as $cost => $value) {
		?>
			loadGraph("curve-<?=$cost ?>", barChartData<?=$cost ?>);
		<?php		}
			}
		?>
		
		var ctx = document.getElementById("chart-types").getContext("2d");
		window.myPie = new Chart(ctx).Pie(pieData);
	}
	
	$("input[name=curve]:radio").change(function() {
		$("canvas:not(#chart-types)").hide();
		
		$("#curve-"+$(this).attr('data')).show();
	});
	
	function loadGraph(id,barChart) {
		var ctx = document.getElementById(id).getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChart, {
			responsive : true
		});
	}

		
	});
</script>
