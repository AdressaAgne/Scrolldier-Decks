<?php 
	$url = "data/keywords.json";
	$json = file_get_contents($url);
	$data = json_decode($json, TRUE);
 ?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="page-header">
				<h2><i class="fa fa-key"></i> In-Game Keywords</h2>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table class="even divider hover border">
				<thead>
					<tr>
						<td>Keyword</td>
						<td>Description</td>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < count($data['strings']); $i++) { ?>
					<tr>
						<td><?=$data['strings'][$i]['key']?></td>
						<td><?=$data['strings'][$i]['value']?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>