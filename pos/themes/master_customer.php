<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT A.pin,A.kode_cust,A.id,A.nama_cust,B.nama_ctype,A.kode_ctype FROM tblmastercustomer A, tblmastercustomer_type B  where A.id = '$id' AND A.status = 1  AND A.kode_ctype = B.kode_ctype ORDER BY A.nama_cust");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Customer</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=EditCust">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Customer</label>
                      <div class="col-sm-10"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                        <input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_cust']; ?>">
                        <input type="text" value="<?php echo $data['nama_cust'];?>" class="form-control" id="name" name="name" placeholder="Nama Customer">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">PIN</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $data['pin'];?>" class="form-control" id="pin" name="pin" placeholder="Pin">
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Customer Type</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="type" name="type">
                        <option value="<?php echo $data['kode_ctype'];?>"><?php echo $data['nama_ctype'];?></option> 
                        <optgroup label="Other">
                    <?php
                    $c = mysql_query("select * from tblmastercustomer_type where status = 1 AND kode_ctype !='".$data['kode_ctype']."' ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['kode_ctype']; ?>'><?php echo $cat['nama_ctype']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_customer.php">	
              <button class="btn btn-primary btn-block btn-flat">List Bank</button>
            </a>  
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-success btn-block btn-flat">Edit !</button>
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
                  <h3 class="box-title">New Customer</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addCust">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Customer</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Customer">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">PIN</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="pin" name="pin" placeholder="Pin">
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Customer Type</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="type" name="type">
                        <option value="">--- Pilih Type ---</option> 
                    <?php
                    $c = mysql_query("select * from tblmastercustomer_type where status = 1 ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['kode_ctype']; ?>'><?php echo $cat['nama_ctype']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_customer.php">	
              <button class="btn btn-primary btn-block btn-flat">List Customer</button>
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



$("#XForm").submit(function(event) {
	var name = $('#name').val();
  var pin =  $('#pin').val();
  var type =  $('#type').val();
	      /* stop form from submitting normally */
      event.preventDefault();
	if(type == '' || pin == '' || name == ''){
		alert("Masih ada data yang kosong !");
	}else{       
      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("Simpan Data telah berhasil");
        $('#name').val('');
        $('#pin').val('');
        $('#type').val('');
	    $("#isi").load("themes/master_customer.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>