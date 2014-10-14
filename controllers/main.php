<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php $base->get_title($page); ?></title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="../" />
	
	<?php $base->get_styles($page); ?>
	
</head>
	<body>
		
		<?php $base->get_content($page); ?>
		
	</body>
</html>