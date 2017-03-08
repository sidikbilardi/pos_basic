<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
	            <!-- Horizontal Form -->

                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php  
$d = mysql_query("SELECT * from tblutilitysetting");
$data = mysql_fetch_array($d);
	?>
           
       
<form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=editConf">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                <div class="col-xs-4">
                    <h3 class="box-title">New Bank</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="box-title"></h3>
                </div>
                <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Save !</button>
                </div>                                
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Restaurant Name</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['resto_name'];?>" class="form-control" id="name" name="name" placeholder="Name Restaurant">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Address 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['resto_add1'];?>" class="form-control" id="add1" name="add1" placeholder="Address 1">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Address 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['resto_add2'];?>" class="form-control" id="add2" name="add2" placeholder="Address 2">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Restaurant Phone</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" value="<?php echo $data['resto_phone'];?>" class="form-control" id="phone" name="phone" data-inputmask="mask:(999) 999-9999" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" data-mask="">
                                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Footer line 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['footer_line1'];?>" class="form-control" id="foot1" name="foot1" placeholder="Footer line 1">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Footer line 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['footer_line2'];?>" class="form-control" id="foot2" name="foot2" placeholder="Footer line 2">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Footer line 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['footer_line3'];?>" class="form-control" id="foot3" name="foot3" placeholder="Footer line 3">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Service Charge</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['svc'];?>" class="form-control" id="svc" name="svc" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Service Charge">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Tax</label>
                      <div class="col-sm-10">
                        <input type="text"value="<?php echo $data['tax'];?>" class="form-control" id="tax" name="tax" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Tax">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Upsell</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['upsell'];?>" class="form-control" id="upsell" name="upsell" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Upsell">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Printer CO</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="p_co" name="p_co">
                        <option value="<?php echo $data['print_co'];?>"><?php echo $data['print_co'];?></option> 
                        <optgroup label="Other">
                    <?php
                    $c = mysql_query("select * from tblmasterprinter where status = 1 AND printer_loc != '".$data['print_co']."' ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['printer_loc']; ?>'><?php echo $cat['printer_loc']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Printer Billing</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="p_bill" name="p_bill">
                         <option value="<?php echo $data['print_bill'];?>"><?php echo $data['print_bill'];?></option> 
                         <optgroup label="Other">
                    <?php
                    $c = mysql_query("select * from tblmasterprinter where status = 1 AND printer_loc != '".$data['print_bill']."' ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['printer_loc']; ?>'><?php echo $cat['printer_loc']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Dual Screen</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input type="checkbox" onclick="resep(this)" name="dual" id="dual" <?php echo ( $data['dualscreen']=='on' ? 'checked' : '');?> > Dual screen mode
                      </label>
                    </div>
                      </div>
                    </div>

                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- /.box-footer -->
               
              </div><!-- /.box -->

                    
        <!-- /.box-body -->
        <div class="box-footer">
		
         </div><!-- /.box-footer -->
 </form>               
    </div>
   


<script>



$("#XForm").submit(function(event) {
	var name = $('#name').val();
  var cat =  $('#isu').val();
	      /* stop form from submitting normally */
      event.preventDefault();
	if(cat == '' || name == ''){
		alert("Masih ada data yang kosong !");
	}else{       
      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("Simpan Data telah berhasil");
        $('#name').val('');
	    $("#isi").load("themes/configuration.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>