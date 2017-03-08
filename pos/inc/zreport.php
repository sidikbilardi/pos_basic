<?php

	
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
                  <h3 class="box-title">R E P R I N T      Z - R E P O R T</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
 					
<table  id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Action</th>
                     </tr>
                    </thead>
                    <tbody>
	<?php 
$q = mysql_query("SELECT A.id,A.close_date,B.nama_waiter FROM tbl_zreport A,tblmasterwaiter B where A.user = B.kode_waiter ");
while($data = mysql_fetch_assoc($q)){
	$close = date("Y-m-d",strtotime($data['close_date']));
	?>
         <tr>
            <td><?php echo $data['close_date'];?></td>
            <td><?php echo $data['nama_waiter'];?></td>
            <td>	
			<button onClick="rePrintZreport('<?php echo $data['id'];?>','<?php echo $close;?>')" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-print"></i>
			
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
<div id="zreport_detail"></div>
			
		
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
	  
	function rePrintZreport(id,close){
		var konfirmasi=confirm("Apakah Anda Yakin Ingin Reprint Report ini ?");
		if (konfirmasi==true)
		{	
			$("#zreport_detail").load("inc/zreport_detail.php?id="+id+"&close="+close);
		/*$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=rePrintZreport&id="+id,
			cache: false,
			success: function(msg){
				alert("Reprint Bill Berhasil");
				$.fancybox.close();
				
		}});
*/
		}
	}
/*
   var printContent = document.getElementById('rezreport_list').innerHTML;
		    var original = document.body.innerHTML;

		    document.body.innerHTML = printContent;
		    //alert("elelel");
		    window.print();
		    document.body.innerHTML = original;  	

		    */
    </script>	
	<?php
