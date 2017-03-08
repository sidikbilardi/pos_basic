
<div class="box-header">
    <h3 class="box-title">Table Display</h3>
</div><!-- /.box-header -->
    <div class="box-body table-responsive">
		<div class="container-fluid">
			<div>
	<?php 
	include "../database.php";
	$rs = mysql_query("SELECT * FROM tblmasterlokasi where status = 1");
	while ($rd = mysql_fetch_assoc($rs)){
	?>	
	<!-- mobile-->
	<!--button class="btn btn-success btn-lg hidden-lg hidden-md" onClick="pilihMeja('<?php echo $rd['kode_lokasi'];?>','<?php echo $rd['svc'];?>','<?php echo $rd['tax'];?>')"><?php echo $rd['nama_lokasi'];?></button-->

	<!-- Desktop-->
	<button class="btn btn-success btn-lg hidden-xs hidden-sm " onClick="pilihMejaCanvas('<?php echo $rd['kode_lokasi'];?>','<?php echo $rd['svc'];?>','<?php echo $rd['tax'];?>')"><?php echo $rd['nama_lokasi'];?></button>
	<?php } ?>
	<button class="btn btn-success btn-lg" onClick="pilihMeja('booking','<?php echo $rd['svc'];?>','<?php echo $rd['tax'];?>')">Booking List</button>
	
	<div id="responsecontainerstt"></div>
			</div>
		</div>
	</div>

