<?php 
include_once("ajax_prepend.php");
$query = $deck->_db->prepare("INSERT INTO pages (url, title, name, menu, tool, restricted, grade, image, file) VALUES (:url, :title, :name, :menu, :tool, :res, :grade, :image, :file)");
$arr = array(
		'url' => $_POST['url'],
		'title' => $_POST['title'],
		'name' => $_POST['name'],
		'menu' => $_POST['menu'],
		'tool' => $_POST['tool'],
		'res' => $_POST['restriction'],
		'grade' => $_POST['grade'],
		'image' => $_POST['image'],
		'file' => $_POST['file']
	);

$deck->arrayBinder($query, $arr);

	if ($query->execute()) {
		echo(true);
	} else {
		echo(false);
	}
		

