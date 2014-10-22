<?php 

	//databases
	require_once("controllers/pdo.php");
	require_once("controllers/accountController.php");
	require_once("controllers/deckController.php");
	
	
	
	//pages
	require_once("controllers/pagehandler.php");
	require_once("controllers/structure.php");
	
	$deck = new Deck();
	$base = new Structure();
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--	Getting page title-->
	<title><?php echo($base->get_title()); ?></title>
	
	<link rel="stylesheet" href="/css/main.css" />
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	
</head>
	<body>
		<?php 
			if (isset($_GET['error'])) {
				echo($_GET['error']);
			}
		?>
		
		<div class="wallpaper" style="background-image: url(/img/backgrounds/cover-1.jpg);">
			<div class="container">
				<h1 class="header">Scrolldier</h1>
			</div>
			<div class="align-center menu">
			<?php //fetching each page to display on the menu
				foreach ($base->pagestructure as $key => $value) {
					if (isset($value['menu']) && $value['menu'] == true) {
						echo("<a class='btn' href='".$key."'>".$value['name']."</a>");
					}
				} ?>
			</div>
		</div>
		
		<?php include($base->get_content()); ?>

	</body>
	
	<!--jQuery-1.11.1.min-->
	<script src="/js/jquery.js"></script>
	<script>
		$(function(){
		   // alert("Testing if jQuery Works");
		    var nav = $('.menu');
		    $(window).scroll(function () {
		        if ($(this).scrollTop() > 134) {
		            nav.addClass("menu-fixed");
		        } else {
		            nav.removeClass("menu-fixed");
		        }
		    });
		 
		});
	</script>
</html>