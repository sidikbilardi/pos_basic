<?php
include"../database.php";
include"../inc/func.php";
?>

<div class="col-lg-12 col-md-12">
              <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT * FROM tbl_role WHERE status = 1 AND id='$id' ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit User</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=EditAccess">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Access</label>
                      <div class="col-sm-10"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                        <input type="text" value="<?php echo $data['name']; ?>" class="form-control" id="name" name="name" placeholder="Nama Access">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Kasir</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" <?php if(getModule2($id,'m_kasir') == 1){ echo"checked"; }?> name="m_kasir" id="m_kasir"> Module Kasir
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Waiter</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox"  <?php if(getModule2($id,'m_waiter') == 1){ echo"checked"; }?> name="m_waiter" id="m_waiter"> Module Waiter
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Kitchen</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox"  <?php if(getModule2($id,'m_kitchen') == 1){ echo"checked"; }?> name="m_kitchen" id="m_kitchen"> Module Kitchen
                      </label>
                    </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Manager</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox"  <?php if(getModule2($id,'m_manager') == 1){ echo"checked"; }?> name="m_manager" id="m_manager"> Module Manager
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Admin</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox"  <?php if(getModule2($id,'m_manager') == 1){ echo"checked"; }?> name="m_admin" id="m_admin"> Module Admin 
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Owner</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox"  <?php if(getModule2($id,'m_owner') == 1){ echo"checked"; }?> name="m_owner" id="m_owner"> Module Owner 
                      </label>
                    </div>
                      </div>
                    </div>                    



                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_access.php">	
              <button class="btn btn-primary btn-block btn-flat">List Access</button>
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
                  <h3 class="box-title">New Access</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addAccess">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Access</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Access">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Kasir</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_kasir" id="m_kasir"> Module Kasir
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Waiter</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_waiter" id="m_waiter"> Module Waiter
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Kitchen</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_kitchen" id="m_kitchen"> Module Kitchen
                      </label>
                    </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Manager</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_manager" id="m_manager"> Module Manager
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Admin</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_admin" id="m_admin"> Module Admin 
                      </label>
                    </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hg_prd" class="col-sm-2 control-label">Owner</label>
                      <div class="col-sm-10">
                        <div class="checkbox">
                      <label>
                        <input value="1" type="checkbox" name="m_owner" id="m_owner"> Module Owner 
                      </label>
                    </div>
                      </div>
                    </div>                    





                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_access.php">	
              <button class="btn btn-primary btn-block btn-flat">List Access</button>
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
	      /* stop form from submitting normally */
      event.preventDefault();
	if(name == ''){
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
	    $("#isi").load("themes/master_access.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>