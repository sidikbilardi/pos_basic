<?php
include "../database.php";
$filter = '';
?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Name</th>
                                               
                                               
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT * FROM tblmasterissuer  where status = 1  ORDER BY nama_issuer");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td><?php echo $pr['kode_issuer'];?></td>
                <td><?php echo $pr['nama_issuer']; ?></td>
                 
                
                <td >
                    <button onclick="editI('<?php echo $pr['id'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deleteI('<?php echo $pr['id'];?>','<?php echo $pr['kode_issuer'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
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

function deleteI(id,code){
    var konfirmasi=confirm("Anda yakin ingin hapus Issuer ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=Deleteissuer&id="+id+"&code="+code,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_issuer.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editI(menu){
        $("#isi").load("themes/master_issuer.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>