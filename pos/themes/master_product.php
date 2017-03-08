<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
	            <!-- Horizontal Form -->
                 <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT *,A.id as id_menu FROM tblmastermenu A,tblmastercategory B,tblmasterprinter C where A.status = 1 AND A.id = '$id' AND A.kode_cat = B.kode_cat AND A.kode_printer = C.kode_printer ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">


              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Change Product</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data"  action="inc/proses_add.php?action=editProduct">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Product</label>
                      <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="code" name="code" value="<?php echo $data['kode_menu'];?>" >
                        <input type="hidden" class="form-control" id="id_prd" name="id_prd" value="<?php echo $_GET['menu'];?>" >
                        <input type="text" class="form-control" id="nm_prd" name="nm_prd" value="<?php echo $data['nama_menu'];?>" placeholder="Nama Product">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Harga Product</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="hg_prd" name="hg_prd" value="<?php echo $data['harga'];?>" placeholder="Harga Product" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="categ" class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-10">
						<select class="form-control" id="categ" name="categ">
							  <option value="<?php echo $data['kode_cat'];?>"><?php echo $data['nama_cat'];?></option> 
							  <optgroup label="New Category">
						<?php
						$c = mysql_query("select * from tblmastercategory where status = 1 AND kode_cat != '".$data['kode_cat']."' ");
							while($cat = mysql_fetch_assoc($c)){
								?>  <option value='<?php echo $cat['kode_cat']; ?>'><?php echo $cat['nama_cat']; ?></option> <?php
							} ?>
							</optgroup>	
						</select>
                        </div>
                    </div>
  

                    <div class="form-group">
                      <label for="printer" class="col-sm-2 control-label">Printer</label>
                      <div class="col-sm-10">
						<select class="form-control" id="printer" name="printer">
							 <option value="<?php echo $data['kode_printer'];?>"><?php echo $data['printer_loc'];?></option>
							 <optgroup label="New Printer"> 
						<?php
						$p = mysql_query("select * from tblmasterprinter where status = 1 AND kode_printer != '".$data['kode_printer']."' ");
							while($prt = mysql_fetch_assoc($p)){
								?>  <option value='<?php echo $prt['kode_printer']; ?>'><?php echo $prt['printer_loc']; ?></option> <?php
							} ?>
							</optgroup>		
						</select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="file" class="col-sm-2 control-label">Picture</label>
                      <div class="col-sm-10">
                       <input name="myfile" id="myfile" type="file" style="cursor:pointer;" accept="image/*" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Old Pic</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <img src="img/menu/<?php echo $data['img']; ?>" style="width:154px;height:78px;"></td>
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Package ?</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input type="checkbox" onclick="resep(this)" name="pack" id="pack" <?php echo ( $data['paket']=='on' ? 'checked' : '');?> > Check me for Package Item
                      </label>
                    </div>
                      </div>
                    </div>

 <div id="recipe">
                    <div class="form-group">
                      
                      <div class="col-sm-2">
                      </div><div class="col-sm-10">	
                     		<label>Package Detail</label>
                     		<button type="button" onclick="addRow('myTable');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
		                    <!--div class="form-group">
		                      <div class="col-sm-10">
							    <div class="multi-field-wrapper">
							    	<div class="col-sm-12">
							    <button type="button" onclick="addRow('myTable');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></div>
							      <div class="multi-fields">
							        <div class="multi-field col-sm-4">

							    <select class="form-control" id="menu_pack[]" name="menu_pack[]">  	
		                    	<option value=''>--- Pilih Menu ---</option>
		                    		 <?php  $m = mysql_query("SELECT * FROM tblmastermenu where status = '1' ORDER BY nama_menu ");?>
		                    		 <?php while($menu=mysql_fetch_assoc($m)){ ?>
										<option value='<?php echo $menu['kode_menu']; ?>'><?php echo $menu['nama_menu']; ?></option>
		                    		 <?php } ?>
										</select>

							          
		                      		<input class="form-control" type="text" placeholder="Qty Product"  name="qty[]">
							          <button type="button" class="remove-field btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></button>
							        </div>
							      </div>
							  </div>
		                      </div>
		                    </div-->
                      	<table id="myTable">
                      		<thead>
                      			<th>Menu</th>
                      			<th>Qty</th>
                      			<th></th>
                      		</thead>
                      		<tbody><div class="multi-field-wrapper"><div class="multi-field">
                      		<?php $rs = mysql_query("SELECT * FROM tblmastermenu_paket A,tblmastermenu B where A.kode_menupaket = '".$data['kode_menu']."' AND A.kode_menu = B.kode_menu AND A.status = '1' ");
                      		while($rsp = mysql_fetch_assoc($rs)){ ?>
                      			<tr>
                     				<td><select class="form-control pack-menu" id="menu_pack[]" name="menu_pack[]">  	
 		                    	<option value='<?php echo $rsp['kode_menu']; ?>'><?php echo $rsp['nama_menu']; ?></option>
 		                    	<optgroup label="Other menu">
		                    		 <?php  $m = mysql_query("SELECT * FROM tblmastermenu where status = '1' AND kode_menu != '".$rsp['kode_menu']."' ORDER BY nama_menu ");?>
		                    		 <?php while($menu=mysql_fetch_assoc($m)){ ?>
										<option value='<?php echo $menu['kode_menu']; ?>'><?php echo $menu['nama_menu']; ?></option>
		                    		 <?php } ?>
										</select>
								</optgroup>		
									</td>
									<td><input class="form-control pack-qty" type="text" placeholder="Qty Product"  value="<?php echo $rsp['qty']; ?>" id="qty[]" name="qty[]">
									</td>
									<td><button type="button" onclick="deleteRow(this);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span>
									</td>	
                      			</tr>


                      		<?php } ?>
                      			<tr> 
                     				<td><select class="form-control pack-menu" id="menu_pack[]" name="menu_pack[]">  	
 		                    	<option value=''>--- Pilih Menu ---</option>
		                    		 <?php  $m = mysql_query("SELECT * FROM tblmastermenu where status = '1' ORDER BY nama_menu ");?>
		                    		 <?php while($menu=mysql_fetch_assoc($m)){ ?>
										<option value='<?php echo $menu['kode_menu']; ?>'><?php echo $menu['nama_menu']; ?></option>
		                    		 <?php } ?>
										</select>
									</td>
									<td><input class="form-control pack-qty" type="text" placeholder="Qty Product"  id="qty[]" name="qty[]">
									</td>
									<td><button type="button" onclick="deleteRow(this);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span>
									</td>	
                      			</tr>	


                      		</div></div></tbody>	
                      	</table>	


                      </div>
                    </div>
                	</div>
                   

                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_product.php">	
              <button class="btn btn-primary btn-block btn-flat">List Product</button>
            </a>  
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-success btn-block btn-flat">Update !</button>
            </div><!-- /.col -->
          </div>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->

                    
        <!-- /.box-body -->
        <div class="box-footer">
			
         </div><!-- /.box-footer -->
               
    </div> <?php
}else{ ?>            
        <div class="box-body">


              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">New Product</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addProduct">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Product</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nm_prd" name="nm_prd" placeholder="Nama Product">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Harga Product</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="hg_prd" name="hg_prd" placeholder="Harga Product" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="categ" class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-10">
						<select class="form-control" id="categ" name="categ">
							 <option value=''>--- Pilih Category ---</option>
						<?php
						$c = mysql_query("select * from tblmastercategory where status = 1");
							while($cat = mysql_fetch_assoc($c)){
								?>  <option value='<?php echo $cat['kode_cat']; ?>'><?php echo $cat['nama_cat']; ?></option> <?php
							} ?>	
						</select>
                        </div>
                    </div>
  

                    <div class="form-group">
                      <label for="printer" class="col-sm-2 control-label">Printer</label>
                      <div class="col-sm-10">
						<select class="form-control" id="printer" name="printer">
							 <option value=''>--- Pilih Printer ---</option>
						<?php
						$p = mysql_query("select * from tblmasterprinter where status = 1");
							while($prt = mysql_fetch_assoc($p)){
								?>  <option value='<?php echo $prt['kode_printer']; ?>'><?php echo $prt['printer_loc']; ?></option> <?php
							} ?>	
						</select>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="file" class="col-sm-2 control-label">Picture</label>
                      <div class="col-sm-10">
                       <input name="myfile" id="myfile" type="file" style="cursor:pointer;" accept="image/*" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Package ?</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input type="checkbox" onclick="resep(this)" name="pack" id="pack"> Check me for Package Item
                      </label>
                    </div>
                      </div>
                    </div>

                    <div id="recipe">
                    <div class="form-group">
                      
                      <div class="col-sm-2">
                      </div><div class="col-sm-10">	
                     		<label>Package Detail</label>
                     		<button type="button" onclick="addRow('myTable');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
		                    <!--div class="form-group">
		                      <div class="col-sm-10">
							    <div class="multi-field-wrapper">
							    	<div class="col-sm-12">
							    <button type="button" onclick="addRow('myTable');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></div>
							      <div class="multi-fields">
							        <div class="multi-field col-sm-4">

							    <select class="form-control" id="menu_pack[]" name="menu_pack[]">  	
		                    	<option value=''>--- Pilih Menu ---</option>
		                    		 <?php  $m = mysql_query("SELECT * FROM tblmastermenu where status = '1' ORDER BY nama_menu ");?>
		                    		 <?php while($menu=mysql_fetch_assoc($m)){ ?>
										<option value='<?php echo $menu['kode_menu']; ?>'><?php echo $menu['nama_menu']; ?></option>
		                    		 <?php } ?>
										</select>

							          
		                      		<input class="form-control" type="text" placeholder="Qty Product"  name="qty[]">
							          <button type="button" class="remove-field btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></button>
							        </div>
							      </div>
							  </div>
		                      </div>
		                    </div-->
                      	<table id="myTable">
                      		<thead>
                      			<th>Menu</th>
                      			<th>Qty</th>
                      			<th></th>
                      		</thead>
                      		<tbody><div class="multi-field-wrapper"><div class="multi-field">
                      			<tr> 
                      				<td><select class="form-control pack-menu" id="menu_pack[]" name="menu_pack[]">  	
		                    	<option value=''>--- Pilih Menu ---</option>
		                    		 <?php  $m = mysql_query("SELECT * FROM tblmastermenu where status = '1' ORDER BY nama_menu ");?>
		                    		 <?php while($menu=mysql_fetch_assoc($m)){ ?>
										<option value='<?php echo $menu['kode_menu']; ?>'><?php echo $menu['nama_menu']; ?></option>
		                    		 <?php } ?>
										</select>
									</td>
									<td><input class="form-control pack-qty" type="text" placeholder="Qty Product"  id="qty[]" name="qty[]">
									</td>
									<td><button type="button" onclick="deleteRow(this);" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span>
									</td>	
                      			</tr>	
                      		</div></div></tbody>	
                      	</table>	


                      </div>
                    </div>
                	</div>



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_product.php">	
              <button class="btn btn-primary btn-block btn-flat">List Product</button>
            </a>  
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Add !</button>
            </div><!-- /.col -->
          </div>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->

                    
        <!-- /.box-body -->
        <div class="box-footer">
			
         </div><!-- /.box-footer -->
               
    </div>
    <?php } ?>

<script>
function deleteRow(el) {

  // while there are parents, keep going until reach TR 
  while (el.parentNode && el.tagName.toLowerCase() != 'tr') {
    el = el.parentNode;
  }

  // If el has a parentNode it must be a TR, so delete it
  // Don't delte if only 3 rows left in table
  if (el.parentNode && el.parentNode.rows.length > 1) {
    el.parentNode.removeChild(el);
  }
}

function addRow(tableID) {
var terisi1=terisi2=0;
var jmlMenu=$(".pack-menu").length; 
var jmlQty=$(".pack-qty").length;

$(".pack-menu").each(function(){
	if($(this).val()!=''){
		terisi1++;
	}
});

$(".pack-qty").each(function(){
	if($(this).val()!=''){
		terisi2++;
	}
});


if(terisi1<jmlMenu || terisi2<jmlQty ){
alert("Field tidak boleh kosong");
} else {
//taru disini code kamu untuk menambahkan field
  var table = document.getElementById(tableID);

  if (!table) return;

  var newRow = table.rows[1].cloneNode(true);

  // Now get the inputs and modify their names 
  var inputs = newRow.getElementsByTagName('input');
  for (var i=0, iLen=inputs.length; i<iLen; i++) {
    // Update inputs[i]
    
  }

  // Add the new row to the tBody (required for IE)
  var tBody = table.tBodies[0];
  tBody.insertBefore(newRow, tBody.lastChild);
}


}


function resep(cb){
	if(cb.checked == true){
		$('#recipe').css({'display':''});		
	}else{
		$('#recipe').css({'display':'none'});
	}
}
	$(document).ready(function() {
		//$("#list_product").load("table/table_product.php");
		//$('#recipe').css({'display':'none'});	
		if(document.getElementById('pack').checked == true){
			$('#recipe').css({'display':''});		
		}else{
			$('#recipe').css({'display':'none'});
		}			
	});	

 $("#XForm").submit(function(event) {
event.preventDefault();
  var nm = $('#nm_prd').val();
  var hg = $('#hg_prd').val();
  var categ = $('#categ').val();
  var printer = $('#printer').val();
        /* stop form from submitting normally */
      event.preventDefault();
  if(nm == '' || hg == '' || categ == '' || printer == ''){
    alert("Masih ada data yang kosong !");
  }else{ 
  var formData = new FormData(this);

      $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
          success:function(data){
            console.log("success");
            console.log(data);
            alert("Simpan Data telah berhasil");
            $("#isi").load("themes/master_product.php");
            $("#isi").css({'display':''});
 
          },
          error: function(data){
            console.log("error");
            console.log(data);
          }
          });
}
});


</script>