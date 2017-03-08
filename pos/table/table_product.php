<?php
include "../database.php";
$filter = '';
?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Product</th>
                                                <th class="hidden-xs">Category</th>
                                                <th class="hidden-xs">Printer</th>
                                                <th>Harga</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT *,A.id as id_menu FROM tblmastermenu A,tblmastercategory B,tblmasterprinter C where A.status = 1 AND B.status = 1 ".$filter." AND A.kode_cat = B.kode_cat AND A.kode_printer = C.kode_printer ORDER BY A.nama_menu");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td  class="col-sm-2"><?php echo $pr['nama_menu'];?></td>
                <td class="col-sm-2 hidden-xs"><?php echo $pr['nama_cat']; ?></td>
                <td class="col-sm-2 hidden-xs"><?php echo $pr['printer_loc']; ?></td>        
                <td class="col-sm-2"><?php echo $pr['harga']; ?></td>        
                <td class="col-sm-2"><img src="img/menu/<?php echo $pr['img']; ?>" style="width:154px;height:78px;"></td>        
                <td class="col-sm-2">
                    <button onclick="editPrd('<?php echo $pr['id_menu'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deletePrd('<?php echo $pr['id_menu'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
</td>         
              </tr>			
			<?php			
		}
?>			
                                            
                                           
                                        </tbody>
                                        
</table>
<script>
    $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo" : false,
                    "bAutoWidth": false
                });
            });

function deletePrd(id){
    var konfirmasi=confirm("Anda yakin ingin hapus Product ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=DeletePrd&id="+id,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_product.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editPrd(menu){
        $("#isi").load("themes/master_product.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>