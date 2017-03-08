<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
	            <!-- Horizontal Form -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT * FROM tblmasterissuer  where status = 1 AND id = '$id' ORDER BY nama_issuer ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Issuer</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=Editissuer">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_cat" class="col-sm-2 control-label">Nama Issuer</label>
                      <div class="col-sm-10"> <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                      	<input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_issuer']; ?>">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Issuer" value="<?php echo $data['nama_issuer']; ?>">
                      </div>
                    </div>





                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_issuer.php">	
              <button class="btn btn-primary btn-block btn-flat">List Issuer</button>
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
                  <h3 class="box-title">New Issuer</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addIssuer">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Issuer</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Issuer">
                      </div>
                    </div>





                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_issuer.php">	
              <button class="btn btn-primary btn-block btn-flat">List Issuer</button>
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
	var cat = $('#name').val();
	      /* stop form from submitting normally */
      event.preventDefault();
	if(cat == ''){
		alert("Masih ada data yang kosong !");
	}else{       
      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("Simpan Data telah berhasil");
        $('#name').val('');
	    $("#isi").load("themes/master_issuer.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>