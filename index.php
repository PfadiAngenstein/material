<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require "config.php";
require "functions.php";

if( !$_SESSION['auth'] ) { 
	header("Location: login.php"); 
} else {

$edit = false;
if(isset($_GET['token'])) {
	$checkToken = checkToken($_GET['token']);
	if($checkToken != false && isset($_GET['edit'])) {
		$edit = true;
		$arr = $checkToken;
	}
}
?>

<html>
    <head>
        <title>Material bestellen</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <h1>Material bestellen!</h1>
    </body>
</ht>