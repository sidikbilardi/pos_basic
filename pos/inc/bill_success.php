<?php
session_start();
include"../database.php";
$trx = $_GET['trx'];


$sub_total = $_GET['sub'];
$disc = $_GET['disc'];
$svc = $_GET['svc'];
$tax = $_GET['tax'];
$grand = $_GET['grand'];
$pax = $_GET['pax'];
mysql_query("INSERT INTO tbltrans_summary (user,pax,no_bukti,sub_total,disc,svc,tax,total) VALUES('".$_SESSION['kode_waiter']."','$pax','$trx','$sub_total','$disc','$svc','$tax','$grand')");

$d = mysql_query("SELECT * FROM tbltranspayment where no_bukti = '$trx' ");
while($dt = mysql_fetch_array($d)){
	$sub += $dt['nominal'];
	$kembali += $dt['kembali'];
/*	if($dt['jenis'] == 'CSH'){
		$csh = $dt['nominal'] + $dt['kembali'];
		$sub =+ $csh;
	}elseif($dt['jenis'] == 'DBT'){
		$dbt =  $dt['nominal'];
		$sub =+ $dbt;
	}elseif($dt['jenis'] == 'CC'){
		$cc =  $dt['nominal'];
		$sub =+ $cc;
	}elseif($dt['jenis'] == 'VCH'){
		$vch =  $dt['nominal'];
		$sub =+ $vch;
	}

*/?>
<div class="col-xs-6 col-md-6 label-control"><?php echo $dt['jenis']?></div>
<div class="col-xs-6 col-md-6 label-control">: <?php echo number_format($dt['nominal']);?></div>	
<?php }
?>
</br>
<div class="col-xs-6 col-md-6 label-control">Total Bayar</div>
<div class="col-xs-6 col-md-6 label-control">: <?php echo number_format($sub);?></div>
<div class="col-xs-6 col-md-6 label-control">Total Kembali</div>
<div class="col-xs-6 col-md-6 label-control">: <strong><?php echo number_format($kembali);?></strong></div>
</br>
<div class="col-xs-4 col-md-4 label-control"><a href="index.php"><button class="btn btn-lg btn-flat btn-success">Next Order</button></a></div>
<div class="col-xs-4 col-md-4 label-control"></div>
<div class="col-xs-4 col-md-4 label-control"><button class="btn btn-lg btn-flat btn-success" onClick="printReceipt('<?php echo $trx;?>')" >Print Billing</button></div>

<div id="billing_receipt"></div>


<script>
function printReceipt(trx){
	$('#billing_receipt').load("inc/bill_receipt.php?trx="+trx);
}

	$(document).ready(function() {
		$('#billing_receipt').css({'display':'none'});

	});	
</script>