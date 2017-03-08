<?php 
include "../database.php";
								$no = 1;
$rs = mysql_query("SELECT * from (SELECT no_bukti,kode_menu,qty as jumlah,keterangan FROM tbltransorder_detail WHERE zstatus = '' AND keterangan = '' AND LEFT(kode_menu,3) != 'CMT' AND LEFT(kode_menu,3) != 'DSC' GROUP by no_bukti,kode_menu ORDER by time_order) A 
		LEFT JOIN 
		(SELECT no_bukti,kode_menu,qty,comment FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'CMT') B
		ON A.kode_menu = RIGHT(B.kode_menu,5) AND A.no_bukti = B.no_bukti
		LEFT JOIN (select nama_menu,kode_cat,kode_menu FROM tblmastermenu) C ON A.kode_menu = C.kode_menu
		LEFT JOIN (select no_bukti ,kode_meja FROM tbltransorder_master )D ON A.no_bukti = D.no_bukti
		LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) E ON D.kode_meja = E.kode_meja
		LEFT JOIN (select kode_lokasi,nama_lokasi from tblmasterlokasi) F ON F.kode_lokasi = E.kode_lokasi");
while($rd = mysql_fetch_assoc($rs)){
								?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $rd['nama_menu']; ?></td>
                                                <td><?php echo $rd['comment']; ?></td>
                                                <td><?php echo $rd['nama_lokasi']." - ".$rd['nama_meja']; ?></td>
                                                <td><?php echo $rd['jumlah']; ?></td>
                                                <td><button onClick="doStartKitchen('<?php echo $rd['kode_menu']; ?>','<?php echo $rd['no_bukti']; ?>')">Done ?</button></td>
                                            </tr>
<?php
$no++;
 }?>