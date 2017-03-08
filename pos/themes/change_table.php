	<?php 
	include "../database.php";
?>
<section class="content">
		<div class="row">
			<div class="box box-danger">
				
				
				<div class="col-lg-12">
					<div class="box-header">
						
					<?php 
	$rs = mysql_query("SELECT * FROM tblmasterlokasi where status = 1");
	while ($rd = mysql_fetch_assoc($rs)){
	?>
	<button class="btn btn-primary btn-lg" onClick="chg_meja('<?php echo $rd['kode_lokasi'];?>','<?php echo $_GET['trx'];?>')"><?php echo $rd['nama_lokasi'];?></button>
	<?php } ?>	
					
					</div>
					<div class="box-body">
            
					
					<div class="callout callout-danger">
					
		<div id="calculator">
		
			<div class="row">
	<div id="list_meja"></div>

	
	


 
   
    
	
      <!-- end #entry1 -->
        <!-- Button (Double) -->
        <!--p>
        <button type="button" id="btnAdd_1" name="btnAdd" class="btn btn-primary">Other Payment Type</button>
          <button type="button" id="btnDel_1" name="btnDel" class="btn btn-danger"><span class="ui-button-text">Remove Payment</span></button>
        </p-->

        <!-- Begin cloned phone section -->

  
         <!-- Button -->


    </div> 
				</div>
			</div> 
		</div>



					
						
					<!--div class="box-footer">
						<button onClick="AddMenu('<?php echo $rd['kode_menu']; ?>','<?php echo $_SESSION['meja']; ?>','<?php echo $_SESSION['trx']; ?>')" class="btn btn-primary">Order</button>
						<button onClick="CancelMenu()" class="btn btn-primarys">Cancel</button>
					</div-->	
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>

	<script>
	function chg_meja(id,trx) {
		$.ajax({
			type: "GET",
			url: "themes/list_meja.php",
			cache: false,
			success: function(msg){
				$("#list_meja").load("themes/list_meja.php?id="+id+"&chg=y&trx="+trx);
				
		}});

	}
	
	</script>