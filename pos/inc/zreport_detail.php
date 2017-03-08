<?php

include"../database.php";
include "../inc/func.php";
$trx = trim($_GET['id']);
$conf = mysql_query("SELECT * FROM tblutilitysetting");
$config = mysql_fetch_array($conf);

echo "<strong>Z - R E P O R T</strong></br>";
echo "<strong>".$config['resto_name']."</strong></br>";
if($config['resto_add1'] != ''){	
	echo "<small>".$config['resto_add1']."</small></br>";
	
}
if($config['resto_add2'] != ''){	
	echo "<small>".$config['resto_add2']."</small></br>";
}
echo "<strong>Reprint</strong></br>";
echo "-----------------------------------------------------</br>";
$z = mysql_query("SELECT *,A.id as id_petty FROM tbl_pettycash A,tblmasterwaiter B where A.user = B.kode_waiter AND A.zstatus='$trx' ");	
while($zr = mysql_fetch_assoc($z)){
	$in = date("H:i:s",$zr['in_time']);
	$out = date("H:i:s",$zr['out_time']);
	$sub_total = 0;
	$disc = 0;
	$svc = 0;
	$tax = 0;
	$total = 0;
	$total_void = 0;
	$j_cash = 0;
	$j_dbt = 0;				
	$j_cc = 0;
	$j_vch = 0;
	$memb = 0;
	$cust = 0;
	$cust_void = 0;
	$cash = 0;
	$debit = 0;
	$cc = 0;
	$vch = 0;
	$sub_total_void = 0;
	$disc_void = 0;
	$tax_void = 0;
	$total_void = 0;
	$sub_total = 0;
	$disc = 0;
	$tax = 0;
	$total = 0;
	?>
	<div class="col-xs-12"><?php echo "<font size='2'>".$zr['kode_waiter'].' - '.$zr['nama_waiter']." Closing : ".number_format($zr['close_nominal'])."</font>";
?></div>
	<div class="col-xs-12"><?php 	echo "<font size='2'>".$zr['in_time'].' - '.$zr['out_time']."</font>";
 ?></div> 
	<div class="col-xs-12">
		<div class="col-xs-6">Opening Total</div>
		<div class="col-xs-6">: <?php echo number_format($zr['modal']);?></div>
	</div> 
	<?php
	$waiter = $zr['nama_waiter'];
	$kd = $zr['kode_waiter'];
$s = mysql_query("SELECT A.sub_total,A.disc,A.svc,A.tax,A.total,B.keterangan,B.kode_cust FROM tbltrans_summary A,tbltransorder_master B where A.zstatus = '$trx' AND A.no_bukti = B.no_bukti AND (B.keterangan = 'CLOSE' OR B.keterangan = 'VOID') AND A.pettycash = '".$zr['id_petty']."' AND A.user = '".$zr['kode_waiter']."' ");
	while($ss = mysql_fetch_assoc($s)){
		if($ss['jenis'] == 'VOID'){
			$sub_total_void = $sub_total_void + $ss['sub_total'];
			$disc_void = $disc_void + $ss['disc'];
			$svc_void = $svc_void + $ss['svc'];
			$tax_void = $tax_void + $ss['tax'];
			$total_void = $total_void + $ss['total'];
			$cust_void++;

		}else{
			$sub_total = $sub_total + $ss['sub_total'];
			$disc = $disc + $ss['disc'];
			$svc = $svc + $ss['svc'];
			$tax = $tax + $ss['tax'];

			$total = $total + $ss['total'];
			$cust++;
			if($ss['kode_cust'] != 0){
				$memb++;
			}
		}
		
	}
	$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND zstatus = '$trx' AND pettycash ='".$zr['id_petty']."' AND user ='".$zr['kode_waiter']."' ");
	while($pp = mysql_fetch_array($p)){
		if($pp['jenis'] == 'CSH'){
			$cash = $cash + $pp['nominal'] + $pp['kembali'];
			$j_cash++;
		}else if($pp['jenis'] == 'DBT'){
			$debit = $debit + $pp['nominal'];
			$j_dbt++;
		}else if($pp['jenis'] == 'CC'){
			$cc = $cc + $pp['nominal'];
			$j_cc++;
		}else if($pp['jenis'] == 'VCH'){
			$vch = $vch + $pp['nominal'];
			$j_vch++;
		}
	} ?>	
	<div class="col-xs-12">
		<div class="col-xs-6">Total Sales</div>
		<div class="col-xs-6">: <?php echo number_format($sub_total);?></div>
	</div> 
	<div class="col-xs-12">
		<div class="col-xs-6">Total Disc</div>
		<div class="col-xs-6">: <?php echo number_format($disc);?></div>
	</div> 	
	<div class="col-xs-12">
		<div class="col-xs-6">Total svc</div>
		<div class="col-xs-6">: <?php echo number_format($svc);?></div>
	</div> 	
	<div class="col-xs-12">
		<div class="col-xs-6">Total tax</div>
		<div class="col-xs-6">: <?php echo number_format($tax);?></div>
	</div> 	
	<div class="col-xs-12">
		<div class="col-xs-6">Grand Total</div>
		<div class="col-xs-6">: <?php echo number_format($total);?></div>
	</div> 	
	<div class="col-xs-12"></br></div> 					
	<div class="col-xs-12">
		<div class="col-xs-6"> Cash</div>
		<div class="col-xs-6">: <?php echo number_format($cash);?></div>
	</div> 	
	<?php
	if($debit != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Debit</div>
			<div class="col-xs-6">: <?php echo number_format($debit);?></div>
		</div> 								
	<?php }	?>
	<?php
	if($cc != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Credit</div>
			<div class="col-xs-6">: <?php echo number_format($cc);?></div>
		</div> 								
	<?php }	?>	
	<?php
	if($vch != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Voucher</div>
			<div class="col-xs-6">: <?php echo number_format($vch);?></div>
		</div> 								
	<?php } ?>
	<div class="col-xs-12"></br></div>
	<div class="col-xs-12">
		<div class="col-xs-6">Cust Count</div>
		<div class="col-xs-6">: <?php echo number_format($cust);?></div>
	</div>	

	<?php
	if($memb != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Member</div>
			<div class="col-xs-6">: <?php echo number_format($memb);?></div>
		</div> 								
	<?php } ?>	
	<?php
	if($j_cash != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Cash Count</div>
			<div class="col-xs-6">: <?php echo number_format($j_cash);?></div>
		</div> 								
	<?php } ?>	
	<?php
	if($j_dbt != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Debit Count</div>
			<div class="col-xs-6">: <?php echo number_format($j_dbt);?></div>
		</div> 								
	<?php } ?>	
	<?php
	if($j_cc != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Credit Count</div>
			<div class="col-xs-6">: <?php echo number_format($j_cc);?></div>
		</div> 								
	<?php } ?>	
	<?php
	if($j_vch != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6"> Voucher Count</div>
			<div class="col-xs-6">: <?php echo number_format($j_vch);?></div>
		</div> 								
	<?php } ?>	
	<?php
	if($total_void != 0){ ?>
		<div class="col-xs-12">
			<div class="col-xs-6">Return / Void</div>
			<div class="col-xs-6">: <?php echo number_format($total_void);?></div>
		</div> 								
	<?php } ?>						
	<?php echo "-----------------------------------------------------</br>";?>
<?php }
?>
<div class="col-xs-12"><strong>Credit Summary</strong></div>
<?php
$i = mysql_query("SELECT nama_issuer,SUM(nominal) as nom,B.kode_issuer FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND C.kode_issuer= B.kode_issuer GROUP by B.kode_issuer");
while($is = mysql_fetch_assoc($i)){ ?>
	<div class="col-xs-12">
		<div class="col-xs-6"><?php echo $is['nama_issuer'];?></div>
		<div class="col-xs-6">: <?php echo number_format($is['nom']);?></div>
	</div>
	<?php
		$cc = mysql_query("SELECT no_kartu,nama_bank,nominal FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND B.kode_issuer ='".$is['kode_issuer']."'  AND C.kode_issuer= B.kode_issuer ");
		while($cc_d = mysql_fetch_assoc($cc)){ ?>
			<div class="col-xs-12">
				<div class="col-xs-7"><?php echo $cc_d['nama_bank'].' - '.$cc_d['no_kartu'];?></div>
				<div class="col-xs-5">: <?php echo number_format($cc_d['nominal']);?></div>
			</div>

		<?php }
	?>	
<?php } ?>
<div class="col-xs-12"><strong>Category Summary</strong></div>
<?php
$ct = mysql_query("SELECT * FROM tblmastercategory where status = 1");
while($d_ct = mysql_fetch_assoc($ct)){ ?>
	<div class="col-xs-12"><strong><?php echo $d_ct['nama_cat'];?></strong></div>
<?php 	$qd_cat = mysql_query("select nama_menu,kode as kode,nama_cat,nominal,IFNULL(cnt,0)*IFNULL(disc,0) as discount,sum(qty) as qty,sum( (nominal*qty) - (IFNULL(cnt,0)*IFNULL(disc,0)) ) as TOTAL from (SELECT * FROM (SELECT B.nama_menu,C.kode_cat,C.nama_cat,A.qty as qty,A.harga as nominal,A.kode_menu as kode FROM tbltransorder_detail A,tblmastermenu B,tblmastercategory C where A.kode_menu = B.kode_menu AND B.kode_cat = C.kode_cat AND A.status = 1 AND A.zstatus = '$trx' AND B.kode_cat = '".$d_ct['kode_cat']."' AND LEFT(A.kode_menu,3) != 'DSC' AND LEFT(A.kode_menu,3) != 'CMT') Z LEFT JOIN ( SELECT kode_menu,sum(qty*-1) as cnt,harga as disc from tbltransorder_detail where  LEFT(kode_menu,3) = 'DSC' and zstatus = '' ) Y ON Z.kode = RIGHT(Y.kode_menu,5) ) X GROUP BY kode ORDER BY nama_menu");
		while($d_cat = mysql_fetch_assoc($qd_cat)){
			if($d_cat['discount'] != 0){
				$disc_cate = ' - '.$d_cat['discount'];
			}else{
				$disc_cate = '';
			} ?>
			<div class="col-xs-12">
				<div class="col-xs-1"></div>
				<div class="col-xs-11">
					<?php echo $d_cat['nama_menu'].' - '.$d_cat['kode'];?>
				</div>
			</div> 	
			<div class="col-xs-12">
				<div class="col-xs-1"></div>
				<div class="col-xs-11">
				<?php echo number_format($d_cat['nominal']).' x '.$d_cat['qty'].$disc_cate.' = '.number_format($d_cat['TOTAL']);?>
				</div>
			</div>		
		<?php }
		
}
?>
	<?php echo "-----------------------------------------------------</br>";?>
	<table class="table table-condensed">
		<thead>
			<th>#</th>
			<th>:</th>
			<th>#Trx</th>
			<th>Tot Bill</th>
			<th>Ave Bill</th>
		</thead>
		<tbody>
		<?php
		$urut_hr = getConf('buka');
		$buka = getConf('buka');
		$tutup =getConf('tutup');

		for ($x = $buka; $x <= $tutup; $x++) {
					
			if ($x < 10){
				$x = '0'.$x; 
			}
			$j = mysql_query("select HOUR(A.time_out) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt,A.no_bukti,A.kode_meja,A.kode_cust,A.kasir,A.disc as disc_bill,A.svc as svc_bill,A.tax as tax_bill,A.per,B.sub_total,B.disc,B.svc,B.tax,sum(B.total) as total,A.zstatus,A.keterangan from tbltransorder_master A , tbltrans_summary B where A.no_bukti = B.no_bukti AND A.status = 1 AND A.zstatus = '$trx' AND HOUR( A.time_out ) = '".$x."' AND A.keterangan != 'VOID'");
			
			while($jam = mysql_fetch_assoc($j)){
				$sum = $jam['total'] - $jam['DISC'];
				$ave = $sum / $jam['cnt'];
			if($ave == ''){ $ave = 0; }
			
?>			<tr>
				<td><?php echo $x;?></td>
				<td>:</td>
				<td><?php echo $jam['cnt'];?></td>
				<td><?php echo number_format($sum);?></td>
				<td><?php echo number_format($ave);?> 
								<input type="hidden" class="form-control" id="hr_<?php echo $urut_hr;?>" name="hr_<?php echo $urut_hr;?>" value="<?php echo $x.':'.$jam['cnt'].':'.$sum.':'.$ave; ?>" placeholder="Harga"/>
				</td>
			</tr>
<?php				
			}
			$urut_hr++;
?>

<?php		} 
		?>
		<input type="hidden" class="form-control" id="tutup" name="tutup" value="<?php echo $buka.':'.$tutup;?>"placeholder="Harga"/>

		</tbody>
	</table>
<div class="col-xs-12"><strong>PAYMENT COLLECTION</strong></div>
<?php
	$urut_pay = 1;
		$pay = mysql_query("SELECT jenis,sum(nominal) as nominal, sum(kembali) as kembali  FROM tbltransorder_master A,tbltranspayment B where A.no_bukti = B.no_bukti AND A.zstatus = '$trx' and A.status = 1 GROUP BY B.jenis");
		while($payment = mysql_fetch_assoc($pay)){ $jml_pay = $urut_pay;
			$kembali = $kembali + $payment['kembali']*-1; 
			?>				
			<div class="col-xs-12">
				<div class="col-xs-6"><?php echo $payment['jenis'];?></div>
				<div class="col-xs-6">: <?php echo number_format($payment['nominal']);?></div>
			</div> 	
			
<?php			$urut_pay++;} 
?>					<div class="col-xs-12">
				<div class="col-xs-6">PAID OUT</div>
				<div class="col-xs-6">: ( - <?php echo number_format($kembali);?> )</div>
			</div> 					

<script>
	    	var printContent = document.getElementById('zreport_detail').innerHTML;
		    var original = document.body.innerHTML;

		    document.body.innerHTML = printContent;
		    //alert("elelel");
		    window.print();
		    document.body.innerHTML = original;  		

</script>