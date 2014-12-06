<div class="container">
	
	<div class="row news">
	
		<?php 
			
			$query = $deck->_db->prepare("SELECT * FROM scrolls WHERE id = :id ORDER BY time DESC LIMIT 10");
			$arr = array(
			    'id' => $base->get_var(1)
			);
			$deck->arrayBinderInt($query, $arr);
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>
		<div class="col-8 col-offset-2 col-t-10 col-t-offset-1">
			<div class="col-12">
				<h3><a href="/post/<?=$row['id']?>"><?=$row['header']?></a><br />
					<small>By: <?=$row['byName']?>, <?=$row['time']?></small>
				</h3>
			</div>
			
			<div class="col-12">
				<?=$row['html']?>
			</div>
		</div>
		
		
		
		<?php } ?>
	
</div>
</div>