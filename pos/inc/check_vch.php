<?php
	session_start();
	$now = date("Y-m-d");
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');

	$localhostdb = $_SESSION['link3'];
	$usernamedb  = 'root';
	$passworddb  = '';
	$databasedb  = $_SESSION['db3'];
	
	$con = mysql_connect($localhostdb,$usernamedb,$passworddb)or die("cannot connect"); 
	mysql_select_db($databasedb)or die("cannot select DB");

	//$_SESSION['voucher'] = array();

if($_POST['action'] == 'checkVCH'){
	$id =  $_POST['cd'];
	$q = mysql_query("SELECT * FROM tbltransprintvoucher where no_voucher = '$id' LIMIT 1");
	$dt = mysql_fetch_array($q);
	$jml = mysql_num_rows($q);
	if($jml > 0){
		if($dt['tgl_redeem'] != '1900-01-01' ){
			echo "Voucher telah terpakai";
		}else{
			if($dt['tgl_selesai'] <= $now ){
				echo "Voucher telah Kadaluarsa";
			}elseif($dt['tgl_mulai'] >= $now ){
				echo "Voucher belum berlaku";
			}else{
				echo $dt['nominal'];
			}
		}
	}else{
		echo"Voucher tidak terdaftar";
	}

}


if($_POST['action'] == 'addVCH'){
	//array_push($_SESSION['voucher'],$_POST['vcr']);
	if (in_array($_POST['vcr'], $_SESSION['voucher'])) {
	    echo "1";
	}else{
		$_SESSION['voucher'][] = $_POST['vcr'];
		echo $_SESSION['voucher'];
	}	
	//$_SESSION['voucher'] .= $_POST['vcr'].',';
	
}

if($_POST['action'] == 'payVCH'){
	$card =$_POST['card'];
	mysql_query("UPDATE tbltransprintvoucher set tgl_redeem = now() where no_voucher = 'GEYJEZGLDD' ");

	
}


	

?>