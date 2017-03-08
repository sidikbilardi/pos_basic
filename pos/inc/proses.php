<?php
session_start();
include "../database.php";
if($_GET['action'] == 'toMenu'){
	$_SESSION['meja'] = $_POST['id'];
}elseif($_GET['action'] == 'addMenu'){
	mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
	('".$_SESSION['trx']."','".$_POST['kode_menu']."','".$_POST['qty']."','".$_POST['harga']."',now(),'PRC','".$_POST['comment']."','W002','1511','1')");
}elseif($_POST['action'] == 'doLogin'){
	$_SESSION['log_id'] == '1';
}elseif($_GET['action'] == 'addtrf'){
	$pos_id = $_POST['pilih1'];
	$inv_id = $_POST['pilih2'];
	mysql_query("INSERT INTO tblpos_to_inv (pos_id,inv_id,input_date) VALUES('".$pos_id."','".$inv_id."',now())");
}else{
	$idmenu = $_POST['id'];
	$idtrx = $_POST['trx'];
	mysql_query("UPDATE tbltransorder_detail set keterangan='COOKED' where no_bukti='".$idtrx."' AND kode_menu = '".$idmenu."'");
}
?>