<div class="container">
	<div class="page-header">
		<h2>Decks</h2>
	</div>
	
	<div class="col-12 table">
		<div class="col-12 thead">
			<div class="col-1">Score</div>
			<div class="col-6">Title</div>
			<div class="col-1">Scrolls</div>
			<div class="col-2">Ressources</div>
			<div class="col-2">By</div>
		</div>
		
		
		
		<?php 	
			$query = $deck->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 ORDER BY meta desc, vote desc, time DESC LIMIT 30");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
		?>
	
		<a href="/deck/<?= $row['id'] ?>" class="tbody">
			<div class="col-12 trow">
				<div class="col-1"><?= $row['vote'] ?></div>
				<div class="col-6"><?= $row['deck_title'] ?></div>
				<div class="col-1"><?= $row['scrolls'] ?></div>
				<div class="col-2">
					<?php 
						if (!empty($row['tOrder'])) {
							echo("<i class='icon-order'></i> ");
						}
						if (!empty($row['growth'])) {
							echo("<i class='icon-growth'></i> ");
						}
						if (!empty($row['energy'])) {
							echo("<i class='icon-energy'></i> ");
						}
						if (!empty($row['decay'])) {
							echo("<i class='icon-decay'></i> ");
						}
						if (!empty($row['wild'])) {
							echo("<i class='icon-wild'></i>");
						}
					 ?>
				</div>
				<div class="col-2"><?= $row['deck_author'] ?></div>
			</div>
		</a>	
				
		<?php } ?>
		
		
	</div>
</div>