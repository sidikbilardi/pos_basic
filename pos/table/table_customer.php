<?php
include "../database.php";
$filter = $_GET['filter'];

?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                               
                                               
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT A.kode_cust,A.id,A.nama_cust,B.nama_ctype FROM tblmastercustomer A, tblmastercustomer_type B  where A.status = 1  AND A.kode_ctype = B.kode_ctype ORDER BY A.nama_cust");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td><?php echo $pr['kode_cust'];?></td>
                <td><?php echo $pr['nama_cust']; ?></td>
                <td><?php echo $pr['nama_ctype']; ?></td>
                  
                
                <td>
                    <button onclick="editCat('<?php echo $pr['id'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deleteCat('<?php echo $pr['id'];?>','<?php echo $pr['kode_cust'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
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
    var konfirmasi=confirm("Anda yakin ingin hapus Customer ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=DeleteCust&id="+id+"&code="+code,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_customer.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editCat(menu){
        $("#isi").load("themes/master_customer.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>