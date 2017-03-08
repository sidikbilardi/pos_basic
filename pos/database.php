<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');
	$localhostdb = 'localhost';
	$usernamedb  = 'root';
	$passworddb  = 'masterkey';
	$databasedb  = 'pos';
	
	$con = mysql_connect($localhostdb,$usernamedb,$passworddb)or die("cannot connect"); 
	mysql_select_db($databasedb)or die("cannot select DB");
	
	#denied access by ip
	/*$queryIP = mysql_query("SELECT * FROM w_ip");
	$deny = array();
	while($resultIP = mysql_fetch_array($queryIP))
	{
		array_push($deny,$resultIP['ip']);
	}

	if (!in_array ($_SERVER['REMOTE_ADDR'], $deny)) {
	   header("location: denied.php");
	   exit();
	}
	*/######################
	$u = mysql_query("SELECT * FROM tblutilitysetting",$con);
	$ut = mysql_fetch_array($u);
	$_SESSION['C'] = $ut['lic'];
	$_SESSION['link1'] = $localhostdb;
	$_SESSION['link1_id'] = $usernamedb;
	$_SESSION['link1_password'] = $passworddb;	
	$_SESSION['db1'] = $databasedb;
	$_SESSION['link4'] = '192.168.1.26';
	$_SESSION['db4'] = 'willertweblicense';		
?>