<?php
include"../database.php";
$start = $_GET['start'];
$end = $_GET['end'];
$pilih = $_GET['pilih'];

if($pilih == 1){
	$judul = '<h4>Detail Sales Analysis Report<h4>';
	$no = 1;
	?>
<div class="col-lg-6">
	<div class="box">
	    <div class="box-header">
	      <h3 class="box-title"><?php echo $judul; ?></h3>
	    </div><!-- /.box-header -->
	    <div class="box-body no-padding">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
	          <th style="width: 10px">#</th>
	          <th>Category</th>
	          <th>Qty</th>
	          <th style="width: 40px">Subtotal</th>
	          <th style="width: 40px">Disc</th>
	          <th style="width: 40px">Total</th>   
	          <th style="width: 40px"></th>                    
	        </tr>
	        <?php
	        //$c = mysql_query("SELECT kode_cat,nama_cat,sum(total) as total,sum(jml) as jml,sum(disc) as disc from (SELECT D.nama_cat,C.kode_cat,B.kode_menu as kode,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C,tblmastercategory D WHERE C.kode_cat = D.kode_cat AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1'  AND B.time_order >= '$start 00:00:00' AND B.time_order <= '$end 24:00:00' GROUP BY kode_cat) master 
			//	LEFT JOIN 
			//	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status = '1' AND B.time_order >= '$start 00:00:00' AND B.time_order <= '$end 24:00:00' GROUP BY kode_menu ) Z ON  master.kode = RIGHT(Z.kode_menu,5)");
			$c = mysql_query("SELECT * FROM (SELECT C.kode_cat,B.kode_menu as kode,C.nama_menu,D.nama_cat,sum(B.qty) as jml,SUM(B.harga*B.qty) as total,sum(B.harga) as harga FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C,tblmastercategory D WHERE A.no_bukti = B.no_bukti AND B.kode_menu = C.kode_menu AND A.keterangan = 'CLOSE' AND C.kode_cat = D.kode_cat AND LEFT(B.kode_menu,3) != 'DSC' AND B.time_order >= '$start 00:00:00' AND B.time_order <= '$end 24:00:00' GROUP BY D.kode_cat ) master
LEFT JOIN 
				(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status = '1' AND B.time_order >= '$start 00:00:00' AND B.time_order <= '$end 24:00:00' GROUP BY kode_menu ) Z ON  master.kode = RIGHT(Z.kode_menu,5)");
			while($cat = mysql_fetch_assoc($c)){
				$group = 0;
				$subtotal = $cat['total']-($cat['disc']*-1);
		        $name_cat = str_replace(' ','%20',$cat['nama_cat']);
		        $total_all += $subtotal;
		        $total_qty += $cat['jml'];

				 ?>
		        <tr onClick="detailAnalysis('<?php echo $cat['kode_cat'];?>','<?php echo $start;?>','<?php echo $end;?>','<?php echo $name_cat;?>','1')">
		          <th style="width: 10px"><?php echo $no;?></th>
		          <th><?php echo $cat['nama_cat'];?></th>
		          <th style="width: 40px"><?php echo $cat['jml'];?></th>
		          <th ><?php echo number_format($cat['total']);?></th>
		          <th >( -<?php echo $cat['disc'];?> )</th>
		          <th ><?php echo number_format($subtotal);?></th> 
		          <th ><div><span class="glyphicon glyphicon-zoom-in"></span></div></th>                      
		        </tr>

			<?php
				$no++;
			}
	        ?>
		        <tr >
		          <th style="width: 10px"></th>
		          <th>TOTAL :</th>
		          <th style="width: 40px"><?php echo $total_qty;?></th>
		          <th ></th>
		          <th ></th>
		          <th ><?php echo number_format($total_all);?></th> 
		          <th ></th>                      
		        </tr>

	      </tbody></table>
	    </div><!-- /.box-body -->
	</div>	
</div>
<div class="col-lg-6">
	<div id="detail_preview_report"></div>
</div>
	<?php
}elseif($pilih == 2){
	$judul = '<h4>Hourly Sales Report<h4>';
	$no = 1;


	?>
<div class="col-lg-12">
<?php
	$date = $start;
	$end_date = $end;
	$arr = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		//echo $date;
		$arr_date[] = $date;
		$z = 0;
		$detail = '';
		while($z <= 23){

			$q = mysql_query("select HOUR(A.time_out) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt,A.no_bukti,A.kode_meja,A.kode_cust,A.kasir,A.disc as disc_bill,A.svc as svc_bill,A.tax as tax_bill,A.per,B.sub_total,B.disc,B.svc,B.tax,sum(B.total) as total,A.zstatus,A.keterangan from tbltransorder_master A , tbltrans_summary B where A.no_bukti = B.no_bukti AND A.status = 1 AND A.zstatus = '' AND A.time_out > '".$date." 00:00:00' AND A.time_out < '".$date." 24:00:00' AND HOUR( A.time_out ) = '".$z."' AND A.keterangan != 'VOID'");
			while($dt = mysql_fetch_assoc($q)){

				$ttl = $dt['total'];
				if($ttl == 0){
					$total = 0;
				}else{
					$total = $dt['total'] - ($dt['DISC']*-1);
				}
					//$arr_date_detail = 
					//$arr_date[$arr][] = $total;
					$detail .= $total.',';
					//echo $arr_date[$arr][$z];
					//echo $arr_date[$z].$total.'|';
					//echo $arr_date[$z];
								
			}
			//echo $z;

			$z++;		
		}
		$data .= $date.'*'.$detail.'|';
		
		$arr++;
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

	}
	//echo $data;
	
?>	
	<div class="box">
	    <div class="box-header">
	      <h3 class="box-title"><?php echo $judul; ?></h3>
	    </div><!-- /.box-header -->
	    <div class="box-body no-padding">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
		        <th style="width: 90px">Date</th>
		        <th style="width: 10px">Hour</th>
		        <th>00</th>
		        <th >02</th>
		        <th >04</th>
		        <th >06</th>   
		        <th >08</th>   
	            <th >10</th>                    
	            <th >12</th>   
	            <th >14</th> 
	            <th >16</th>
	            <th >18</th>  
	            <th >20</th>
	            <th >22</th>               
	        </tr>


	        <tr>
		        <th ></th>
		        <th></th>
		        <th>01</th>
		        <th >03</th>
		        <th >05</th>
		        <th >07</th>   
		        <th >09</th>   
	            <th >11</th>                    
	            <th >13</th>   
	            <th >15</th> 
	            <th >17</th>
	            <th >19</th>  
	            <th >21</th>
	            <th >23</th>               
	        </tr>	        
<?php
	$all = explode('|',$data);
	foreach($all as $element)
	{
		$tgl = explode('*',$element);
		$data_hour = explode(',',$tgl[1]);
		//echo $element.'<br/>';
		if($element != ''){
		?>
	        <tr>
		        <th ><?php echo $tgl[0]; ?></th>
		        <th></th>
		       
		        <th ><?php echo number_format($data_hour[0]); ?></th>
		        <th ><?php echo number_format($data_hour[2]); ?></th>
		        <th ><?php echo number_format($data_hour[4]); ?></th>
		        <th ><?php echo number_format($data_hour[6]); ?></th>   
		        <th ><?php echo number_format($data_hour[8]); ?></th>   
	            <th ><?php echo number_format($data_hour[10]); ?></th>                    
	            <th ><?php echo number_format($data_hour[12]); ?></th>   
	            <th ><?php echo number_format($data_hour[14]); ?></th> 
	            <th ><?php echo number_format($data_hour[16]); ?></th>
	            <th ><?php echo number_format($data_hour[18]); ?></th>  
	            <th ><?php echo number_format($data_hour[20]); ?></th>
	            <th ><?php echo number_format($data_hour[22]); ?></th>               
	        </tr>	
	        <tr>
		        <th ></th>
		        <th></th>
		       
		        <th ><?php echo number_format($data_hour[1]); ?></th>
		        <th ><?php echo number_format($data_hour[3]); ?></th>
		        <th ><?php echo number_format($data_hour[5]); ?></th>
		        <th ><?php echo number_format($data_hour[7]); ?></th>   
		        <th ><?php echo number_format($data_hour[9]); ?></th>   
	            <th ><?php echo number_format($data_hour[11]); ?></th>                    
	            <th ><?php echo number_format($data_hour[13]); ?></th>   
	            <th ><?php echo number_format($data_hour[15]); ?></th> 
	            <th ><?php echo number_format($data_hour[17]); ?></th>
	            <th ><?php echo number_format($data_hour[19]); ?></th>  
	            <th ><?php echo number_format($data_hour[21]); ?></th>
	            <th ><?php echo number_format($data_hour[23]); ?></th>               
	        </tr>		        

		<?php
		}
	}
?>

	      </tbody></table>
	    </div><!-- /.box-body -->
	</div>	
</div>

	<?php

}elseif($pilih == 3){
	$judul = '<h4>Sales Audit Listing Report<h4>';
	$no = 1;
	?>
<div class="col-lg-6">
	<div class="box">
	    <div class="box-header">
	      <h3 class="box-title"><?php echo $judul; ?></h3>
	    </div><!-- /.box-header -->
	    <div class="box-body no-padding">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
	          <th style="width: 10px">#</th>
	          <th style="width: 70px">No.Bukti</th>
	          <th style="width: 200px">Date</th>
	          <th style="width: 50px">Cashier</th>
	          <th style="width: 50px">Table</th>
	          <th style="width: 100px">Total</th>   
	          <th ></th>                    
	        </tr>
<?php	$q = mysql_query("SELECT * FROM(SELECT A.*,B.nama_meja FROM tbltransorder_master A,tblmastermeja B where A.time_out > '".$start." 00:00:00' AND A.time_out < '".$end." 24:00:00' AND A.keterangan != 'OPEN' AND A.kode_meja = B.kode_meja ORDER BY no_bukti) Z LEFT JOIN tbltrans_summary Y ON Z.no_bukti = Y.no_bukti LEFT JOIN (SELECT kode_waiter,nama_waiter from tblmasterwaiter ) X ON X.kode_waiter = Z.kasir");
	while($rs = mysql_fetch_assoc($q)){
		if($rs['keterangan'] == 'VOID'){
			$remark = "( VOID )";
		}else{
			$remark = "";
		} ?>

	        <tr onClick="detailAnalysis('<?php echo $rs['no_bukti'];?>','<?php echo $start;?>','<?php echo $end;?>','<?php echo $rs['no_bukti'];?>','2')">
	          <th style="width: 10px"><?php echo $no;?></th>
	          <th><?php echo $rs['no_bukti'];?></th>
	          <th><?php echo $rs['time_out'];?></th>
	          <th><?php echo $rs['nama_waiter'];?></th>
	          <th ><?php echo $rs['nama_meja'];?></th>
	          <th ><?php echo number_format($rs['total']);?></th>   
	          <th style="width: 40px"></th>                    
	        </tr>		
<?php 	$no++; }
?>
		        <tr >
		          <th style="width: 10px"></th>
		          <th>TOTAL :</th>
		          <th style="width: 40px"><?php echo $total_qty;?></th>
		          <th ></th>
		          <th ></th>
		          <th ><?php echo number_format($total_all);?></th> 
		          <th ></th>                      
		        </tr>

	      </tbody></table>
	    </div><!-- /.box-body -->
	</div>	
</div>
<div class="col-lg-6">
	<div id="detail_preview_report"></div>
</div>
	<?php
}elseif($pilih == 4){
	$judul = '<h4>Summary Consolidate Report<h4>';
	$no = 1;

	$m = mysql_query("select A.no_bukti,A.keterangan,C.nama_meja,D.nama_lokasi,D.takeaway,B.pax,B.sub_total,B.disc,B.svc,B.tax,B.total from tbltransorder_master A , tbltrans_summary B,tblmastermeja C,tblmasterlokasi D where C.kode_lokasi = D.kode_lokasi AND A.kode_meja = C.kode_meja AND A.no_bukti = B.no_bukti AND A.status = 1 AND A.keterangan != 'OPEN' AND A.time_out  >'".$start." 00:00:00' AND A.time_out < '".$end."24:00:00' ");	
	while($mm = mysql_fetch_assoc($m)) {
		if($mm['keterangan'] == 'VOID'){
			$sls_void += $mm['total'];
		}else{
			if($mm['takeaway'] == 'on'){
				$tkw += $mm['total'];
			}else{
				$dine += $mm['total'];
			}
			$pax += $mm['pax'];
			$check++;
			$netto += $mm['sub_total'];
			$disc_all += $mm['disc'];
			$svc_all += $mm['svc'];
			$tax_all += $mm['tax'];
			$sls_all += $mm['total'];			
		}
	}			

	$avg_pax = $netto / $pax;
	$avg_chk = $netto / $check;


	?>
<div class="col-lg-12" style="border-style: solid;border-width:1px">
<strong><?php echo $judul; ?></strong>
	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom:10px">
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Net Sales Total 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($netto);?>
		</div>

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Disc Bill Total 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($disc_all);?>
		</div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Svc Charge Total  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($svc_all);?>
		</div>	
			
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Tax Collected  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($tax_all);?>
		</div>			
			
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Total Revenue  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($sls_all);?>
		</div>		

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Return  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($sls_void);?>
		</div>	
		<div class="row" style="padding-bottom:5px">
			
		</div>	
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			<strong>Sales Group </strong> 
		</div>
		<div class="col-lg-5 col-md-5"></div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Dine in  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($dine);?>
		</div>									

		<div class="col-lg-7 col-md-7" style="padding-bottom:15px">
			Take away  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($tkw);?>
		</div>	


		
		<div class="col-lg-12 col-md-12" style="padding-bottom:5px">
			<strong>Sales </strong> 
		
		
			
		      <table class="table table-striped">
		        <tbody>
		        <tr>
		          <th >Category</th>
		          <th >Sales</th>
		          <th >Disc</th>
		                             
		        </tr>		        	
		<?php
		$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
		while($cat = mysql_fetch_assoc($c)){
			$nom = 0;
			$disc = 0;
			$t = mysql_query("
			SELECT * FROM(
			select A.kode_cat,B.*,sum(B.qty*B.harga) as total from tblmastermenu A,tbltransorder_detail B,tbltransorder_master C where B.status = 1 AND B.kode_menu = A.kode_menu AND C.no_bukti = B.no_bukti AND C.keterangan = 'CLOSE' AND A.kode_cat = '".$cat['kode_cat']."' AND B.time_order > '".$start." 00:00:00' AND B.time_order < '".$end." 24:00:00' GROUP BY B.kode_menu) S 
			LEFT JOIN
			(select kode_menu,SUM(harga*qty) as DISC from tbltransorder_detail where LEFT(kode_menu,3) = 'DSC' AND time_order > '".$start." 00:00:00' AND time_order < '".$end." 24:00:00' AND status = 1  GROUP BY kode_menu) T ON S.kode_menu = RIGHT(T.kode_menu,5)
			");
			while($tr = mysql_fetch_assoc($t)){
				$tr['DISC'] = $tr['DISC']*-1;
			$nom = $nom + ($tr['total'] - $tr['DISC']);
			$disc = $disc + $tr['DISC'];
			
			$t_nom = $t_nom + $tr['total'] - $tr['DISC'];
			$t_disc = $t_disc + $tr['DISC'];
			}			
			?>

		        <tr>
		          <td ><?php echo $cat['nama_cat'];?></td>
		          <td ><?php echo number_format($nom);?></td>
		          <td ><?php echo number_format($disc);?></td>
		                             
		        </tr>


			<?php
		}
		?>		
			    </tbody>
		</table>	
</div>
		


	</div>
	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom:10px">
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Net Sales Total 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($netto);?>
		</div>
			
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			No. of Pax 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($pax);?>
		</div>		
		
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			No. of Checks
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($check);?>
		</div>	
		<div class="col-lg-7 col-md-7" style="padding-bottom:20px"></div>
		<div class="col-lg-5 col-md-5"></div>			
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Average PAX Spending
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($avg_pax);?>
		</div>	
		
		<div class="col-lg-7 col-md-7" style="padding-bottom:15px">
			Average Check Spending
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($avg_chk);?>
		</div>		

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			<strong>TAX & SVC </strong> 
		</div>
		<div class="col-lg-5 col-md-5"></div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			TAX  
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($tax_all);?>
		</div>									

		<div class="col-lg-7 col-md-7" style="padding-bottom:15px">
			SVC
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($svc_all);?>
		</div>	

		<div class="col-lg-12 col-md-12" style="padding-bottom:15px">
			<strong>Payment </strong> 
		
		
			
		      <table class="table table-striped">
		        <tbody>
		        <tr>
		          <th >Type</th>
		          <th >Sales Total</th>
		      	</tr>
					<?php
					$b_q = mysql_query("SELECT B.no_bukti,B.tanggal,B.jenis,B.bank,B.nominal,B.kembali FROM tbltransorder_master A,tbltranspayment B where A.status = 1 AND A.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND B.tanggal > '".$start." 00:00:00' AND B.tanggal < '".$end." 24:00:00'");					
					while($bank = mysql_fetch_assoc($b_q)){
						if($bank['jenis'] == 'CSH'){
							$cash = $cash + ($bank['nominal'] - ($bank['kembali']*-1));
						}else if($bank['jenis'] == 'DBT'){
							$debit = $debit + ($bank['nominal'] - ($bank['kembali']*-1));
						}else if($bank['jenis'] == 'VCH'){
							$vch = $vch + ($bank['nominal'] - ($bank['kembali']*-1));
						}else{
							$CC = $CC +($bank['nominal'] -($bank['kembali']*-1));
						}
						
					} ?>
				        <tr>
				          <td >Debit</td>
				          <td >: <?php echo number_format($debit);?> </td>
				      	</tr>
				        <tr>
				          <td >Cash</td>
				          <td >: <?php echo number_format($cash);?> </td>
				      	</tr>				      		<?php				
					$c_q = mysql_query("SELECT * FROM (SELECT B.no_bukti,B.tanggal,B.jenis,B.bank,SUM(B.nominal) as payment,SUM(B.kembali) as kembali FROM tbltransorder_master A,tbltranspayment B where B.jenis = 'CC' AND A.status = 1 AND A.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND B.tanggal > '".$start." 00:00:00' AND B.tanggal < '".$end." 24:00:00' GROUP BY B.bank) M LEFT JOIN (SELECT * FROM tblmasterbank where status = 1 ) N ON M.bank = N.kode_bank
					LEFT JOIN ( SELECT * FROM tblmasterissuer where status = 1 ) O ON N.kode_issuer = O.kode_issuer");

					while($card = mysql_fetch_assoc($c_q)){
						$nom_cc = $card['payment'] - $card['kembali']; ?>
				        <tr>
				          <td ><?php echo $card['nama_issuer'].' - '.$card['nama_bank'];?></td>
				          <td >: <?php echo number_format($nom_cc);?> </td>
				      	</tr>	<?php					
						
						$g_cc = $g_cc + $nom_cc;		
						//$row2++;
					}	
					$g_total = $g_cc + $vch + $debit + $cash; ?>
				        <tr>
				          <th >Total</th>
				          <th >: <?php echo number_format($g_total);?> </th>
				      	</tr>			
							         
	                             
		        		        	
	
			    </tbody>
			</table>	
		</div>

		<div class="col-lg-12 col-md-12" style="padding-bottom:5px">
			<strong>Disc per item </strong> 
		
		
			
		      <table class="table table-striped">
		        <tbody>
		        <tr>
		          <th >Name</th>
		          <th >Disc Total</th>
		      	</tr> <?php
				$dsc = mysql_query("SELECT C.nama_disc, SUM(B.harga*B.qty) as DISC FROM tbltransorder_master A,tbltransorder_detail B, tblmasterdisc C WHERE A.no_bukti = B.no_bukti AND B.comment = C.kode_disc AND LEFT(B.kode_menu,3) = 'DSC' AND A.keterangan = 'CLOSE' AND B.time_order > '".$start." 00:00:00' AND B.time_order < '".$end." 24:00:00' GROUP BY C.kode_disc");
				
				while($dsc_t = mysql_fetch_assoc($dsc)){
					$dsc_t['DISC'] = $dsc_t['DISC'] *-1; ?>
			        <tr>
			          <td >Disc <?php $dsc_t['nama_disc']; ?></td>
			          <td >: <?php echo number_format($dsc_t['DISC']);?></td>

			      	</tr>	<?php
				$disc_g = $disc_g + $dsc_t['DISC'];		
				}   
			?>		        		        	
		        <tr>
		          <th >Total</th>
		          <th >: <?php echo number_format($disc_g);?></th>

		      	</tr>	
			    </tbody>
			</table>	
		</div>

	</div>


</div>

	<?php

}elseif($pilih == 6){
	$judul = '<h4>Detail Collection Report<h4>';
	$no = 1;
	?>
<div class="col-lg-6">
	<div class="box">
	    <div class="box-header">
	      <h3 class="box-title"><?php echo $judul; ?></h3>
	    </div><!-- /.box-header -->
	    <div class="box-body no-padding">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
	          <th style="width: 10px">#</th>
	          <th >Group</th>
	          <th >Amount</th>  
	          <th ></th>  

	        </tr>
			<?php
			$b_q = mysql_query("SELECT B.no_bukti,B.tanggal,B.jenis,B.bank,B.nominal,B.kembali FROM tbltransorder_master A,tbltranspayment B where A.status = 1 AND A.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND B.tanggal > '".$start." 00:00:00' AND B.tanggal < '".$end." 24:00:00'");					
			while($bank = mysql_fetch_assoc($b_q)){
				if($bank['jenis'] == 'CSH'){
					$cash = $cash + ($bank['nominal'] - ($bank['kembali']*-1));
				}else if($bank['jenis'] == 'DBT'){
					$debit = $debit + ($bank['nominal'] - ($bank['kembali']*-1));
				}else if($bank['jenis'] == 'VCH'){
					$vch = $vch + ($bank['nominal'] - ($bank['kembali']*-1));
				}else{
					$CC = $CC +($bank['nominal'] -($bank['kembali']*-1));
				}
				
			} ?>
	        <tr>
	          <th style="width: 10px">1</th>
	          <th >Cash</th>
	          <th ><?php echo number_format($cash); ?></th>   
	          <th ></th>                  
	        </tr>
	        <tr>
	          <th style="width: 10px">2</th>
	          <th >Debit</th>
	          <th ><?php echo number_format($debit); ?></th>  
	          <th ></th>                   
	        </tr>
			<tr onClick="detailAnalysis('CC','<?php echo $start;?>','<?php echo $end;?>','Credit%20Card','6')">
	          <th style="width: 10px">3</th>
	          <th >Credit Card</th>
	          <th ><?php echo number_format($CC); ?></th>
	          <th ><div><span class="glyphicon glyphicon-zoom-in"></span></div></th>                           
	        </tr>		        		        			
	        <tr>
	          <th style="width: 10px">4</th>
	          <th >Voucher</th>
	          <th ><?php echo number_format($vch); ?></th> 
	          <th ></th>                          
	        </tr>	
	      </tbody></table>
	    </div><!-- /.box-body -->
	</div>	
</div>
<div class="col-lg-6">
	<div id="detail_preview_report"></div>
</div>
	<?php
}elseif($pilih == 8){
	$judul = '<h4>Profit n Lost Report<h4>';
	$no = 1;

	$q = mysql_query("SELECT *,A.disc as disc_bill,A.svc as svc_bill, A.tax as tax_bill FROM tbltrans_summary A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND B.time_out >= '".$date." 00:00:00' AND B.time_out <= '".$end_date." 24:00:00' AND B.keterangan = 'CLOSE' ");
	while($qq = mysql_fetch_assoc($q)){
		$st += $qq['sub_total'];
		$disc_bill += $qq['disc_bill'];
		$svc += $qq['svc_bill'];
		$tax += $qq['tax_bill'];	

				
	}
	$penj = $st - $disc_bill + $svc + $tax;	





	$rs = mysql_query("SELECT A.no_bukti,A.type_disc as type_disc_bill,A.diskon as disc_bill,A.ppn as ppn FROM tbltranspo_master A where A.tanggal >= '".$start." 00:00:00' AND  A.tanggal <= '".$end." 24:00:00' AND A.status != '0';");
	while($rd = mysql_fetch_assoc($rs)){
		$d = mysql_query("SELECT * FROM tbltranspo_detail where no_bukti = '".$rd['no_bukti']."' AND status != '0' ");
		while($dd = mysql_fetch_assoc($d)){
			$disc_per - 0;
			$item = $dd['jumlah']*$dd['harga'];
			if($dd['type_disc'] == 'Nominal'){
				$item = $item - $dd['diskon'];
			}else{
				$item = $item - ($item * $dd['diskon'] / 100);
			}	
			$item_bill += $item;		
		}

		if($rd['type_disc_bill'] == 'N'){
			$disc_nom += $rd['disc_bill'];
		}else{
			$disc_per += $item_bill * ($rd['disc_bill'] / 100);
		}

		$st_pemb += $item_bill;
		$st = $item_bill - $disc_nom - $disc_per;
		if($rd['ppn'] == '1'){
			$ppn = ($st * 10/100);
		}else{
			$ppn = 0;
		}
		$ppn_bill += $ppn;

	}
	$pemb = $st_pemb - $disc_nom - $disc_per + $ppn_bill;


	$penj_pers =  $penj / ($penj + $pemb)	*100;
	$pemb_pers =  $pemb / ($penj + $pemb)	*100;			

	//echo $penj;	
	?>
<div class="col-lg-12" style="border-style: solid;border-width:1px">
	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom:10px">
		<div class="col-lg-7 col-md-7" style="padding-bottom:25px">
			<strong>Penjualan </strong>
		</div>
		<div class="col-lg-5 col-md-5">
			
		</div>			
		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Type 
		</div>
		<div class="col-lg-5 col-md-5">
			 Nominal
		</div></strong>
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Penjualan Menu 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($st);?>
		</div>


		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Disc Bill 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($disc_bill);?>
		</div>

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Service Charge 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($svc);?>
		</div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:25px">
			Tax 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($tax);?>
		</div>	

		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Total Penjualan 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($penj);?>
		</div>	</strong>	
		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Penjualan 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($penj_pers);?> %
		</div>	</strong>					
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom:10px">
		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:25px">
			Pembelian
		</div>
		<div class="col-lg-5 col-md-5">
			
		</div>	
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Type
		</div>
		<div class="col-lg-5 col-md-5">
			Nominal
		</div>
</strong> 
		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Pembelian Barang 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($st_pemb);?>
		</div>		

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Discount pembelian nominal 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($disc_nom);?>
		</div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Discount pembelian persen 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($disc_per);?>
		</div>	

		<div class="col-lg-7 col-md-7" style="padding-bottom:25px">
			PPN Bill 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($ppn_bill);?>
		</div>

		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Total Pembelian 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($pemb);?>
		</div></strong>
		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			Pembelian 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($penb_pers);?> %
		</div>	</strong>	
	</div>
		<div class="col-lg-3"></div>	
		<div class="col-lg-6">
		<strong><div class="col-lg-7 col-md-7" style="padding-bottom:5px">
			PROFIT AND LOST 
		</div>
		<div class="col-lg-5 col-md-5">
			: <?php echo number_format($penj - $pemb);?>
		</div>	</strong>	

		</div>		
		<div class="col-lg-3"></div>	
</div>
	<?php
}

?>
<script>
function detailAnalysis(id,start,end,name,pilih){
	//alert(id+start+end+name);
	$("#detail_preview_report").load("themes/report_preview_detail.php?start="+start+"&end="+end+"&id="+id+"&name="+name+"&pilih="+pilih);
}
</script>