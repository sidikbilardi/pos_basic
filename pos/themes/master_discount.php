<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
	            <!-- Horizontal Form -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT * FROM tblmasterdisc where status = '1' AND id = '$id'  ORDER BY nama_disc");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Discount</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=EditDiscount">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Nama Discount</label>
                      <div class="col-sm-10"> <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                      	<input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_disc']; ?>">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Discount" value="<?php echo $data['nama_disc']; ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Type Discount</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="type" name="type" onchange="changeInfo()">
                        <option value="">--- Pilih Type ---</option> 
                        <option value="P">Percent</option> 
                        <option value="N">Nominal</option> 
                      
                    </select>
                  </div>
                </div>
                    <div class="form-group">
                      <label for="nominal" class="col-sm-2 control-label">Nominal</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="nominal" value="<?php echo $data['nominal_disc']; ?>" name="nominal" placeholder="Nominal" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                      <div class="col-sm-1">
                      <label id="info"></label>
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
                  <h3 class="box-title">New Discount</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addDiscount">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Discount</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Discount">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Type Discount</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="type" name="type" onchange="changeInfo()">
                        <option value="">--- Pilih Type ---</option> 
                        <option value="P">Percent</option> 
                        <option value="N">Nominal</option> 
                      
                    </select>
                  </div>
                </div>
                    <div class="form-group">
                      <label for="nominal" class="col-sm-2 control-label">Nominal</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Nominal" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                      <div class="col-sm-1">
                      <label id="info"></label>
                    </div>
                    </div>




                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_discount.php">	
              <button class="btn btn-primary btn-block btn-flat">List Discount</button>
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

function changeInfo(){
    var x = document.getElementById("type").value;
    if(x == 'P'){
      document.getElementById("info").innerHTML = "%";
    }else{
      document.getElementById("info").innerHTML = "";
    }

}

$("#XForm").submit(function(event) {
	var name = $('#name').val();
  var type =  $('#type').val();
  var nominal =  $('#nominal').val();
	      /* stop form from submitting normally */
      event.preventDefault();
if(nominal < 0){
  alert("Nominal harus lebih besar dari 0");
}else{      
	if(type == '' || name == '' || nominal == ''){
		alert("Masih ada data yang kosong !");
	}else{       
      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("Simpan Data telah berhasil");
        $('#name').val('');
	    $("#isi").load("themes/master_discount.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
 }   
});	


</script>