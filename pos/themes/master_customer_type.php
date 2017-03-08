<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
              <!-- Horizontal Form -->

                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php  
if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT * FROM tblmastercustomer_type  where status = 1  AND id = '$id' ORDER BY nama_ctype");
$data = mysql_fetch_array($d);
  ?>
           
       
<form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=EditCustType">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                <div class="col-xs-4">
                    <h3 class="box-title">Edit Customer Type</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="box-title"></h3>
                </div>
                <div class="col-xs-4">
                     
                </div>                                
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                        <input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_ctype']; ?>">
                        <input type="text" value="<?php echo $data['nama_ctype'];?>" class="form-control" id="name" name="name" placeholder="Name Cust">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Discount</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['disc'];?>" class="form-control" id="disc" name="disc" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Discount">
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
                      <label for="nm_prd" class="col-sm-6 control-label">* Kosongkan jika ingin mengikuti default configuration</label>
                      <div class="col-sm-6">
                      </div>
                    </div>                    
<div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_customer_type.php">  
              <button class="btn btn-primary btn-block btn-flat">List Customer Type</button>
            </a>  
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-success btn-block btn-flat">Edit !</button>
            </div><!-- /.col -->
          </div>
                  </div><!-- /.box-footer -->



                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- /.box-footer -->
               
              </div><!-- /.box -->

                    
        <!-- /.box-body -->
        <div class="box-footer">
    
         </div><!-- /.box-footer -->
 </form>               
    </div>
<?php }else{ ?>
<form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addCustType">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                <div class="col-xs-4">
                    <h3 class="box-title">New Customer Type</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="box-title"></h3>
                </div>
                <div class="col-xs-4">
                     
                </div>                                
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text"  class="form-control" id="name" name="name" placeholder="Name">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Discount *</label>
                      <div class="col-sm-10">
                        <input type="text"  class="form-control" id="disc" name="disc" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Discount">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Service Charge *</label>
                      <div class="col-sm-10">
                        <input type="text"  class="form-control" id="svc" name="svc" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Service Charge">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Tax *</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="tax" name="tax" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);" placeholder="Tax">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-6 control-label">* Kosongkan jika ingin mengikuti default configuration</label>
                      <div class="col-sm-6">
                      </div>
                    </div>                    
                   
<div class="box-footer">

 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_customer_type.php">  
              <button class="btn btn-primary btn-block btn-flat">List Customer Type</button>
            </a>  
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Add !</button>
            </div><!-- /.col -->
          </div>
                  </div><!-- /.box-footer -->


                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- /.box-footer -->
               
              </div><!-- /.box -->

                    
        <!-- /.box-body -->
        <div class="box-footer">
    
         </div><!-- /.box-footer -->
 </form>               
    </div>
<?php } ?>       


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
      $("#isi").load("themes/master_customer_type.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
    //$.fancybox.close();
      });

      
    }
}); 


</script>