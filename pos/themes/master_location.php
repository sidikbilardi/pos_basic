<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
               <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT * FROM(SELECT * FROM tblmasterlokasi  where status = 1 AND id = '$id' ORDER BY nama_lokasi) Z LEFT JOIN (select * from tblmasterlokasi_layout) Y ON Z.kode_lokasi = Y.kode_lokasi ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Location</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=EditLocation">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_cat" class="col-sm-2 control-label">Nama Location</label>
                      <div class="col-sm-10"> <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                      	<input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_lokasi']; ?>">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Location" value="<?php echo $data['nama_lokasi']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Old Layout</label>
                      <div class="col-sm-10">
                        <img style="width:300px;height:300px;" src="img/layout/<?php echo $data['layout'];?>" alt="" />
                      </div>
                    </div>   
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Layout Image</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*" placeholder="Nama Location">
                      </div>
                    </div>                                           





                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_location.php">	
              <button class="btn btn-primary btn-block btn-flat">List Location</button>
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
                  <h3 class="box-title">New Location</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addlocation">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Location</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Location">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Layout Image</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*" placeholder="Nama Location">
                      </div>
                    </div>                    





                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_location.php">	
              <button class="btn btn-primary btn-block btn-flat">List Location</button>
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


/*
$("#XForm").submit(function(event) {
	var cat = $('#name').val();
	      
      event.preventDefault();
	if(cat == ''){
		alert("Masih ada data yang kosong !");
	}else{       
     
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url,$("#XForm").serialize());
      posting.done(function( data ) {
        alert("Simpan Data telah berhasil");
        $('#name').val('');
	    $("#isi").load("themes/master_Location.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	
*/

 $("#XForm").submit(function(event) {
event.preventDefault();
  var cat = $('#name').val();
       /* stop form from submitting normally */
      event.preventDefault();
  if(cat == '' ){
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
            //console.log("success");
           // console.log(data);
            alert("Simpan Data telah berhasil");
            $('#name').val('');
            $("#isi").load("themes/master_Location.php");
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