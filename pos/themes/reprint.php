<?php
if($_GET['reprint'] == 'bill'){
	
	include "../database.php";
?>
<head>
    <!-- DataTables >
    <link rel="stylesheet" href="../css/datatables/dataTables.bootstrap.css"-->
    

</head>
<section class="content">
		<div class="row">
			<div class="box box-danger">
				
				
				<div class="col-lg-12">		
			<div class="row">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">B I L L I N G</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
 					
<table  id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Transaction</th>
                        <th>Amount</th>
                        <th>Action</th>
                     </tr>
                    </thead>
                    <tbody>
	<?php 
$q = mysql_query("SELECT * FROM tbltrans_summary A ,tbltransorder_master B where A.no_bukti = B.no_bukti AND A.zstatus = '' AND B.keterangan = 'CLOSE' AND B.status = 1 ");
while($data = mysql_fetch_assoc($q)){
	?>
         <tr>
            <td><?php echo $data['no_bukti'];?></td>
            <td><?php echo number_format($data['total']);?></td>
            <td>	
			<button onClick="rePrintBill('<?php echo $data['no_bukti'];?>')" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-print"></i>
			<button onClick="VOIDBill('<?php echo $data['no_bukti'];?>')" class="btn btn-info btn-sm">VOID</button>
</td>
			</tr>
	
	
	<?php
}
?>
                  </table>	
</div></div>
	
    </div> 




					
						
					
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>
    <!-- DataTables >
    <script src="../js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../js/plugins/datatables/dataTables.bootstrap.min.js"></script-->
   <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
	  
	function rePrintBill(id){
		var konfirmasi=confirm("Apakah Anda Yakin Ingin Reprint Bill "+id+" ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=rePrintBill&id="+id,
			cache: false,
			success: function(msg){
				alert("Reprint Bill Berhasil");
				$.fancybox.close();
				
		}});
		}
	}
	function VOIDBill(id){
		var konfirmasi=confirm("Apakah Anda Yakin Ingin Void Bill "+id+" ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=VoidBill&id="+id,
			cache: false,
			success: function(msg){
				alert(msg);
				//$.fancybox.close();
				
		}});
		}
		
	}
    </script>	
	<?php
}
?>