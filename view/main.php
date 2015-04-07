<!--<div class="container">

	<div class="row news">
	
		<?php include("index/featured_deck.php") ?>
	
	</div>

</div>-->

<div class="container">	
	
	<div class="row news">
            
            <?php
            if($twitch['value_int'] == 1) {
            ?>
                <div class="col-8 col-offset-2 col-tab-10 col-tab-offset-1">
                    <div class="col-12 align-center">
                        <iframe src="http://www.twitch.tv/<?=$twitch['value_var'];?>/embed" frameborder="0" scrolling="no" height="378" width="620"></iframe>
                    </div>
                </div>
		<?php 
            }
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