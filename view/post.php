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
			<div class="col-12 align-center">
				<h2><?=$row['header']?><br />
					<small>By: <?=$row['byName']?>, <?=$row['time']?></small>
				</h2>
			</div>
			
			<div class="col-12">
				<?php 
					$html_text = $formating->removeText('<p>&nbsp;</p>', $row['html']);
					$html_text = $formating->removeText('<p dir="ltr">&nbsp;</p>', $html_text);
					$html_text = $formating->surroundText('(<img src="(.*)">)', '<div class="image">$1</div>', $html_text);
				 ?>
				<?=$html_text?>
			</div>
		</div>
		
		
		
		<?php } ?>
	
</div>
</div>