<?php 
include_once("ajax_prepend.php");
$query = $deck->_db->prepare("DELETE FROM pages WHERE id = :id");
$arr = array(
		'id' => $_POST['id']
	);

$deck->arrayBinderInt($query, $arr);

if ($query->execute()) {
	echo(true);
} else {
	echo(false);
}