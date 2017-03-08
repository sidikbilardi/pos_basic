<?php
include"../database.php";

?>
		<br>
	  <table id="example1" class="table table-hover">
	    <thead><tr>
	      
	      <th>Customer</th>
	      <th>Meja</th>
	      <th>Booking Time</th>
	      <th>Reason</th>
	      <th>Action</th>
	    </tr>

      </thead>
        <tbody>
		<?php
		if($_GET['id'] != 'booking'){
		$id = $_GET['id'];
			$d = mysql_query("SELECT *,A.keterangan as ket,A.id as idBook,A.status as status_book FROM tbltrans_booking A,tblmastermeja B,tblmasterlokasi C where C.kode_lokasi = B.kode_lokasi AND A.kode_meja = B.kode_meja AND A.kode_meja = '$id' AND A.status = 2 ORDER BY time_book limit 10");
		}else{
			$d = mysql_query("SELECT *,A.keterangan as ket,A.id as idBook,A.status as status_book FROM tbltrans_booking A,tblmastermeja B,tblmasterlokasi C where C.kode_lokasi = B.kode_lokasi AND A.kode_meja = B.kode_meja AND A.status = 2 ORDER BY time_book");

		}

		while($dd = mysql_fetch_assoc($d)){
				
		  if($_GET['id'] != 'booking'){

		  }else{
			$id = $dd['kode_meja'];
		  }
			?>
		    <tr>                
              <td><?php echo $dd['cust'];?></td>
              <td><?php echo $dd['nama_lokasi'].' - '.$dd['nama_meja'];?></td>
              <td><?php echo $dd['time_book'];?></td>
              <td><?php echo $dd['ket'];?></td>
              <td>
			  	<?php if($_GET['id'] != 'booking'){
				$id = $_GET['id'];?>
					<div class="btn btn-flat btn-danger" onClick="cancelBook('<?php echo $dd['idBook']; ?>','<?php echo $dd['cust']; ?>','<?php echo $id; ?>');">Cancel</div>				
				<?php }else{ ?>
					<div class="btn btn-flat btn-danger" onClick="cancelBook('<?php echo $dd['idBook']; ?>','<?php echo $dd['cust']; ?>','<?php echo $dd['kode_meja']; ?>');">Cancel</div>

				<?php }
				?>
			  

              	<div class="btn btn-flat btn-success" onClick="doneBook('<?php echo $dd['idBook']; ?>','<?php echo $dd['cust']; ?>','<?php echo $id; ?>');">Success</div>
              </td>
            </tr>
		<?php } ?>


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
  	</script>