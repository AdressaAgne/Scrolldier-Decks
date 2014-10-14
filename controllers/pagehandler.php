<?php 
$request = parse_url($_SERVER['REQUEST_URI']);
$path = $request["path"];
$page = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');



