<?php
include "../database.php";
	$idmenu = $_POST['id'];
	$idtrx = $_POST['trx'];
	mysql_query("UPDATE tbltransorder_detail set keterangan='COOKED' where no_bukti='".$idtrx."' AND id = '".$idmenu."'");
	
?>	