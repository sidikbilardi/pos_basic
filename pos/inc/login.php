<?php
session_start();
include "../database.php";


//$_SESSION['login'] = false;
	if($_GET['action'] == 'doLogin'){
		if($_POST['userid'] == '' || $_POST['password'] == '' ){
			$_SESSION['error_msg'] = 'Warning: Username dan sandi harus diisi.';
			header("Location:../index.php?msg=1");
		}else{
			if(!doLogin($_POST['userid'],$_POST['password'])){
				
				$_SESSION['error_msg'] = 'Warning: Username atau sandi salah.';
				header("Location:../index.php?msg=2");
			}else{
				
				$logged = $_SESSION['login'];
				$_SESSION['error_msg'] = 'Success: Login Success';
				header("Location:../index.php");
			}
		/*	doLogin($_POST['userid'],$_POST['password']); */
		}
	}else if($_POST['action'] == 'ContPettycash'){
		$_SESSION['petty'] = $_POST['petty'];
		echo "Selamat Datang ".$_SESSION['nama_waiter'];

	}else if($_POST['action'] == 'ClosePettycash'){
		$user = mysql_real_escape_string(stripslashes($_POST['usr']));
		$petty = mysql_real_escape_string(stripslashes($_POST['petty']));
		$nominal = mysql_real_escape_string(stripslashes($_POST['nom']));
		$sementara = mysql_real_escape_string(stripslashes($_POST['sementara']));
		/*if($nominal < $sementara){
			echo"Nominal tidak boleh lebih kecil dari transaksi";
		}else{
		*/	mysql_query("UPDATE tbl_pettycash set status = '0',out_time = now(),close_nominal ='$nominal' where user = '$user' AND id='$petty' ");
			mysql_query("UPDATE tbltranspayment set pettycash ='$petty' where pettycash = '' ");
			mysql_query("UPDATE tbltrans_summary set pettycash  ='$petty' where pettycash = '' ");
			$_SESSION['petty'] ='';
			echo "Anda berhasil Menutup Pettycash";
		//}
	}else if($_POST['action'] == 'doPettycash'){
		$user = mysql_real_escape_string(stripslashes($_POST['usr']));
		$nom = mysql_real_escape_string(stripslashes($_POST['nom']));
		if($user == '' || $nom == ''){
			echo"Ada data yang kosong";
		}else{
			mysql_query("INSERT INTO tbl_pettycash (user,modal,in_time,status) VALUES ('$user',$nom,now(),'1') ");
			echo "Anda berhasil membuat pettycash";
		}
	}else if($_POST['action'] == 'authorized'){
		doAuth($_POST);
	}else if($_GET['action'] == 'doLogout'){
		doLogout($_GET);
		$_SESSION['error_msg'] = 'Logout success';
			header("Location:../index.php?msg=0");
		
	}

	function doAuth($_POST){
		$username = mysql_real_escape_string(stripslashes($_POST['usr']));
		$password = mysql_real_escape_string(stripslashes($_POST['pss']));
		//$encrypt = md5($password);
		$rs = mysql_query("select * from tblmasterwaiter where kode_waiter = '$username' and pin = '$password' AND (keterangan ='Manager' OR keterangan ='Finance' OR keterangan ='Owner') and status = 1");
		$jml = mysql_num_rows($rs);
		if($jml == 1){
			$_SESSION['auth'] = $username;
			
		}
		echo $jml;
	}
	
	function doLogout(){
		
		session_destroy();
		
	}	
	function doLogin($username,$password){
		$username = mysql_real_escape_string(stripslashes($username));
		$password = mysql_real_escape_string(stripslashes($password));
		//$encrypt = md5($password);
		$rs = mysql_query("select * from tblmasterwaiter where kode_waiter = '$username' and pin = '$password'");
		$jml = mysql_num_rows($rs);
		if($jml == 1){
			$cek = mysql_fetch_array($rs);
			if($username == $cek['kode_waiter'] && $password == $cek['pin']){
				$_SESSION['login'] = true;
				$_SESSION['logged_id'] = $cek['kode_waiter'];
				$_SESSION['nama_waiter'] = $cek['nama_waiter'];
				$_SESSION['kode_waiter'] = $cek['kode_waiter'];
				$_SESSION['keterangan'] = $cek['keterangan'];
				//$_SESSION['link1'] = '192.168.137.1'; //willertpos
				$_SESSION['link1'] = 'localhost';
				$_SESSION['db1'] = 'pos'; //willertpos database
				$_SESSION['link2'] = 'localhost';
				//$_SESSION['link2'] = '192.168.137.1'; //willertbginv
				$_SESSION['db2'] = 'pos'; //willertbginv database
				$_SESSION['link3'] = '25.37.26.129';
				//$_SESSION['link2'] = '192.168.137.1'; //willertvoucher
				$_SESSION['db3'] = 'willertvoucher'; //Voucher database				
				//echo "elellele";
				mysql_query("INSERT INTO tblusertrack VALUES('','Web','".$_SESSION['logged_id']."',now(),'')");
				$q = mysql_query("SELECT * FROM tblusertrack where user_id = '".$_SESSION['logged_id']."' AND out_time = '0000-00-00 00:00:00' ORDER BY in_time DESC");
				$d = mysql_fetch_array($q);
				$_SESSION['track'] = $d['track_no'];
				return true;
			}else{
				//echo "ULULUL";
				return false;
			}
		}else{
			//echo "ALALALAL";
			return false;
		}
		
	
		//echo "<script type='text/javascript'>alert('$jml');</script>";	
	}
?>