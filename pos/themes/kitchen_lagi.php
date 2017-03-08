
<section class="col-lg-12"> 
<?php 
include "../database.php";
								$no = 1;
$rs = mysql_query("SELECT * from (SELECT B.id,A.no_bukti,B.kode_menu,B.time_order,B.qty as jumlah,B.keterangan,A.kode_meja FROM tbltransorder_master A,tbltransorder_detail B WHERE B.zstatus = '' AND B.keterangan = '' AND B.status = '1' AND LEFT(B.kode_menu,3) != 'CMT' AND LEFT(B.kode_menu,3) != 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'OPEN' ORDER by B.time_order) A 
		LEFT JOIN 
		(SELECT comment_to,no_bukti as bukti_disc,kode_menu,qty,comment FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'CMT') B
		ON A.id = B.comment_to AND A.no_bukti = B.bukti_disc
		LEFT JOIN (select nama_menu,kode_cat,kode_menu,img FROM tblmastermenu) C ON A.kode_menu = C.kode_menu
		LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) E ON A.kode_meja = E.kode_meja
		LEFT JOIN (select kode_lokasi,nama_lokasi from tblmasterlokasi) F ON F.kode_lokasi = E.kode_lokasi");
		
while($rd = mysql_fetch_assoc($rs)){
?>

  <div class="col-md-3 col-sm-4 col-lg-2">
    <div class="small-box bg-green" onClick="doStartKitchen('<?php echo $rd['id']; ?>','<?php echo $rd['no_bukti']; ?>')">


      <div class="inner" style="height:200px;">
        <h4><?php echo $rd['nama_menu']; ?></h4>
        <p><strong><?php echo $rd['jumlah'].' pcs : '.$rd['comment']; ?></strong></p>
        <p><?php echo $rd['time_order']; ?></p>
        <p><?php echo $rd['nama_lokasi']." - ".$rd['nama_meja']; ?></p>
      </div>
      <!--div class="inner">
		 <div><img src="img/menu/<?php echo $rd['img'];?>"  /></div>
	  </div-->      

      <a href="#" class="small-box-footer">Click to Proccess <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
								
	<!--div class="col-lg-2 col-md-2 col-sm-4 col-xs-3">

	  <div class="squarekitchen" onClick="doStartKitchen('<?php echo $rd['id']; ?>','<?php echo $rd['no_bukti']; ?>')">
		<div>
			<div><?php echo $rd['nama_menu']; ?> </div>
			<div><?php echo $rd['jumlah'].'pcs : '.$rd['time_order']; ?></div>
		</div>
		<div><?php echo $rd['comment']; ?></div>
		<div><?php echo $rd['nama_lokasi']." - ".$rd['nama_meja']; ?></div>
		<div><img src="img/menu/<?php echo $rd['img'];?>"  alt="Menu Image" /></div>
		
	</div>	
	</div-->	
<?php } ?>	
	</section>							