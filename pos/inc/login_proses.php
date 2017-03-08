<?php
session_start();
include("../database.php");

if($_GET['do'] == 'Login'){
	if($_POST['userid'] == '' || $_POST['passwd'] == ''){
		echo "<script type='text/javascript'>alert('Username / Password kosong');</script>';";
	}else{
		//coding Login
		$_SESSION['log_id'] == $_POST['userid'];
	}
	header("Location: index.php");
	die();
}else{
	session_destroy();
}
?>