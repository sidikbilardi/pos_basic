<?php
include "../database.php";
$filter = '';
?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs">Kode</th>
                                                <th>Name</th>
                                                <th>Discount</th>
                                                <th>Svc</th>
                                                <th>Tax</th>
                                               
                                               
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT * FROM tblmastercustomer_type  where status = 1  ORDER BY nama_ctype");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td class="hidden-xs"><?php echo $pr['kode_ctype'];?></td>
                <td><?php echo $pr['nama_ctype']; ?></td>
                <td ><?php echo $pr['disc']; ?></td>
                <td><?php echo $pr['svc']; ?></td>
                <td><?php echo $pr['tax']; ?></td>
                 
                
                <td class="col-xs-3 col-md-3 col-lg-3">
                    <button onclick="editCat('<?php echo $pr['id'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deleteCat('<?php echo $pr['id'];?>','<?php echo $pr['kode_ctype'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
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
    var konfirmasi=confirm("Anda yakin ingin hapus Customer Type ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=DeleteCustType&id="+id+"&code="+code,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_type.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editCat(menu){
        $("#isi").load("themes/master_customer_type.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>