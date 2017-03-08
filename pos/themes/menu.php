<div class="box-body table-responsive">
		<div class="container-fluid">
			<div>
<?php
	include "../database.php";
	$_SESSION['no_meja'] = $_GET['no_meja'];
	$_SESSION['meja'] = $_GET['meja'];
	$_SESSION['trx'] = $_GET['trx'];
$rs = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
	while ($rd = mysql_fetch_assoc($rs)){
	?>	
	<button class="btn btn-primary btn-lg" onClick="pilihCateg('<?php echo $rd['kode_cat'];?>')"><?php echo $rd['nama_cat'];?></button>
	<?php } 
	
?>
	<div id="respon_input"></div>
	<div id="button_trx"></div>
	<div id="responsecontainermeja"></div>

			</div>
		</div>
	</div>

