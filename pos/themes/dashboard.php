<?php
session_start();
include "../database.php";
include "../inc/func.php";

$user = $_SESSION['logged_id'];
?>
<div class="col-lg-8 col-md-8">
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Pettycash Today Summary</h3>

    </div><!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover" id="example2">
        <tbody>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Time in</th>
          <th>Time out</th>
          <th>Modal</th>
          <th>Trx Value</th>
        </tr>
        <?php
        $p = mysql_query("SELECT * FROM tbl_pettycash A,tblmasterwaiter B where A.user = B.kode_waiter AND A.zstatus = '' order by A.out_time");
        while($pp = mysql_fetch_assoc($p)){ ?>
	        <tr>
	          <th><?php echo $pp['user'];?></th>
	          <th><?php echo $pp['nama_waiter'];?></th>
	          <th><?php echo $pp['in_time'];?></th>
	          <th><?php echo $pp['out_time'];?></th>
	          <th><?php echo number_format($pp['modal']);?></th>
	          <th><?php echo number_format($pp['transaksi']);?></th>
	        </tr>
        <?php }
        ?>
        
      </tbody></table>
    </div><!-- /.box-body -->
  </div>
  </div>