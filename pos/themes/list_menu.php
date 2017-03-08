<?php 
	session_start();
	include"../database.php";
	$id = $_GET['id'];
	
	$rs = mysql_query("SELECT * FROM tblmastermenu where status = 1 AND kode_cat = '$id' ORDER BY nama_menu");
	while($rd = mysql_fetch_assoc($rs)){
		if($rd['img'] == ''){
			$pict = "nopict.png";
		}else{
			$pict = $rd['img'];
		}
		?>
		<div class="col-md-3 col-sm-4 col-xs-6">
		<a href="themes/detail_menu.php?meja=<?php echo $_SESSION['meja']; ?>&trx=<?php echo $_SESSION['trx']; ?>&menu=<?php echo $rd['kode_menu']; ?>" class="fancybox fancybox.ajax">
			<div class="row"><img src="img/menu/<?php echo $pict;?>" class="square" alt="Menu Image" /></div>
			<div><?php echo $rd['nama_menu'];?></div>
			<div><?php echo "Rp. ".number_format($rd['harga']);?></div>
		</a>	
		</div><?php
		
	}
?>	