<div id="disc_b">
<?php
	include "../database.php";
	
	$rs = mysql_query("SELECT * FROM tblmasterdisc where status = 1 ORDER BY type_disc,nama_disc") ;
	while ($rd = mysql_fetch_assoc($rs)){
	if($rd['type_disc'] != $type){
		echo'<br>';
	}		
		?>	
	
	
		<button class="btn btn-success btn-lg" onClick="disc_item('<?php echo $_GET['id']; ?>','<?php echo $_GET['trx']; ?>','<?php echo $rd['kode_disc']; ?>','<?php echo $rd['type_disc']; ?>','<?php echo $rd['nominal_disc']; ?>','<?php echo $_GET['meja']; ?>','<?php echo $_GET['menu']; ?>','<?php echo $_GET['qty']; ?>','<?php echo $_GET['harga']; ?>','<?php echo $_GET['disc']; ?>')"><?php echo $rd['nama_disc']; ?></button>
<?php
		$type = $rd['type_disc'];
	}
?>
</div>