<?php 
	require_once("controllers/connection.php");
	require_once("controllers/structure.php");
//	require_once("controllers/pagehandler.php");
	
	$base = new Structure();
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	
	<!--	Getting page title-->
	<title><?php echo($base->get_title()); ?></title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="/css/main.css" />
	
	<?php echo($base->get_styles()); ?>
	
</head>
	<body>
		<div class="container">
			<div class="col-12">
				
				<ul class="list-inline">
				<?php 
					//fetching each page to display on the menu
					foreach ($base->pagestructure as $key => $value) {
						if (isset($value['menu']) && $value['menu'] == true) {
						
							echo("<li><a href='".$key."'>".$value['name']."</a></li>");
							
						}
					}
				 ?>
				</ul>
			</div>
		</div>
	
		<div class="container">
			<?php include($base->get_content()); ?>
		</div>
	</body>
</html>