<?php 
$prepend = "../../../";
require_once($prepend."controllers/pdo.php");
require_once($prepend."controllers/accountController.php");
require_once($prepend."controllers/deckController.php");
require_once($prepend."controllers/scrollController.php");
require_once($prepend."controllers/settinsController.php");

//pages
require_once($prepend."controllers/pagehandler.php");

require_once($prepend."controllers/structure.php");
require_once($prepend."controllers/texthandler.php");

$deck = new Deck();
$base = new Structure();
$formating = new TextHandler();
$account = new AccountController();
$ScrollController = new ScrollController();
$SettingsController = new SettingsController();
$twitch = $SettingsController->getSettingsByType(2);