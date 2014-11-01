<?php 

$data = $deck->get_deck_data($base->get_var(1));

@$data->supressWarnings();

?>
<div class="deck-bar">
	<?php
	foreach ($data->percentage as $faction => $percent) {
		echo '<div class="bar bar-'.$faction.'" style="width: '.$percent.'%;"></div>';
	}
	?>
</div>
 
<div class="container">

	<div class="page-header">
		<h2>
		<?php
			foreach ($data->resources as $resource => $count) {
				echo '<i class="icon-gold-'.$resource.' front-text"></i>';
			}
		?>
		<?=$data->name ?> <br />
		<small>Score: <?=($data->vote_up - $data->vote_down) ?> - by <?=$data->author ?> - <?=$data->time ?></small></h2>
	</div>
	
	<div class="col-12 align-center">
		<button class="btn big success">Vote Up</button>
		<button class="btn big danger">Vote Down</button>
	</div>
	
	<div class="col-12">
		<div class="col-12">
			<div class="col-12 deck-scrolls">
				<?php foreach ($data->scrolls as $scroll) { ?>
					<div class="col-2 col-p-6 col-t-3" data-id="<?=$scroll->id ?>" data-count="<?=$scroll->count ?>">
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
		
		<div class="col-12 col-t-12">
				
			<div class="page-header">
				<h3>Statistics <small>General</small></h3>
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

				<div class="col-4 col-t-12">
					<h4 class="list-stats">Curve</h4>
					<div class="curveContainer">
						<canvas id="curve-all"></canvas>
						<canvas id="curve-SPELL" style="display: none;"></canvas>
						<canvas id="curve-CREATURE" style="display: none;"></canvas>
						<canvas id="curve-STRUCTURE" style="display: none;"></canvas>
						<canvas id="curve-ENCHANTMENT" style="display: none;"></canvas>
					</div>
				</div>


				<div class="col-4 col-t-6">
					<h4 class="list-stats">General</h4>
					<ul class="list-stats">
						<li><span>Author</span> <span class="right"><?=$data->author ?></span></li>
						<li><span>Scrolls</span> <span class="right"><?=$data->scroll_count ?></span></li>
						<li><span>Gold Cost</span> <span class="right"><?=$data->total_cost ?>g</span></li>
						<li><span>Version</span> <span class="right"><?=$data->meta_version ?></span></li>
					</ul>
				</div>

				<div class="col-4 col-t-6">
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
				<h3>Statistics <small>Specific</small></h3>
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
		
		
		<div class="col-8 col-offset-2">
			<?=$data->text ?>
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
				
				var barChartData<?=$name ?> = {
					labels : [1,2,3,4,5,6,7,8,9],
					datasets : [
						{
							label : "<?="$faction $name" ?>",
							fillColor : <?=$faction ?>,
							highlightFill: dark_<?=$faction ?>,
							data : [
								<?=implode(',',$cost) ?>
							]
						},
						],
					}
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
		
		var nav = $('.deck-bar');
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 134) {
		        nav.addClass("deck-bar-fixed");
		        
		    } else {
		        nav.removeClass("deck-bar-fixed");
		    }
		});
		
	});
</script>