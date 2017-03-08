
<?php
session_start();
if($_GET['trx'] == ''){
	$trx = $_SESSION['trx'];
}else{
	$trx = $_GET['trx'];
}
include "../database.php";
$rs = mysql_query("SELECT * from (SELECT B.id,A.no_bukti as bukti,A.kode_meja,B.kode_menu,B.order_status,B.time_order,B.qty as jumlah,B.keterangan,B.status,B.harga FROM tbltransorder_master A,tbltransorder_detail B WHERE A.zstatus = '' AND B.zstatus  = '' AND A.keterangan = 'OPEN' AND A.no_bukti ='".$trx."' AND A.no_bukti = B.no_bukti AND (B.status = '2' or B.status = '1') AND LEFT(B.kode_menu,3) != 'CMT' AND LEFT(B.kode_menu,3) != 'DSC' ORDER by time_order) A 
		LEFT JOIN 
		(SELECT id as cmt_id,comment_to,no_bukti,kode_menu,qty,comment as cmt FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'CMT') B
		ON A.id = B.comment_to AND A.bukti = B.no_bukti
		LEFT JOIN 
		(SELECT comment_to,no_bukti,kode_menu,qty as qty_disc,comment,harga as disc FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'DSC') G
		ON A.id = G.comment_to AND A.bukti = G.no_bukti
		LEFT JOIN (select nama_menu,kode_cat,kode_menu,img FROM tblmastermenu) C ON A.kode_menu = C.kode_menu
		LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) E ON A.kode_meja = E.kode_meja
		LEFT JOIN (select kode_lokasi,nama_lokasi from tblmasterlokasi) F ON F.kode_lokasi = E.kode_lokasi");

?>

<div class="box">
	<div class="box-header">
	<h3 class="box-title">Table <?php echo $_SESSION['meja'];?></h3>
	</div>
	<div class="box-body no-padding">
		<table class="table table-condensed res">
	<thead>
		<th>Menu</th>
		<th>Keterangan</th>
		<th class="hidden-xs">Harga</th>
		<th>Qty</th>
		<th class="hidden-xs">Disc</th>
		<th class="hidden-xs">Total</th>
		<th width="40%;"></th>
	</thead>	
<?php	


while($rd = mysql_fetch_assoc($rs)){
	$no_bukti = $rd['no_bukti'];
	$jml = $jml + $rd['jumlah'];
	$nominal = $rd['harga'] * $rd['jumlah'] + ($rd['disc'] * $rd['qty_disc']);
	$all = $all + $nominal;
?>
			<tbody>
			<tr>
				<td><?php echo $rd['nama_menu'];?></td>
				<td><?php echo $rd['cmt'];?></td>
				<td class="hidden-xs"><?php echo $rd['harga'];?> </td>
				<td><?php echo $rd['jumlah'];?> </td>
				<td class="hidden-xs">@<?php echo $rd['disc'];?> </td>
				<td class="hidden-xs"><?php echo $nominal;?> </td>
				<td>
				<?php if($rd['keterangan'] == 'COOKED TRANSFERED' ){ 
				
						 echo $rd['keterangan'];										
					
				}else{
				if($rd['status'] == '1'){
					
					if($rd['keterangan'] == ' TRANSFERED' ){
						echo "<span style=''>PRINTED </span>";
						 echo $rd['keterangan'];
					}elseif($rd['keterangan'] == 'COOKED' ){

						echo $rd['keterangan'];
						?> <button  class="btn btn-lg btn-flat btn-info" onClick="trfItem('<?php echo $_GET['trx']; ?>','<?php echo $rd['id']; ?>','<?php echo $rd['nama_menu']; ?>');">Kirim Item</button></a><?php 						
					}else{
						echo "<span style=''>PRINTED </span>";
						?> <button  class="btn btn-lg btn-flat btn-info" onClick="trfItem('<?php echo $_GET['trx']; ?>','<?php echo $rd['id']; ?>','<?php echo $rd['nama_menu']; ?>');">Kirim Item</button></a><?php 
					}

					
					

				}else{
					?>
				<a href="themes/edit_item.php?id=<?php echo $rd['id'];?>&trx=<?php echo $rd['bukti'];?>&meja=<?php echo $_GET['meja'];?>&menu=<?php echo $rd['kode_menu'];?>&qty=<?php echo $rd['jumlah'];?>&harga=<?php echo $rd['harga'];?>&cmt=<?php echo $rd['cmt_id'];?>" class="fancybox fancybox.ajax">
				
								<button  class="btn btn-lg btn-info ">Edit</button></a>
								
								
				<button onClick="deleteItem('<?php echo $rd['id'];?>','<?php echo $rd['kode_menu'];?>','<?php echo $rd['bukti'];?>','<?php echo $_GET['meja'];?>')" class="btn btn-lg btn-info "><i class="fa fa-times"></i></button>
				
				<a href="themes/disc_item.php?id=<?php echo $rd['id'];?>&trx=<?php echo $rd['bukti'];?>&meja=<?php echo $_GET['meja'];?>&menu=<?php echo $rd['kode_menu'];?>&qty=<?php echo $rd['jumlah'];?>&harga=<?php echo $rd['harga'];?>&disc=<?php echo $rd['comment'];?>" class="fancybox fancybox.ajax">
				
								<button  class="btn btn-lg btn-info ">Disc</button></a>


								<?php if($rd['order_status'] == 'Hold' ){  ?>
				<button onClick="UnHoldItem('<?php echo $rd['kode_menu'];?>','<?php echo $rd['id'];?>','<?php echo $_GET['meja'];?>','<?php echo $rd['nama_menu'];?>')" class="btn btn-lg btn-info ">Un Hold</button>

				<?php }else{ ?>
				<button onClick="HoldItem('<?php echo $rd['kode_menu'];?>','<?php echo $rd['id'];?>','<?php echo $_GET['meja'];?>','<?php echo $rd['nama_menu'];?>')" class="btn btn-lg btn-info ">Hold</button>
				<?php	
				} ?>								

	<?php				
				}	
 ?>
					
				
				<?php } 
?>
				</td>
			</tr>

	
<?php	
}
?>	
				<td><strong>TOTAL</strong></td>
				<td></td>
				<td class="hidden-xs"></td>
				<td><strong><?php echo $jml;?></strong> </td>
				<td class="hidden-xs"></td>
				<td class="hidden-xs"><strong><?php echo $all;?></strong> </td>
				<td></td>
		</tbody>
		</table>	
	</div>
</div>
					<div class="box-footer">
						<button onClick="printOrder('<?php echo $_GET['trx']; ?>','<?php echo $_GET['meja']; ?>')" class="btn btn-primary">Print</button>
						<a href="?page=menu&meja=<?php echo $_GET['meja']; ?>&trx=<?php echo $_GET['trx']; ?>&no_meja=<?php echo $_GET['meja']; ?>"><button class="btn btn-primary">New Order</button></a>
					</div>	

<script>
function trfItem(trx,item,name){
	var konfirmasi=confirm("Transfer item "+name+" ? ");
	if (konfirmasi==true)
	{
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=TransferMenu&item="+item+"&trx="+trx,
			cache: false,
			success: function(msg){
				location.reload();
		}});
	}
	//alert(trx+item);
}
</script>
	
