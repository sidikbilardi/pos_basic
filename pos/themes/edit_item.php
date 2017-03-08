<?php
session_start();
include "../database.php";

$kd_menu = $_GET['menu'];

	?>
	<section class="content">
		<div class="row">
			<div class="box box-danger">
				
				<div class="col-lg-12">
					<div class="box-header">
						<h3 class="box-title">Edit Detail <?php echo $_GET['nm'];?></h3>
					</div>
					<div class="box-body">
					<div class="callout callout-danger">

						<div class="form-group">
							<label>New Quantity</label>
							<input type="text" class="form-control" value="<?php echo $_GET['qty'];?>" id="e_qty" placeholder="New Quantity"/>
						</div>
						<div class="form-group">
						<label>New Price</label>
						<input type="text" class="form-control"  value="<?php echo $_GET['harga'];?>" id="e_price" placeholder="New Price"/>
						</div>	
						<div class="form-group">
							<label>New Comment</label>
							<textarea id="keterangan" class="form-control" rows="3" placeholder="Additional Information"></textarea>
						</div>
						
					<div class="box-footer">
						<button onClick="editDetailItem('<?php echo $_GET['id']; ?>','<?php echo $_GET['menu']; ?>','<?php echo $_GET['trx']; ?>','<?php echo $_GET['nm']; ?>','<?php echo $_GET['cmt']; ?>')" class="btn btn-primary">Order</button>
						<button onClick="CancelMenu()" class="btn btn-primarys">Cancel</button>
					</div>	
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>
	
	
	
	