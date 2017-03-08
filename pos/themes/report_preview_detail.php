<?php
include"../database.php";
$name = $_GET['name'];
$cat = $_GET['id'];
$start = $_GET['start'];
$end = $_GET['end'];
//echo $name;
if($_GET['pilih'] == 1){
?>

 <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Detail : <?php echo $name;?></h3>
         <input type="hidden" class="form-control" id="sementara" >

    </div><!-- /.box-header -->
    <!-- form start -->
    <!--form class="form-horizontal"-->
      <div class="box-body">
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
$no = 1;
	$q = mysql_query("SELECT * from (SELECT B.kode_menu as kode,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND C.kode_cat = '".$cat."' AND B.time_order >= '".$start." 00:00:00' AND B.time_order <= '".$end." 24:00:00' GROUP BY nama_menu) master 
	LEFT JOIN 
	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status = '1' AND B.time_order >= '".$start." 00:00:00' AND B.time_order <= '".$end." 24:00:00' GROUP BY kode_menu ) Z ON  master.kode = RIGHT(Z.kode_menu,5)");

while($prd =mysql_fetch_assoc($q)){
				$subtotal = $prd['total']-($prd['disc']*-1);

 ?>
	        <tr>
	          <th style="width: 10px"><?php echo $no;?></th>
	          <th><?php echo $prd['nama_menu'];?></th>
	          <th><?php echo $prd['jml'];?></th>
	         <th style="width: 40px"><?php echo number_format($prd['total']);?></th> 
	          <th style="width: 40px">( -<?php echo $prd['disc'];?> )</th>
	          <th style="width: 40px"><?php echo number_format($subtotal);?></th>
	          <th style="width: 40px"></th>                    
	        </tr>
<?php $no++; } ?>
	      </tbody></table>




  
      <div class="box-footer">
       
      </div><!-- /.box-footer -->
	</div>	
</div>
<?php 
}elseif($_GET['pilih'] == 2){
?>

 <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Detail : <?php echo $name;?></h3>
         <input type="hidden" class="form-control" id="sementara" >

    </div><!-- /.box-header -->
    <!-- form start -->
    <!--form class="form-horizontal"-->
      <div class="box-body">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
	          <th style="width: 10px">#</th>
	          <th>Menu</th>
	          <th>Qty</th>
	          <th style="width: 40px">Price</th>
	          <th style="width: 40px">Disc</th>
	          <th style="width: 40px">Amount</th>   
	          <th  class="hidden-lg hidden-xs">Time Order</th>   
	          <th style="width: 40px">Waiter</th>                    
	        </tr>
	<?php
			$d = mysql_query("SELECT * from (SELECT no_bukti,kode_menu,kode_menu as kode,time_order,harga,qty as jumlah,keterangan,status,kode_waiter FROM tbltransorder_detail WHERE no_bukti ='".$name."' AND LEFT(kode_menu,3) != 'CMT' AND LEFT(kode_menu,3) != 'DSC'  ORDER by time_order) A 
			LEFT JOIN 
			(SELECT no_bukti,kode_menu,qty,comment FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'CMT') B
			ON A.kode_menu = RIGHT(B.kode_menu,5) AND A.no_bukti = B.no_bukti
			LEFT JOIN (select nama_menu,kode_cat,kode_menu,kode_printer FROM tblmastermenu) C ON A.kode_menu = C.kode_menu
			LEFT JOIN (select no_bukti ,kode_meja FROM tbltransorder_master )D ON A.no_bukti = D.no_bukti
			LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) E ON D.kode_meja = E.kode_meja
			LEFT JOIN (select kode_lokasi,nama_lokasi from tblmasterlokasi) F ON F.kode_lokasi = E.kode_lokasi
			LEFT JOIN 
			(SELECT no_bukti,kode_menu,qty,(qty*harga) as disc FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'DSC') G
			ON A.kode_menu = RIGHT(G.kode_menu,5) AND A.no_bukti = G.no_bukti
			LEFT JOIN (select kode_printer,printer_alias FROM tblmasterprinter) H ON C.kode_printer = H.kode_printer
			LEFT JOIN (select kode_waiter,nama_waiter FROM tblmasterwaiter) I ON A.kode_waiter = I.kode_waiter		");
			$JUMLAH = 0;
			$kembali = 0;
			$no = 1;
			while($detail = mysql_fetch_assoc($d)){
				if($detail['comment']){
					$desc = $detail['nama_menu']." ( ".$detail['comment']." )";
				}else{
					$desc = $detail['nama_menu'];
				}
				if($detail['disc']){
					$disc = $detail['disc']*-1;
				}else{
					$disc = 0;
				}	
				$amount = ($detail['jumlah']*$detail['harga']) - $disc;



			 ?>
		        <tr>
		          <th style="width: 10px"><?php echo $no;?></th>
		          <th><?php echo $desc;?></th>
		          <th><?php echo $detail['jumlah'];?></th>
		          <th style="width: 40px"><?php echo number_format($detail['harga']);?></th>
		          <th style="width: 40px"><?php echo $disc;?></th>
		          <th style="width: 40px"><?php echo number_format($amount);?></th>   
		          <th  class="hidden-lg hidden-xs"><?php echo $detail['time_order'];?></th>   
		          <th style="width: 40px"><?php echo $detail['nama_waiter'];?></th>                    
		        </tr>
	<?php $no++; }


	 ?>
	      </tbody></table>
	      <table class="table table-striped">
	        <tbody>
		    <?php
				$sm = mysql_query("SELECT * FROM tbltrans_summary where no_bukti ='$name' ");
				while($smr = mysql_fetch_assoc($sm)){ ?>
				
		        <tr>
		          <th>Subtotal</th>
		          <th>:</th>
		          <th><?php echo number_format($smr['sub_total']); ?></th>
		        </tr>		
		        <tr>
		          <th>Disc</th>
		          <th>:</th>
		          <th><?php echo number_format($smr['disc']); ?></th>
		        </tr>		
		        <tr>
		          <th>Service Charge</th>
		          <th>:</th>
		          <th><?php echo number_format($smr['svc']); ?></th>
		        </tr>		
		        <tr>
		          <th>Tax</th>
		          <th>:</th>
		          <th><?php echo number_format($smr['tax']); ?></th>
		        </tr>
		        <tr>
		          <th>Grand Total</th>
		          <th>:</th>
		          <th><?php echo number_format($smr['total']); ?></th>
		        </tr>			        			        	        	        			
			<?php } ?>	        	

			</tbody>
		</table>    
      <div class="box-footer">
    
      </div><!-- /.box-footer -->
	</div>	
</div>
<?php 
}elseif($_GET['pilih'] == 6){
?>

 <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Detail : <?php echo $name;?></h3>
         <input type="hidden" class="form-control" id="sementara" >

    </div><!-- /.box-header -->
    <!-- form start -->
    <!--form class="form-horizontal"-->
      <div class="box-body">
	      <table class="table table-striped">
	        <tbody>
	        <tr>
	          <th style="width: 10px">#</th>
	          <th>Jenis</th>
	          <th>Jumlah</th>
	          <th style="width: 40px">Amount</th>
	                            
	        </tr>
			<?php $d = mysql_query("SELECT D.nama_issuer,C.nama_bank,sum(A.nominal) as nom,count(A.id) as cnt FROM tbltranspayment A,tbltransorder_master B,tblmasterbank C,tblmasterissuer D where C.kode_issuer = D.kode_issuer AND A.bank = C.kode_bank AND B.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND A.jenis = '".$cat."' AND A.tanggal > '".$start." 00:00:00' AND A.tanggal < '".$end." 24:00:00' GROUP BY C.kode_bank ORDER BY D.nama_issuer");
			while($dd = mysql_fetch_assoc($d)){ ?>
		        <tr>
		          <td style="width: 10px">#</td>
		          <td><?php echo $dd['nama_issuer'].' - '.$dd['nama_bank'];?></td>
		        	<td style="width: 40px"><?php echo number_format($dd['cnt']);?></td>
		          <td style="width: 40px"><?php echo number_format($dd['nom']);?></td>
		                            
		        </tr>			
			<?php }
			?>
	      </tbody></table>


      <div class="box-footer">
    
      </div><!-- /.box-footer -->
	</div>	
</div>
<?php 
}
?>