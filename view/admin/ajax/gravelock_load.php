<?php 
include_once("ajax_prepend.php");
if ($_SESSION['ign']) {
	$query = $deck->_db->prepare("SELECT gravelock FROM accounts WHERE ign = :ign");
	$arr = array(
			'ign' => $_SESSION['ign']
		);
	
	$deck->arrayBinder($query, $arr);
	
		if ($query->execute()) {
			$game = $query->fetch(PDO::FETCH_ASSOC);
			echo($game['gravelock']);
		} else {
			echo("Could not fetch data");
		}
} else {
	echo("User not logged inn");
}

		

