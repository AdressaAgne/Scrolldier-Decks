<?php 

$data = $deck->get_deck_data($base->get_var(1));

 ?>
 <div class="deck-bar">
 	<?php foreach ($data['percentage'] as $key => $value) {
 		echo('<div class="bar bar-'.$key.'" style="width: '.$value.'%;"></div>');
 	} ?>
 </div>
 
<div class="container">

	<div class="page-header">
		<h2>
		<?php 
			foreach ($data['ressourses'] as $key => $value) {
				echo('<i class="icon-gold-'.$key.' front-text"></i>');
			}
		?>
		<?php echo($data["name"]) ?> <br />
		<small>Score: <?php echo($data['vote_up'] - $data['vote_down']) ?> - by: <?php echo($data['author']." - ".$data['time']) ?></small></h2>
	</div>
	

		<div class="col-12 align-center">
			
			<button class="btn big success">Vote Up</button>
			<button class="btn big danger">Vote Down</button>
		</div>
	
	<div class="col-12">
		
		<div class="col-12">
					<div class="col-12 deck-scrolls">
						<?php 
						
		//					[id] => 21
		//		            [name] => Rallying
		//		            [count] => 3
		//		            [rarity] => 1
		//		            [ressours] => growth
		//		            [image] => 490
		
							foreach ($data['scrolls_values'] as $key => $value) { ?>
								
								<div class="col-2 col-p-6 col-t-3" data-id="<?php echo($data['scrolls_values'][$key]['id']) ?>" data-count="<?php echo($data['scrolls_values'][$key]['count']) ?>">
									 <div class="col-12 scroll scroll-stack-<?=$data['scrolls_values'][$key]['count']?>" style="background-image: url('/img/scrolls/<?php echo($data['scrolls_values'][$key]['image']) ?>.png');">
									
										<i class="icon-<?php echo($data['scrolls_values'][$key]['ressours']) ?>"></i>
									</div>
									<div class="col-12 scroll-content">
										<?php echo("x".$data['scrolls_values'][$key]['count']) ?> <?php echo($data['scrolls_values'][$key]['name']) ?>
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
						foreach ($data['curve'] as $faction => $value) {
							foreach ($data['curve'][$faction] as $key => $value) { ?>
								<label class="btn small">
									<input type="radio" name="curve" value="barChartData<?php echo($key) ?>" data="<?php echo($key) ?>" /> <?php echo(ucfirst(strtolower($key))) ?>
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
								<li><span>Author</span> <span class="right"><?php echo($data['author']) ?></span></li>
								<li><span>Scrolls</span> <span class="right"><?php echo($data['scrolls']) ?></span></li>
								<li><span>Gold Cost</span> <span class="right"><?php echo($data['cost']) ?>g</span></li>
								<li><span>Version</span> <span class="right"><?php echo($data['meta']) ?></span></li>
							</ul>
						</div>
						
						<div class="col-4 col-t-6">
							<h4 class="list-stats">Types</h4>
							<div class="col-8">
								<ul class="list-stats">
									<?php foreach ($data['types'] as $key => $value) {
										echo("<li><span><i class='ball-".$key."'></i>".ucfirst(strtolower($key)).":</span> <span class='right'>".$value."</span></li>");
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
								<?php foreach ($data['subtype'] as $key => $value) {
									echo("<li><span>".ucfirst(strtolower($key)).":</span> <span class='right'>".$value."</span></li>");
								} ?>
							</ul>
						</div>
		
						<div class="col-4">
							<h4 class="list-stats">Rarities</h4>
							<ul class="list-stats">
								<?php foreach ($data['rarities'] as $key => $value) {
									
									switch ($key) {
										case 0:
											echo("<li><span>Common:</span> <span class='right'>".$value."</span></li>");
										break;
										
										case 1:
											echo("<li><span>Uncommon:</span> <span class='right'>".$value."</span></li>");
										break;
										
										case 2:
											echo("<li><span>Rare:</span> <span class='right'>".$value."</span></li>");
										break;
									}
								
									
								} ?>
							</ul>
						</div>
					</div>
				</div>
		
		
		<div class="col-8 col-offset-2">
			<?php echo($data['text']) ?>
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
			<?php foreach ($data['types'] as $key => $value) { ?>
				
				{
					value: <?php echo($value) ?>,
					color: <?php echo($key) ?>,
					highlight: <?php echo($key) ?>,
					label: "<?php echo(ucfirst(strtolower($key))) ?>"
				},
			<?php } ?>
			

	];
	
				window.onload = function(){
					var ctx = document.getElementById("chart-area").getContext("2d");
					window.myPie = new Chart(ctx).Pie(pieData);
				};
	
	
	<?php
		foreach ($data['curve'] as $faction => $value) {
			foreach ($data['curve'][$faction] as $type => $value) { ?>
				
				var barChartData<?php echo($type) ?> = {
					labels : [1,2,3,4,5,6,7,8,9],
					datasets : [
						{
							label : "<?php echo($faction." ".$type) ?>",
							fillColor : <?php echo($faction) ?>,
							highlightFill: dark_<?php echo($faction) ?>,
							data : [
								<?php foreach ($data['curve'][$faction][$type] as $key => $value) {
									echo($value.",");
								} ?>
							]
						},
						],
					}
			<?php }
		}
	?>
	
	
	
		window.onload = function(){
			<?php
				foreach ($data['curve'] as $faction => $value) {
					foreach ($data['curve'][$faction] as $type => $value) { ?>
						loadGraph("curve-<?php echo($type) ?>", barChartData<?php echo($type) ?>);
					<?php }
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
<script src="js/min/chart-min.js"></script>