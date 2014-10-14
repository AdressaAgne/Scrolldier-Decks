<?php 
	require_once("controllers/connection.php");
	require_once("controllers/structure.php");
	
	require_once("controllers/pagehandler.php");
	

	$base = new Structure();
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	
	<title><?php echo($base->get_title($page)); ?></title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="/css/main.css" />
	
	<?php echo($base->get_styles($page)); ?>
	
</head>
	<body>
			<div class="container">
			
				<?php include($base->get_content($page)); ?>
			
			</div>
	</body>
</html>