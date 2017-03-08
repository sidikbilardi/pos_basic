<?php
session_start();
include "../database.php";
include "../inc/func.php";
//$q = mysql_query("SELECT * FROM (SELECT A.no_bukti,A.keterangan,B.kode_menu,B.qty,B.harga,A.svc,A.tax FROM tbltransorder_master A , tbltransorder_detail B where A.no_bukti = B.no_bukti AND A.status = 1 AND A.zstatus = '' AND LEFT(B.kode_menu,3) != 'DSC' AND LEFT(B.kode_menu,3) != 'CMT' ) Z LEFT JOIN (SELECT qty as qty_disc,harga as disc,no_bukti,kode_menu FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND RIGHT(Y.kode_menu,5) = Z.kode_menu");
$q = mysql_query("SELECT * FROM (SELECT A.no_bukti,A.keterangan,B.kode_menu,B.qty,B.harga,A.svc,A.tax,A.kode_meja FROM tbltransorder_master A , tbltransorder_detail B where A.no_bukti = B.no_bukti AND A.status = 1 AND A.zstatus = '' AND LEFT(B.kode_menu,3) != 'DSC' AND LEFT(B.kode_menu,3) != 'CMT' ) Z 
LEFT JOIN
(SELECT qty as qty_disc,harga as disc,no_bukti,kode_menu FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND RIGHT(Y.kode_menu,5) = Z.kode_menu
LEFT JOIN (select kode_meja,kode_lokasi from tblmastermeja ) X ON X.kode_meja = Z.kode_meja
LEFT JOIN (select kode_lokasi,svc as loc_svc,tax as loc_tax,nama_lokasi from tblmasterlokasi) W ON W.kode_lokasi = X.kode_lokasi ORDER BY Z.no_bukti");
$no = 0;
$rvoid = 0;
$bukti = '';
while($data = mysql_fetch_assoc($q)){
		if($bukti == $data['no_bukti'] ){
			$no++;
		}	
	$bukti = $data['no_bukti'];	
	$nom =0;
	$svc = 0;
	$tax = 0;
/*	$nom = $data['qty'] * $data['harga'];
	$disc = $data['qty_disc'] * $data['disc'];
	$svc = ($nom + $disc) * $data['svc'] / 100;
	$nominal = $nom + $disc +$svc;	
	$grs = $nom + $disc;
	$tax = $nominal * ($data['tax'] / 100);
	
	
$gross = $gross + $grs;	
$discount = $discount + $disc * -1;
$service = $service + $svc;
$tax_total = $tax_total + $tax;


	$sales = $close + $open;
*/
	$nom = $data['qty'] * $data['harga'];
	$disc = $data['qty_disc'] * $data['disc'];

	$discount = $discount - $disc ;
	
	$nom = $nom + $disc;
	$gr = $nom;
	if($data['loc_svc'] != ''){
		$svc = $svc + ($nom * $data['loc_svc'] /100);
	}else{
		$svc = $svc + ($nom * $data['svc'] /100);
	}
	
	$nom = $nom + $svc;
	if($data['loc_tax'] != ''){
		$tax = $tax + ($nom * $data['loc_tax'] /100 );
	}else{
		$tax = $tax + ($nom * $data['tax'] /100 );
	}
	
	$nom = $nom + $tax;
	if($data['keterangan'] == 'VOID'){
		$void = $void + $nom;
		$rvoid++;
	}else{
		$gross = $gross + $gr;
		$st = $st + $nom;
		$service = $service + $svc;
		$tax_total = $tax_total + $tax;
		if($data['keterangan'] == 'OPEN'){
			$open = $open + $nom ;
		}else{
			$close = $close + $nom ;
		}


		$pax = $pax + $data['qty'];
		
	}

/*
	
	$gross = $gross + $nom;
	
	$nom = $nom + $svc;
	$tax = $tax + ($nom * $data['tax'] /100);
	$service = $service + $svc;
	$tax_total = $tax_total+$tax;
	
	if($data['keterangan'] == 'CLOSE'){
		$close = $close + $nom + $tax ;
		$st = $gross + $service+$tax_total;
	$no++;
	$pax = $pax + $data['qty'];
	}else if($data['keterangan'] == 'OPEN'){
		$open = $open + $nom  + $tax;
		$st = $gross + $service+$tax_total;
	
	
	}else if($data['keterangan'] == 'VOID'){
		$void = $void + $nom  + $tax;
		$voidst = $gross + $service+$tax_total;
	}	
*/
}

$all_sales =  $st;
$average = $all_sales / $no;
$ave_pax = $all_sales / $pax

?>

<section class="content">
		<div class="row">
			<div class="box box-danger">
				
				<form id="XForm" name="XForm" method="POST" action="inc/proses_add.php?action=printXReport">
				<div class="col-lg-12">
					<div class="box-header">
						<h3 class="box-title">X - Report</h3>
					</div>
					<div class="box-body">
					<div class="callout callout-danger">
						<div class="form-group">
							<div>
								<label>Total Sales : </label>
								<?php echo number_format($all_sales) ?>
								<input type="hidden" class="form-control" id="all" name="all" value="<?php echo $all_sales; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Open Receipt : </label>
								<?php echo number_format($open) ?>
								<input type="hidden" class="form-control" id="open" name="open" value="<?php echo $open; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Close Receipt : </label>
								<?php echo number_format($close) ?>
								<input type="hidden" class="form-control" id="close" name="close" value="<?php echo $close; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>  </label>
							</div>
							<div>
								<label>Gross Sales : </label>
								<?php echo number_format($gross) ?>
								<input type="hidden" class="form-control" id="gross" name="gross" value="<?php echo $gross; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label> Discount : </label>
								<?php echo number_format($discount) ?>
								<input type="hidden" class="form-control" id="disc" name="disc" value="<?php echo $discount; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label> Service Charge : </label>
								<?php echo number_format($service) ?>
								<input type="hidden" class="form-control" id="svc" name="svc" value="<?php echo $service; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label> Tax : </label>
								<?php echo number_format($tax_total) ?>
								<input type="hidden" class="form-control" id="tax" name="tax" value="<?php echo $tax_total; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label> </label>
							</div>
							<div>
								<label> Total Receipt : </label>
								<?php echo $no; ?>
								<input type="hidden" class="form-control" id="receipt" name="receipt" value="<?php echo $no; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label> Average per Receipt : </label>
								<?php echo number_format($average) ?>
								<input type="hidden" class="form-control" id="average" name="average" value="<?php echo $average; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Total Pax : </label>
								<?php echo $pax; ?>
								<input type="hidden" class="form-control" id="pax" name="pax" value="<?php echo $pax; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Average per Pax : </label>
								<?php echo number_format($ave_pax) ?>
								<input type="hidden" class="form-control" id="ave_pax" name="ave_pax" value="<?php echo $ave_pax; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>  </label>
							</div>
							<div>
								<label>Sales Void : </label>
								<?php echo number_format($void) ?>
								<input type="hidden" class="form-control" id="void" name="void" value="<?php echo $void; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Receipt Void : </label>
								<?php echo $rvoid ?>
								<input type="hidden" class="form-control" id="rvoid" name="rvoid" value="<?php echo $rvoid; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>  </label>
							</div>
	<?php 
	$urut_cat = 1;
	$pr = mysql_query("select kode_cat,nama_cat,sum(qty) as qty,sum( (nominal*qty) - (IFNULL(cnt,0)*IFNULL(disc,0)) ) as nominal from (

SELECT * FROM (SELECT C.kode_cat,C.nama_cat,A.qty as qty,A.harga as nominal,A.kode_menu as kode FROM tbltransorder_detail A,tblmastermenu B,tblmastercategory C where A.kode_menu = B.kode_menu AND B.kode_cat = C.kode_cat AND A.status = 1 AND A.zstatus = '' AND LEFT(A.kode_menu,3) != 'DSC' AND LEFT(A.kode_menu,3) != 'CMT') Z LEFT JOIN 
( SELECT kode_menu,sum(qty*-1) as cnt,harga as disc from tbltransorder_detail where  LEFT(kode_menu,3) = 'DSC' and zstatus = '' ) Y ON Z.kode = RIGHT(Y.kode_menu,5) 
) X GROUP BY kode_cat");
	while($prd = mysql_fetch_assoc($pr)){ $jml_cat = $urut_cat;
		?> 
							<div>
								<label><?php echo $prd['nama_cat']." (#".$prd['qty'].") ";?> </label>
								<?php echo number_format($prd['nominal']) ?>
								<input type="hidden" class="form-control" id="cat_<?php echo $urut_cat;?>"  name="cat_<?php echo $urut_cat;?>" value="<?php echo $prd['kode_cat'].':'.$prd['nama_cat'].':'.$prd['qty'].':'.$prd['nominal']; ?>" placeholder="Harga"/>
								
							</div>
		
		<?php 
		$urut_cat++;
	}
	
	?>
								<input type="hidden" class="form-control" id="jml_cat"  name="jml_cat" value="<?php echo $jml_cat; ?>" placeholder="Harga"/>
		
<div class="box">
	<div class="box-body no-padding">
	<table class="table table-condensed">
		<thead>
			<th><?php echo getConf('tutup');?></th>
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
			$j = mysql_query("SELECT * FROM (SELECT HOUR(B.time_order) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt , sum(B.qty * B.harga) as total FROM tbltransorder_detail B,tbltransorder_master A WHERE HOUR( B.time_order ) = '".$x."' AND A.zstatus =  '' AND B.status =1 AND LEFT( B.kode_menu, 3 ) <>  'CMT' AND LEFT( B.kode_menu, 3 ) <>  'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan != 'VOID' ) A 

LEFT JOIN ( SELECT HOUR(time_order) as JAM, sum(harga*qty*-1) as DISC FROM tbltransorder_detail where LEFT( kode_menu, 3 ) =  'DSC' AND zstatus = '') B ON HOUR( A.JAM ) =  HOUR( B.JAM )");
			
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
	</div>
</div>	
							<div>
								<label>PAYMENT COLLECTION </label>
							</div>
<?php
	$urut_pay = 1;
			$pay = mysql_query("SELECT jenis,sum(nominal) as nominal, sum(kembali) as kembali  FROM tbltransorder_master A,tbltranspayment B where A.no_bukti = B.no_bukti AND A.zstatus = '' and A.status = 1 GROUP BY B.jenis");
			while($payment = mysql_fetch_assoc($pay)){ $jml_pay = $urut_pay;
				$kembali = $kembali + $payment['kembali']*-1;
?>				
							<div>
								<label><?php echo $payment['jenis'];?> : </label>
								<?php echo number_format($payment['nominal']) ?>
								<input type="hidden" class="form-control" id="pay_<?php echo $urut_pay;?>" name="pay_<?php echo $urut_pay;?>" value="<?php echo  $payment['jenis'].':'.$payment['nominal']; ?>" placeholder="Harga"/>
								
							</div>
				
<?php			$urut_pay++;} 
?>							
							<div>								<input type="hidden" class="form-control" id="jml_pay" name="jml_pay" value="<?php echo $jml_pay; ?>" placeholder="Harga"/>

								<label>PAID OUT : </label>
								( <?php echo number_format($kembali) ?> )
								<input type="hidden" class="form-control" id="pay_out" name="pay_out" value="<?php echo $kembali; ?>" placeholder="Harga"/>
															
							</div>
</form>				
					<div class="box-footer">
						<!--button onClick="PrintXReport('<?php echo $_SESSION['logged_id']; ?>')" class="btn btn-primary">Print</button-->
						<button type="submit" class="btn btn-primary">Print</button>
						<button onClick="CancelMenu()" class="btn btn-danger">OK</button>
					</div>	
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>
	
		<script>
		
$("#XForm").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();
      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("X - Report Berhasil diprint");
		$.fancybox.close();
      });
    });
function PrintXReport(id){
	
	
/*		var konfirmasi=confirm("Apakah Anda yakin print X-Report ? ");
		if (konfirmasi==true)
		{
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=printXReport&id="+id,
			cache: false,
			success: function(msg){
				//$("#fancybox").hide();
				
				alert(msg);
				$.fancybox.close();

		}});
			
		}
*/		
}		
		</script>		