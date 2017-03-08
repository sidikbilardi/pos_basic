<?php
include"../database.php";
?>

<div class="col-lg-12 col-md-12">
               <!-- form start -->
                <!--form class="form-horizontal"-->
<?php if($_GET['do'] == 'edit'){ 
$id = mysql_real_escape_string(stripslashes($_GET['menu']));
$d = mysql_query("SELECT A.id,A.kode_meja,A.nama_meja,B.nama_lokasi,B.kode_lokasi,C.image,C.x,C.add_x,C.y,C.add_y,C.angle,C.angle_text FROM tblmastermeja A,tblmasterlokasi B,tblmastermeja_koor C  where C.kode_meja = A.kode_meja AND A.kode_lokasi = B.kode_lokasi AND A.status = 1 AND A.id = '$id'  ");
$data = mysql_fetch_array($d);
	?>
<div class="box-body">

              <!-- Horizontal Form -->
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Meja</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=Editmeja">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Nama Meja</label>
                      <div class="col-sm-10"> <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>">
                      	<input type="hidden" class="form-control" id="kd" name="kd" value="<?php echo $data['kode_meja']; ?>">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Meja" value="<?php echo $data['nama_meja']; ?>">
                        <input type="hidden" class="form-control" id="old_meja" name="old_meja" placeholder="Nama Meja" value="<?php echo $data['image']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Tipe meja</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="tipe_meja" name="tipe_meja" onChange="showLayout2('<?php echo $data['x']?>','<?php echo $data['add_x']?>','<?php echo $data['y']?>','<?php echo $data['add_y']?>','<?php echo $data['angle']?>','<?php echo $data['angle_text']?>');">
                            <option value="">--- Kosongkan jika tidak berubah ---</option> 
                            <option value="1">Square 1 seat</option> 
                            <option value="2">Square 2 seat</option> 
                            <option value="3">Circle 1 seat</option> 
                        </select>
                      </div>
                  </div>
                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Lokasi</label>
                      <div class="col-sm-10">
                    <select class="form-control" id="lokasi" name="lokasi" onChange="showLayout2('<?php echo $data['x']?>','<?php echo $data['add_x']?>','<?php echo $data['y']?>','<?php echo $data['add_y']?>','<?php echo $data['angle']?>','<?php echo $data['angle_text']?>');">
                        <option value="<?php echo $data['kode_lokasi']; ?>"><?php echo $data['nama_lokasi']; ?></option> 
                        <optgroup label="Other">
                    <?php
                    $c = mysql_query("select * from tblmasterlokasi where status = 1 ");
                      while($cat = mysql_fetch_assoc($c)){
                        ?>  <option value='<?php echo $cat['kode_lokasi']; ?>'><?php echo $cat['nama_lokasi']; ?></option> <?php
                      } ?>
                      </optgroup> 
                    </select>
                  </div>
                </div>

                    <div class="form-group">
                      <div id="layout"></div>
                    </div>


                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_meja.php">	
              <button class="btn btn-primary btn-block btn-flat">List Meja</button>
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
                  <h3 class="box-title">New Meja</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="XForm" name="XForm" method="POST" enctype="multipart/form-data" action="inc/proses_add.php?action=addmeja">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="nm_prd" class="col-sm-2 control-label">Nama Meja</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Meja">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Tipe meja</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="tipe_meja" name="tipe_meja" onChange="showLayout();">
                            <option value="1">Square 1 seat</option> 
                            <option value="2">Square 2 seat</option> 
                            <option value="3">Circle 1 seat</option> 
                        </select>
                      </div>
                  </div> 
                    <div class="form-group">
                      <label for="isu" class="col-sm-2 control-label">Lokasi</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="lokasi" name="lokasi" onChange="showLayout();">
                            <option value="">--- Pilih lokasi ---</option> 
                        <?php
                        $c = mysql_query("select * from tblmasterlokasi where status = 1 ");
                          while($cat = mysql_fetch_assoc($c)){
                            ?>  <option value='<?php echo $cat['kode_lokasi']; ?>'><?php echo $cat['nama_lokasi']; ?></option> <?php
                          } ?>
                          </optgroup> 
                        </select>
                      </div>
                  </div>

                 
                    <div class="form-group">
                      <div id="layout"></div>
                    </div>


                  </div><!-- /.box-body -->
                  <div class="box-footer">
 <div class="row">
            <div class="col-xs-4">
            <a class="fancybox fancybox.ajax" href="table/table_meja.php">	
              <button class="btn btn-primary btn-block btn-flat">List Meja</button>
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



function showLayout2(x,addx,y,addy,angle,angle_text){
  
  var meja =  $('#tipe_meja').val();
  var old_meja =  $('#old_meja').val();
  var id =  $('#lokasi').val();
  var name =  $('#name').val();

//alert(meja+'|'+old_meja);
  //alert(x);
  $('#layout').load("themes/master_layout_meja.php?act=edit&id="+id+"&name="+name+"&meja="+meja+"&oldmeja="+old_meja+"&x_koor="+x+"&addx="+addx+"&y_koor="+y+"&addy="+addy+"&angle_koor="+angle+"&angle_text="+angle_text);

}
function showLayout(){
  var meja =  $('#tipe_meja').val();
  var id =  $('#lokasi').val();
  $('#layout').load("themes/master_layout_meja.php?id="+id+"&meja="+meja);
  //alert(meja+'|'+id);
}
$("#XForm").submit(function(event) {
	var name = $('#name').val();
  var cat =  $('#lokasi').val();
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
        $('#lokasi').val('');
	    $("#isi").load("themes/master_meja.php");
        $("#isi").css({'display':''});
        //$("#list_product").load("table/table_product.php");
		//$.fancybox.close();
      });

      
    }
});	


</script>