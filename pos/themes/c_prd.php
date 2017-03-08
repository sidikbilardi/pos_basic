<?php
session_start();
?>
<div class="box-header">
    <h3 class="box-title">Connect Product Menu</h3>
</div>

<div class="box-body table-responsive">
		<div class="container-fluid">
			<div>

	
<?
 
	/*
	*	The sample code below makes 2 database connections and the reference to each database connection is stored in separate variables.
	*   Whenever you connect multiple databases you have to specify the link in mysql_query function to tell PHP to run the query
	*   on the specified database.
	*/
 
	$link1=mysql_connect($_SESSION['link1'],"root","masterkey");
	mysql_select_db($_SESSION['db1']);
 
 
	$link2=mysql_connect($_SESSION['link2'],"root","masterkey",true);
	mysql_select_db($_SESSION['db2'],$link2);
 
//	$result1=mysql_query("select * from tblmastermenu",$link1);
//	show_data($result1);
	$result1 = mysql_query("SELECT * FROM tblmastermenu a,tblmastercategory b where a.status = 1 AND a.kode_cat = b.kode_cat ORDER BY b.nama_cat,a.nama_menu",$link1);
	?> 
	        <div class="form-group">
                <label>POS Product</label>
               <?php show_data($result1);       ?>                      
        </div><!-- /.form group -->
<?php
	
	
	$result2=mysql_query("SELECT * from tblmasterbarang where status = 1 ORDER BY nama_barang",$link2);
	$result3=mysql_query("SELECT * from tblmasterresep where status = 1 ORDER BY nama_resep",$link2);
	?> 
	        <div class="form-group">
                <label>Inventory Product</label>
               <?php show_data_inv($result2,$result3);       ?>                      
        </div><!-- /.form group -->
<?php	

	mysql_close($link1);
	mysql_close($link2);
	

	function show_data($result){
		$x=mysql_num_fields($result);
		echo "<select class='form-control' id='pilih1' name='pilih1'>"; 
		echo "<option value=''>-------- Pilih Product ---------</option>";
		
		while($row=mysql_fetch_array($result)){
						
			
				echo "<option value='".$row['kode_menu']."'>".$row['nama_cat'].' - '.$row['nama_menu']."</option>";
			
			
		}
		echo "</select>";
	}

	function show_data_inv($result,$result3){
		$x=mysql_num_fields($result);
		echo "<select class='form-control' id='pilih2' name='pilih2'>"; 
		echo "<option value=''>-------- Pilih Product ---------</option>";
		while($row=mysql_fetch_array($result)){
						
			
				echo "<option value='".$row['kode_barang']."'>".$row['nama_barang']."</option>";
			
			
		}
		echo '<optgroup label="Recipe Item">';
		while($rows=mysql_fetch_array($result3)){
						
			
				echo "<option value='".$rows['kode_resep']."'>".$rows['nama_resep']." - ".$row['kode_resep']."</option>";
			
			
		}
		
		echo "</optgroup></select>";
	}
 ?>

		<div class="box-footer">
						<button onClick="addTrf();" class="btn btn-primary">Submit</button>
		</div>
		<div id="tbltransfer">
		</div>

 									
	
</div></div></div>	

<script>
	$(document).ready(function() {
		$("#tbltransfer").load("table/tbl_transfer.php");		
	});	
</script>
