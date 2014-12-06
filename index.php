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
	
	//$_GET['error'] = "Your account is not yet verified, please do so.";
	//$_GET['success'] = "you did something right, congratulations!";
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
	
	<!--Main css-->
	<link rel="stylesheet" href="/css/main.css" />
	
	<!--Font Awesome-->
	<link rel="stylesheet" href="/css/font-awesome.min.css" />
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--Chart.js-->
	<script src="/js/min/chart-min.js"></script>
	
	<!--jQuery-1.11.1.min-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<!--Main Javascript-->
	<script src="/js/min/main-min.js" type="text/javascript"></script>
</head>
	<body>
		
<!--	Menu	-->		

<div class="menu clearfix">
	<div class="container">
		<ul class="">
		<li class="head"></li>
		<?php //fetching each page to display on the menu
			foreach ($base->pagestructure as $key => $value) {
				if (isset($value['menu']) && $value['menu'] == true) {
					echo("<li><a class='tag' href='".$key."'>".$value['name']."</a></li>");
				}
			} ?>
		</ul>
		<ul class="right">
			<!--<li><a class='tag' href='/login'>Login</a></li>
			<li><a class='tag' href='/registarte'>Registarte</a></li>-->
			
			<li><a class='tag' href='/profile'>Orangee</a></li>
			<li><a class='tag' href='/logout<?= $base->get_page() ?>'>Logout</a></li>
		</ul>
	</div>
</div>
<!--	end Menu	-->	

<!-- Dialog box -->
	<div class="container hidden dialog" id="errorcontainer">
		<div class="row ">
			<div class="col-12 tag error">
				<div class="left"><p id="errorMessage"><?=$_GET['error']?></p></div>
				<div class="close"><p id="errorCloseBtn">&times;</p></div>
			</div>
		</div>
	</div>
	<div class="container hidden dialog" id="successcontainer">
		<div class="row">
			<div class="col-12 tag success">
				<div class="left"><p id="successMessage"><?=$_GET['success']?></p></div>
				<div class="close"><p id="successCloseBtn">&times;</p></div>
			</div>
		</div>
	</div>
	<div class="container hidden dialog" id="specialmessagecontainer">
		<div class="row">
			<div class="col-12">
				<div id="specialmessage" class="col-12 tag"></div>
			</div>
		</div>
	</div>
<!--end Dialog Box-->	

	
	
	
<!--	Content	-->
		<?php include($base->get_content()); ?>
<!--	end content	-->

		

<!--	Footer of the page	-->
		<div class="container clearfix">
			<div class="row">
				<div class="col-12 align-center">
					<div class="col-4">
						<div class="col-12 tag" id="authserverstatus"></div>
					</div>
					<div class="col-4" id="">
						<div class="col-12 tag" id="scrollsingame"></div>
					</div>
					<div class="col-4" id="">
						<div class="col-12 tag" id="scrollstoday"></div>
					</div>
				</div>
			</div>
		</div>
<!--	end Footer	-->		
	</body>
</html>