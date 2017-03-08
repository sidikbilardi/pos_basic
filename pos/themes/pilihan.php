<div class="ajaxfull">
<div class="col-lg-12">
<?php
session_start();
include"../database.php";
include "../inc/func.php";
$mj = $_GET['meja'];
//echo  $_GET['name'];
$m = mysql_query("SELECT * FROM tbltransorder_master where kode_meja = '$mj' AND keterangan = 'OPEN' ");
while($meja = mysql_fetch_assoc($m)){
	//echo $meja['no_bukti'];
	?> <div class="col-md-4">
	<?php if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_waiter') == '1'){  ?>
		<button class="btn btn-success btn-lg" onclick="ReviewOrder('<?php echo $_GET['meja']; ?>','<?php echo $meja['no_bukti']; ?>','<?php echo  $_GET['meja']; ?>')">Review Order <?php echo $meja['no_bukti']; ?></button>	
	<?php } ?>
	</div>
	<?php
	?> <div class="col-md-4">
	<?php if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_waiter') == '1'){ 
			if($_GET['status'] != 2){ ?>
				<button class="btn btn-success btn-lg" onClick="toMenu('<?php echo $_GET['meja']; ?>','<?php echo $meja['no_bukti']; ?>','<?php echo  $_GET['meja']; ?>')">New Order <?php echo $meja['no_bukti']; ?></button>	

			<?php } 
		} ?>
	</div> <?php
	?> <div class="col-md-4">
	<?php if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_kasir') == '1'){ 
			if($_GET['status'] != 2){ ?>
				<button class="btn btn-success btn-lg" onClick="BILL('<?php echo $_GET['meja']; ?>','<?php echo $meja['no_bukti']; ?>','<?php echo $_GET['svc']; ?>','<?php echo $_GET['tax']; ?>')">Billing <?php echo $meja['no_bukti']; ?></button>
			<?php } 
		} ?>
	</div> <?php
}
//echo $_GET['name'];
if($_GET['trx'] == ''){ ?>
	<div class="col-md-4">
		<button class="btn btn-success btn-lg" onClick="toMenu('<?php echo $_GET['meja']; ?>','<?php echo $_GET['trx']; ?>','<?php echo  $_GET['meja']; ?>')">New Order <?php echo $meja['no_bukti']; ?></button>
	</div>
	<div class="col-md-4"></div>
	<div class="col-md-4"></div>
<?php } ?>	<br><br>
<input type="hidden" name="tableid" id="tableid" value="<?php echo $_GET['meja']; ?>">
</div>	
<div class="col-lg-1"></div>
<div class="col-lg-10">
	<?php if($_GET['trx'] !=''){
	}else{ ?>
	<div id="book_list" style="margin-top:10px"></div>	
	<?php } ?>
</div>
<div class="col-lg-1"></div>
			
                   <input type="hidden" name="petty" id="petty" value="<?php echo $_SESSION['petty'];?>">
</div>


<script>
function Booking(id){
	$("#book_list").load("themes/booking_list.php?id="+id);
	//alert(id);
}

	$(document).ready(function() {
		var tableid = $("#tableid").val();
		var name = '<?php echo $_GET[name]; ?>';
		//alert(tableid);
		$("#book_list").load("themes/booking_list.php?id="+tableid+"&name="+name);

               

		
	});	
</script>