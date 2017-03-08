<?php
include"../database.php";
$trx = $_GET['trx'];
$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax,C.svc as loc_svc,C.tax as loc_tax, D.sub_total, D.disc, D.svc, D.tax, D.total,D.pax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C,tbltrans_summary D where A.no_bukti = D.no_bukti AND A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
$info = mysql_fetch_array($rs);

if($info['disc'] == 0){
	$disc_bill = 0;
}else{
	$disc_bill = $info['disc'];
}

$conf = mysql_query("SELECT * FROM tblutilitysetting");
$config = mysql_fetch_array($conf);

//for ($x = 0; $x <= 1; $x++) {
	if($x = 0){
		$judul = 'Cashier Copy';
	}else{
		$judul = 'Customer Copy';
	}
?>
	<!--div class="col-xs-3"></div-->
	<div class="col-xs-12"><center>Cashier Copy</center></div>
	<!--div class="col-xs-3"></div-->



	<div class="col-xs-12"><center><?php echo $config['resto_name'];?></center></div>


	<?php if($config['resto_add1'] != ''){ ?>
		
		<div class="col-xs-12"><center><?php echo $config['resto_add1'];?></center></div>

	<?php } ?>
	<?php if($config['resto_add2'] != ''){ ?>

		<div class="col-xs-12"><center><?php echo $config['resto_add2'];?></center></div>
		
	<?php } ?>
	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-6"><font size="2">Trx : <?php echo $info['no_bukti'];?></font></div>
	<div class="col-xs-6"><font size="2">Pax : <?php echo $info['pax'];?></font></div>

	<div class="col-xs-6"><font size="2">Tbl : <?php echo $info['nama_meja'];?></font></div>
	<?php
	if($info['nama_lokasi'] == 'Take Away')	{
		$type = 'Take Away';
	}else{
		$type = 'Dine in';
	}	?>
	<div class="col-xs-6"><font size="2">Type : <?php echo $type;?></font></div>
	<div class="col-xs-12">--------------------------------------------------</div>
	<?php
	$q = mysql_query("SELECT * FROM(select id,no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
	LEFT JOIN (SELECT comment_to,no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.id = Y.comment_to
	LEFT JOIN ( SELECT comment_to,no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.id = X.comment_to
	LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
	LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
	 ");
	while($data = mysql_fetch_assoc($q)){ 
		$sub = $data['harga']*$data['jml'];
		$dsc = $data['disc']*$data['qty'];

		?>
		<div class="col-xs-12"><font size="2"><?php echo $data['nama_menu'];?></font></div>
		<div class="col-xs-2"><font size="2"><?php echo $data['jml'].'x';?></font></div>
		<div class="col-xs-4"><font size="2"><?php echo number_format($data['harga']);?></font></div>
		<div class="col-xs-6"><font size="2"><?php echo number_format($sub);?></font></div>
		<?php if($data['cmt'] != ''){ ?>
			<div class="col-xs-2"></div>
			<div class="col-xs-10"><font size="2"><?php echo '-- '.$data['cmt'];?></font></div>
		<?php 	
		}
		if($data['disc'] != ''){ ?>
			
			<div class="col-xs-6"><font size="2"><?php echo 'Disc @'.$data['nama_disc'];?></font></div>
			<div class="col-xs-6"><font size="2">( <?php echo number_format($dsc);?> )</font></div>
		<?php 	
		}			
	}
	?>
	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-4"><font size="2">Sub Total</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['sub_total']);?></font></div>

	<div class="col-xs-4"><font size="2">Disc Bill</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['disc']);?></font></div>

	<div class="col-xs-4"><font size="2">Svc</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['svc']);?></font></div>

	<div class="col-xs-4"><font size="2">Tax</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['tax']);?></font></div>

	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-6"><font size="2">Grand Total</font></div>
	<div class="col-xs-6"><font size="2">:<?php echo number_format($info['total']);?></font></div>
	<?php
	$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND no_bukti = '$trx'");
		while($pay = mysql_fetch_assoc($p)){ 
			$bayar = $bayar + $pay['nominal'];
			$kembali = $kembali + $pay['kembali'];
			?>
			<div class="col-xs-4"><font size="2"><?php echo $pay['jenis'];?></font></div>
			<div class="col-xs-2"><font size="2">:</font></div>
			<div class="col-xs-6"><font size="2"><?php echo number_format($pay['nominal']);?></font></div>
		<?php } ?>
	<div class="col-xs-4"><font size="2">Pembayaran</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($bayar);?></font></div>	
	<div class="col-xs-4"><font size="2">Kembali</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($kembali);?></font></div>

	<div class="col-xs-12">--------------------------------------------------</div>
	<?php 
	$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$info['kasir']."'");
	$info2= mysql_fetch_array($w);
	?>
	<div class="col-xs-6"><font size="2">Cashier : <?php echo $info2['nama_waiter'];?></font></div>
	<div class="col-xs-6"><font size="2"><?php echo date("Y-m-d H:i:s");?></font></div>
	<?php
	if($config['footer_line1'] != ''){	?>
		<div class="col-xs-12">
			<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line1'];?></center></font></div>
		</div>
	<?php	
	}	
	if($config['footer_line2'] != ''){			?>
		<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line2'];?></font></center></div>
	<?php	
	}	
	if($config['footer_line3'] != ''){				?>
		<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line3'];?></font></center></div>
	<?php	
	}	?>
	<div class="col-xs-12"><center>.</center></div>
	<div class="col-xs-12"><center>.</center></div>
	<div class="col-xs-12"><center>.</center></div>
	<div class="col-xs-12"><center>.</center></div>












	<?php 
	$bayar = 0;
	$kembali = 0;
	?>



	<div class="col-xs-12"><center>Customer Copy</center></div>
	<!--div class="col-xs-3"></div-->



	<div class="col-xs-12"><center><?php echo $config['resto_name'];?></center></div>


	<?php if($config['resto_add1'] != ''){ ?>
		
		<div class="col-xs-12"><center><?php echo $config['resto_add1'];?></center></div>

	<?php } ?>
	<?php if($config['resto_add2'] != ''){ ?>

		<div class="col-xs-12"><center><?php echo $config['resto_add2'];?></center></div>
		
	<?php } ?>
	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-6"><font size="2">Trx : <?php echo $info['no_bukti'];?></font></div>
	<div class="col-xs-6"><font size="2">Pax : <?php echo $info['pax'];?></font></div>

	<div class="col-xs-6"><font size="2">Tbl : <?php echo $info['nama_meja'];?></font></div>
	<?php
	if($info['nama_lokasi'] == 'Take Away')	{
		$type = 'Take Away';
	}else{
		$type = 'Dine in';
	}	?>
	<div class="col-xs-6"><font size="2">Type : <?php echo $type;?></font></div>
	<div class="col-xs-12">--------------------------------------------------</div>
	<?php
	$q = mysql_query("SELECT * FROM(select id,no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
	LEFT JOIN (SELECT comment_to,no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.id = Y.comment_to
	LEFT JOIN ( SELECT comment_to,no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.id = X.comment_to
	LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
	LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
	 ");
	while($data = mysql_fetch_assoc($q)){ 
		$sub = $data['harga']*$data['jml'];
		$dsc = $data['disc']*$data['qty'];

		?>
		<div class="col-xs-12"><font size="2"><?php echo $data['nama_menu'];?></font></div>
		<div class="col-xs-2"><font size="2"><?php echo $data['jml'].'x';?></font></div>
		<div class="col-xs-4"><font size="2"><?php echo number_format($data['harga']);?></font></div>
		<div class="col-xs-6"><font size="2"><?php echo number_format($sub);?></font></div>
		<?php if($data['cmt'] != ''){ ?>
			<div class="col-xs-2"></div>
			<div class="col-xs-10"><font size="2"><?php echo '-- '.$data['cmt'];?></font></div>
		<?php 	
		}
		if($data['disc'] != ''){ ?>
			
			<div class="col-xs-6"><font size="2"><?php echo 'Disc @'.$data['nama_disc'];?></font></div>
			<div class="col-xs-6"><font size="2">( <?php echo number_format($dsc);?> )</font></div>
		<?php 	
		}			
	}
	?>
	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-4"><font size="2">Sub Total</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['sub_total']);?></font></div>

	<div class="col-xs-4"><font size="2">Disc Bill</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['disc']);?></font></div>

	<div class="col-xs-4"><font size="2">Svc</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['svc']);?></font></div>

	<div class="col-xs-4"><font size="2">Tax</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($info['tax']);?></font></div>

	<div class="col-xs-12">--------------------------------------------------</div>
	<div class="col-xs-6"><font size="2">Grand Total</font></div>
	<div class="col-xs-6"><font size="2">: <?php echo number_format($info['total']);?></font></div>
	<?php
	$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND no_bukti = '$trx'");
		while($pay = mysql_fetch_assoc($p)){ 
			$bayar = $bayar + $pay['nominal'];
			$kembali = $kembali + $pay['kembali'];
			?>
			<div class="col-xs-4"><font size="2"><?php echo $pay['jenis'];?></font></div>
			<div class="col-xs-2"><font size="2">:</font></div>
			<div class="col-xs-6"><font size="2"><?php echo number_format($pay['nominal']);?></font></div>
		<?php } ?>
	<div class="col-xs-4"><font size="2">Pembayaran</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($bayar);?></font></div>	
	<div class="col-xs-4"><font size="2">Kembali</font></div>
	<div class="col-xs-2"><font size="2">:</font></div>
	<div class="col-xs-6"><font size="2"><?php echo number_format($kembali);?></font></div>

	<div class="col-xs-12">--------------------------------------------------</div>
	<?php 
	$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$info['kasir']."'");
	$info2= mysql_fetch_array($w);
	?>
	<div class="col-xs-6"><font size="2">Cashier : <?php echo $info2['nama_waiter'];?></font></div>
	<div class="col-xs-6"><font size="2"><?php echo date("Y-m-d H:i:s");?></font></div>
	<?php
	if($config['footer_line1'] != ''){	?>
		<div class="col-xs-12">
			<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line1'];?></center></font></div>
		</div>
	<?php	
	}	
	if($config['footer_line2'] != ''){			?>
		<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line2'];?></font></center></div>
	<?php	
	}	
	if($config['footer_line3'] != ''){				?>
		<div class="col-xs-12"><center><font size="2"><?php echo $config['footer_line3'];?></font></center></div>
	<?php	
	}	?>


<?php // }
?>	
<script>

	var printContent = document.getElementById('billing_receipt').innerHTML;
    var original = document.body.innerHTML;

    document.body.innerHTML = printContent;
    //alert("elelel");
    window.print();
    document.body.innerHTML = original;  

</script>