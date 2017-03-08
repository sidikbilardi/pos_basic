<!doctype html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
</head>
<body>
<h1>Ajax File Upload Demo</h1>
 
<form id="XForm" action="upload.php" method="post" enctype="multipart/form-data">
    
      
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
                       <input name="myfile" id="myfile" type="file" style="cursor:pointer;" />
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
    
</div>
 </form>
 
 <div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<br/>
 
<div id="message"></div>
 
<script>
$(document).ready(function()
{
 
    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
        $("#message").html("<font color='green'>"+response.responseText+"</font>");
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#XForm").ajaxForm(options);
 
});
 
</script>
</body>
 
</html>