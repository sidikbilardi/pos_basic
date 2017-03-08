<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
	            <!-- Horizontal Form -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT A.kode_bank,A.id,B.nama_issuer,A.kode_issuer,A.nama_bank FROM tblmasterbank A,tblmasterissuer B  where A.kode_issuer = B.kode_issuer AND A.status = 1 AND A.id = '$id' ORDER BY A.nama_bank ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Bank</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=Editbank">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Kode Bank</label>
                      <div class="col-sm-10"> <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                      	<input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_bank']; ?>">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Bank" value="<?php echo $data['nama_bank']; ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Issuer</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="isu" name="isu">
                        <option value="<?php echo $data['kode_issuer']; ?>"><?php echo $data['nama_issuer']; ?></option> 
                        <optgroup label="Other">
                    <?php
                    $c = mysql_query("select * from tblmasterissuer where status = 1 ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['kode_issuer']; ?>'><?php echo $cat['nama_issuer']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_bank.php">	
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
                  <h3 class="box-title">New Bank</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addbank">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Bank</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Bank">
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Issuer</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="isu" name="isu">
                        <option value="">--- Pilih Issuer ---</option> 
                    <?php
                    $c = mysql_query("select * from tblmasterissuer where status = 1 ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['kode_issuer']; ?>'><?php echo $cat['nama_issuer']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_bank.php">	
              <button class="btn btn-primary btn-block btn-flat">List Bank</button>
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
	    $("#isi").load("themes/master_bank.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>