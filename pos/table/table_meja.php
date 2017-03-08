<?php
include "../database.php";
$filter = $_GET['filter'];

?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs">Kode</th>
                                                <th>Name</th>
                                                <th>Lokasi</th>
                                               
                                               
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("SELECT A.id,A.kode_meja,A.nama_meja,B.nama_lokasi FROM tblmastermeja A, tblmasterlokasi B  where A.status = 1  AND A.kode_lokasi = B.kode_lokasi ORDER BY A.nama_meja");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td class="hidden-xs"><?php echo $pr['kode_meja'];?></td>
                <td ><?php echo $pr['nama_meja']; ?></td>
                <td><?php echo $pr['nama_lokasi']; ?></td>
                  
                
                <td>
                    <button onclick="editCat('<?php echo $pr['id'];?>')" class="btn btn-info btn-sm">Edit</button>
                    <button onClick="deleteCat('<?php echo $pr['id'];?>','<?php echo $pr['kode_meja'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
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
    var konfirmasi=confirm("Anda yakin ingin hapus Meja ? ");
    if (konfirmasi==true)
    {   
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=DeleteMeja&id="+id+"&code="+code,
            cache: false,
            success: function(msg){
                
                alert(msg);
                 $.fancybox.close();
                 $("#isi").load("themes/master_meja.php");
                //$("#previewOrder").load("themes/order_preview.php?trx="+trx);
                //window.location.href = "?page=review&trx="+trx+"&meja="+meja;

        }});
    }   
}
function editCat(menu){
        $("#isi").load("themes/master_meja.php?do=edit&menu="+menu);
        $("#isi").css({'display':''});
        $.fancybox.close();
}
</script>