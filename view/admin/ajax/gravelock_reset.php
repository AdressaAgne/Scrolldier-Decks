<?php 
include_once("ajax_prepend.php");
if ($_SESSION['ign']) {
	$query = $deck->_db->prepare("UPDATE accounts SET gravelock = :json WHERE ign = :ign");
	$arr = array(
			'json' => null,
			'ign' => $_SESSION['ign']
		);
	
	$deck->arrayBinder($query, $arr);
	
		if ($query->execute()) {
			echo(true);
		} else {
			echo(false);
		}
} else {
	echo("User not logged inn");
}

		

