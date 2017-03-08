<div id="pilihan">
<?php
	date_default_timezone_set('Asia/Jakarta');
	$todayDate = date("Y-m-j H:i:s");
	include "../database.php";
	$rs = mysql_query("SELECT IFNULL(C.no_bukti, '') no_bukti, A.status as status_meja,A.kode_meja, A.nama_meja, IFNULL(C.pax, '') pax, IFNULL(C.time_in, '') time_order, IFNULL((SELECT SUM(qty*harga) sales FROM tbltransorder_detail WHERE no_bukti = C.no_bukti),0) sales,A.status, IFNULL(C.disc,0) disc, IFNULL(C.svc,0) svc, IFNULL(C.tax,0) tax FROM tblmastermeja A LEFT OUTER JOIN tblmasterlokasi B ON A.kode_lokasi = B.kode_lokasi LEFT OUTER JOIN tbltransorder_master C ON A.kode_meja = C.kode_meja AND C.keterangan = 'OPEN' AND C.status <> 0 WHERE A.status <> 0 AND A.kode_lokasi = '".$_GET['id']."' ORDER BY A.nama_meja,no_bukti");
	//$rs = mysql_query("SELECT * FROM (SELECT * FROM tblmastermeja where status != 0 AND kode_lokasi = '".$_GET['id']."') A LEFT JOIN (SELECT no_bukti,kode_meja as kd_meja FROM tbltransorder_master where zstatus = '' AND keterangan = 'OPEN') B ON A.kode_meja = B.kd_meja ORDER BY nama_meja") ;
	while ($rd = mysql_fetch_assoc($rs)){
	if($_GET['chg'] == 'y'){
		if($rd['no_bukti'] != ''){ 
				$class = "btn btn-danger btn-lg disabled";
			}else{
				$class = "btn btn-success btn-lg";
			} 
	?>
	<button class="<?php echo $class;?>"  onClick="change_meja('<?php echo $rd['kode_meja'];?>','<?php echo $rd['nama_meja'];?>','<?php echo $_GET['trx'];?>')"><?php echo $rd['nama_meja']; ?></button>	
	<?php
	}else{	
?>	
	<div class="col-lg-1 col-md-2 col-xs-4 col-sm-3">
	
		<?php 
		$time_order = strtotime($rd['time_order']);
		$d = mysql_query("SELECT upsell from tblutilitysetting");
		$dd = mysql_fetch_array($d);

		$date = date('Y-m-j H:i:s', strtotime('+'.$dd['upsell'].' minute', $time_order));
		if($rd['no_bukti'] != ''){
			if($date <= $todayDate){
				$bg = 'red';
				$font = 'white';
			}else{
				$bg = 'yellow';
				$font = 'black';
			} ?>
		<a href="themes/pilihan.php?meja=<?php echo $rd['kode_meja']; ?>&trx=<?php echo $rd['no_bukti']; ?>&svc=<?php echo $_GET['svc']; ?>&tax=<?php echo $_GET['tax']; ?>" class="fancybox fancybox.ajax">
		<div class="circle" style="color:<?php echo $font; ?>;background:<?php echo $bg; ?>;">
			
			<div>
			<?php echo $rd['nama_meja']; ?>
			</div>
		</div>
		
		</a>
			
		<?php }else{ 
			if($rd['status_meja'] == 2){
				$bg = 'blue';
			}else{
				$bg = '#000';
				
			}
			?>
		<a href="themes/pilihan.php?status=<?php echo $rd['status_meja']; ?>&meja=<?php echo $rd['kode_meja']; ?>&trx=<?php echo $rd['no_bukti']; ?>&svc=<?php echo $_GET['svc']; ?>&tax=<?php echo $_GET['tax']; ?>" class="fancybox fancybox.ajax">
		<div class="circle" style="background:<?php echo $bg; ?>">
			
			<div>
			<?php echo $rd['nama_meja']; ?>
			</div>
		</div>

		</a>

		<?php } ?>
	</div>
	


	<?php } 
	}
	?>	
</div>

<script>
function change_meja(id,meja,trx){
		var konfirmasi=confirm("Apakah yakin pindah ke meja "+meja+" ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=change_meja&id="+id+"&trx="+trx,
			cache: false,
			success: function(msg){
				alert(msg);
				window.location.reload(true);
				
		}});
		}
}
</script>
	