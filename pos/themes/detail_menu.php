
<?php
session_start();
include "../database.php";

$kd_menu = $_GET['menu'];
$rs = mysql_query("SELECT * FROM tblmastermenu where kode_menu = '$kd_menu'");
while($rd = mysql_fetch_assoc($rs)){
	?>
	<section class="content">
		<div class="row">
			<div class="box box-danger">
				<div class="col-lg-7 col-md-6">
				<div class="box-header">
					<h3 class="box-title"><?php echo $rd['nama_menu']; ?></h3>
                </div>
				<div class="box-body">
					<img src="img/menu/<?php echo $rd['img'];?>" alt="Menu Image" />
					
				</div>	
				</div>
				
				<div class="col-lg-5 col-md-6">
					<div class="box-header">
						<h3 class="box-title">Detail</h3>
					</div>
					<div class="box-body">
					<div class="callout callout-danger">
						<div class="form-group">
							<div>
								<label>Price:</label>
								<?php echo number_format($rd['harga'],2,',','.') ?>
								<input type="hidden" class="form-control" id="harga" value="<?php echo $rd['harga']; ?>" placeholder="Harga"/>
							</div>
							<div>
								<label>Keterangan:</label>
								<?php if($rd['keterangan'] == ''){ echo"-";}else{echo $rd['keterangan'];} ?>
							</div>
						</div>	
						<div class="form-group">
							<label>Additional</label>
							<textarea id="keterangan" class="form-control" rows="3" placeholder="Additional Information"/>
						</div>
 <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4" ><button onClick="Minus()" class="btn btn-primary btn-lg" >-</button></div>
    <div class="col-xs-4 col-sm-4 col-md-4"><input type="text" class="form-control" id="qty" value="1" disabled placeholder="Quantity"/></div>
    <div class="col-xs-4 col-sm-4 col-md-4"><button onClick="Plus()" class="btn btn-primary btn-lg">+</button></div>
 </div>						

					<div class="box-footer">
						<button onClick="AddMenu('<?php echo $rd['kode_menu']; ?>','<?php echo $_SESSION['meja']; ?>','<?php echo $_SESSION['trx']; ?>','<?php echo $rd['nama_menu']; ?>')" class="btn btn-primary">Order</button>
						<button onClick="CancelMenu()" class="btn btn-primarys">Cancel</button>
					</div>	


</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>
	
	
	
	
	
<?php	
}
?>
<script type="text/javascript">
function Plus(){
	var qty = $("#qty").val();
	if(qty <1){

	}else{
	var num = parseInt(qty)+1;
	document.getElementById('qty').value = num;
	}
}
function Minus(){
	var qty = $("#qty").val();
	if(qty <2){

	}else{
	var num = parseInt(qty)-1;
	document.getElementById('qty').value = num;
	}
	
}
</script>