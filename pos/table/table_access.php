<?php
include "../database.php";
$filter = $_GET['filter'];

?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                
                                                <th>Name</th>
                                                <th  class="hidden-xs">Access</th>
                                               
                                               
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT * FROM tbl_role where status = 1 ORDER BY name");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                
                <td class="col-sm-3"><?php echo $pr['name']; ?></td>
                <td class="col-sm-6 hidden-xs"><?php echo $pr['access']; ?></td>
                  
                
                <td class="col-sm-3">
                    <button onclick="editCat('<?php echo $pr['id'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deleteCat('<?php echo $pr['id'];?>','<?php echo $pr['name'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
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

function deleteCat(id,code){
    var konfirmasi=confirm("Anda yakin ingin hapus Access ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=DeleteAccess&id="+id+"&code="+code,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_access.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editCat(menu){
        $("#isi").load("themes/master_access.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>