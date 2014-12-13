<?php 

	//databases
	require_once("controllers/pdo.php");
	require_once("controllers/accountController.php");
	require_once("controllers/deckController.php");
	
	
	
	//pages
	require_once("controllers/pagehandler.php");
	require_once("controllers/structure.php");
	require_once("controllers/texthandler.php");
	
	$deck = new Deck();
	$base = new Structure();
	$formating = new TextHandler();
	
	//$_GET['error'] = "Your account is not yet verified, please do so.";
	//$_GET['success'] = "you did something right, congratulations!";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	<meta name="application-name" content="Scrolldier" />
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Apple Device: App-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<!-- Apple Device: Remove Status bar-->
	<meta name="apple-mobile-web-app-status-bar-style" content=“black”>
	
	<!--	Getting page title-->
	<title><?php echo($base->get_title()); ?></title>
	
	<!--Main css-->
	<link rel="stylesheet" href="/css/main.css" />
	
	<!--Favicon-->
	<!--[if IE]>
		<link rel="shortcut icon" href="/img/ico/iconX32.ico">
	<![endif]-->
	<link rel="icon" href="/img/ico/iconX96.png" />
	
	<!--Font Awesome-->
	<link rel="stylesheet" href="/css/font-awesome.min.css" />
	
	<!-- Apple Device: Home Screen icon-->
	<link rel="apple-touch-icon" sizes="76x76" href="/img/apple/iconX76_bg.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="/img/apple/iconX120_bg.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/img/apple/iconX152_bg.png" />
	
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--Chart.js-->
	<script src="/js/min/chart-min.js"></script>
	
	<!--jQuery-1.11.1.min-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<!--Main Javascript-->
	<script src="/js/min/main-min.js" type="text/javascript"></script>
	
	<!--Typeahead-->
	<script src="/js/min/typeahead-min.js" type="text/javascript"></script>
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
			<li><a class='tag' href='#login_box' id="login_btn">Login</a></li>
			<li><a class='tag' href='#login_box' id="registarte_btn">Register</a></li>
			
			<!--<li><a class='tag' href='/profile'>Orangee</a></li>
			<li><a class='tag' href='/logout<?= $base->get_page() ?>'>Logout</a></li>-->
		</ul>
	</div>
</div>
<!--	end Menu	-->	
	
<!-- Login Box-->	
	<div class="tag clearfix hidden" id="login_box">
		<div class="container">
			<div class="row">
				<div class="col-8 col-offset-2 col-tab-10 col-tab-offset-1 col-phone-12">
					<div class="form-element">
						<h2><i class="fa fa-unlock"></i> Login to Scrolldier <small class="right hand" id="close_login"><i class="fa fa-times"></i></small></h2>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="username">In Game Name</label>
							<input id="username" type="text" name="" value="" placeholder="In Game Name"/>
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="password">Password</label>
							<input id="password" type="password" name="" value="" placeholder="Password" />
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label>
								<input type="checkbox" name="save_pw" value="save" /> Remember me <small>Using Cookies</small>
							</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label>
								<small><a href="/terms" target="_blank">Terms & Conditions</a></small>
							</label>
						</div>
					</div>
					<div class="col-12">
						<div class="form-element">
							<button type="submit" class="btn" name=""><i class="fa fa-check"></i> Login</button>
							<button type="submit" class="btn right success" id="reg_box_btn" name="">Register</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end Login Box-->
<!-- Register Box-->	
	<div class="tag clearfix hidden" id="reg_box">
		<div class="container">
			<div class="row">
				<div class="col-8 col-offset-2 col-tab-10 col-tab-offset-1 col-phone-12">
					<div class="form-element">
						<h2><i class="fa fa-lock"></i> Register on Scrolldier <small class="right hand" id="close_reg"><i class="fa fa-times"></i></small></h2>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="username">In Game Name</label>
							<input id="username" type="text" name="" value="" placeholder="In Game Name"/>
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="password">Password</label>
							<input id="password" type="password" name="" value="" placeholder="Password" />
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="mail">E-mail</label>
							<input id="mail" type="text" name="" value="" placeholder="E-mail"/>
						</div>
					</div>
					<div class="col-6">
						<div class="form-element">
							<label for="password">Password Again</label>
							<input id="password" type="password" name="" value="" placeholder="Password Agian" />
						</div>
					</div>
					<div class="col-12">
						<div class="form-element">
							<label>
								<input type="checkbox" name="save_pw" value="save" /> I accept the 
								<a href="/terms" target="_blank">Terms & Conditions</a>
							</label>
						</div>
					</div>
					<div class="col-12">
						<div class="form-element">
							<button type="submit" class="btn success" name="" id="">Register</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end Register Box-->		
	
<!--	Content	-->
		<?php include($base->get_content()); ?>
<!--	end content	-->

		

<!--	Footer of the page	-->
		<div class="container clearfix">
			<div class="row">
				<div class="col-12 align-center">
					<div class="col-4 col-tab-12">
						<div class="col-12 tag" id="authserverstatus"></div>
					</div>
					<div class="col-4 col-tab-6 col-phone-12" id="">
						<div class="col-12 tag" id="scrollsingame"></div>
					</div>
					<div class="col-4 col-tab-6 col-phone-12" id="">
						<div class="col-12 tag" id="scrollstoday"></div>
					</div>
				</div>
			</div>
		</div>
<!--	end Footer	-->		


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
	</body>
</html>