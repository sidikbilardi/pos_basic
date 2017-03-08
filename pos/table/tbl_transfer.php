<?php
include "../database.php";
?>
<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>POS Product</th>
                                                <th>Inv Product</th>
                                                <th>Time Create</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
		<?php
		$q = mysql_query("select * from (SELECT * FROM tblmastermenu A,tblpos_to_inv b where A.kode_menu = B.pos_id ORDER BY B.input_date DESC) A GROUP BY kode_menu ORDER BY nama_menu");
		while($pr = mysql_fetch_assoc($q)){
			?>
			<tr>
                 <td><?php echo $pr['nama_menu']?></td>
                <td><?php echo $pr['inv_id']?></td>
                <td><?php echo $pr['input_date']?></td>        
             </tr>			
			<?php			
		}
?>			
                                            
                                           
                                        </tbody>
                                        
</table>