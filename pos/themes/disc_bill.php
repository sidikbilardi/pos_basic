<div id="disc_b">
<?php
	include "../database.php";
	
	$rs = mysql_query("SELECT * FROM tblmasterdisc where status = 1 AND type_disc = 'P' AND nominal_disc != 0 ORDER BY type_disc,nama_disc") ;
	while ($rd = mysql_fetch_assoc($rs)){
	if($rd['type_disc'] != $type){
		echo'<br>';
	}		
		?>	
	
	
		<button class="btn btn-success btn-lg" onClick="disc_bill('<?php echo $_GET['trx']; ?>','<?php echo $rd['id']; ?>','<?php echo $rd['type_disc']; ?>','<?php echo $rd['nominal_disc']; ?>','<?php echo $_GET['meja']; ?>')"><?php echo $rd['nama_disc']; ?></button>
<?php
		$type = $rd['type_disc'];
	}
?>	
<a href="themes/disc_member.php?meja=<?php echo $_GET['meja']; ?>&trx=<?php echo $_GET['trx']; ?>" class="fancybox fancybox.ajax">
	<button class="btn btn-success btn-lg">Member</button>
</a>	

</div>
<script>

</script>