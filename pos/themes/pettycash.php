<?php
session_start();
include "../database.php";
include "../inc/func.php";

$user = $_SESSION['logged_id'];
if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_manager') == '1'){ ?>			
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
 
<?php } 

?>
<div class="col-lg-12 col-md-12">

 <?php
if($_SESSION['petty'] ==''){
  $c = mysql_query("SELECT *,COUNT(id) as cnt FROM tbl_pettycash where user='$user' AND out_time = '0000-00-00 00:00:00' ");
  $cek = mysql_fetch_array($c);
  if($cek['cnt'] > 0){ ?>
             <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Anda masih memiliki Petty cash dengan modal <?php echo number_format($cek['modal']); ?></h3>
                  <h3 class="box-title">Total Cash terakhir yaitu :  <?php echo number_format($cek['modal']+$cek['transaksi']); ?></h3>
                  <input type="hidden" class="form-control" id="sementara" value="<?php echo $cek['modal']+$cek['transaksi'];?>">
                </div><!-- /.box-header -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
                  <div class="box-body">
                    <div id="nom_close">
                    <div class="form-group">
                      <label for="nominal" class="col-sm-6 control-label">Nominal Closing</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="closing" placeholder="Nominal Closing" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                    </div>
                  </div>                  
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button onclick="ContPetty('<?php echo $_SESSION['logged_id'];?>','<?php echo $cek['id'];?>')" class="btn btn-lg bg-navy">Continue!</button>
                    <button onclick="ClosePetty('<?php echo $_SESSION['logged_id'];?>','<?php echo $cek['id'];?>')" class="btn btn-danger btn-lg pull-right">Closed</button>
                  </div><!-- /.box-footer -->
                <!--/form-->
<?php  }else{ 
            if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_kasir') == '1'){  ?>
             <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Input New Pettycash</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
                  <div class="box-body">
                    <div class="form-group">
                      <label for="nominal" class="col-sm-2 control-label">Nominal</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nominal" placeholder="Nominal Pettycash" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button onclick="doPetty('<?php echo $_SESSION['logged_id'];?>')" class="btn btn-lg bg-navy">Go!</button>
                  </div><!-- /.box-footer -->
                <!--/form-->
<?php  } }
}else{
    $c = mysql_query("SELECT *,COUNT(id) as cnt FROM tbl_pettycash where user='$user' AND out_time = '0000-00-00 00:00:00' ");
    $cek = mysql_fetch_array($c);
?>
<div class="col-lg-8 col-md-8">
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Customer Summary</h3>

    </div><!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover" id="example2">
        <tbody>
        <tr>
          <th class='hidden-xs'>Trx</th>
          <th>Location</th>
          <th class="hidden-xs">Time in</th>
          <th>Last Order</th>
          <th>Pending Item</th>
          <th class='hidden-xs'>Value</th>
          <th>Billing</th>
        </tr>
        <?php $t = mysql_query("
                  SELECT * FROM (SELECT no_bukti as trx,time_in,kode_meja,svc,tax FROM tbltransorder_master where keterangan = 'OPEN') A 
                  LEFT JOIN(SELECT no_bukti,time_order,keterangan,sum(qty) as qty,sum(qty*harga) as jml, sum(IF(keterangan = '','1','0')) as result FROM (select * from tbltransorder_detail where status = 1  ORDER BY time_order DESC) z GROUP BY no_bukti  ) B ON A.trx = B.no_bukti 
                  LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) C ON C.kode_meja = A.kode_meja 
                  LEFT JOIN (SELECT kode_lokasi,nama_lokasi FROM tblmasterlokasi )D ON D.kode_lokasi = C.kode_lokasi ORDER BY time_order ASC");
        while($tr = mysql_fetch_assoc($t)){
          $bukti = $tr['trx'];
          $loc = $tr['nama_lokasi'].' - '.$tr['nama_meja'];
          
          if($tr['time_order'] == '' ){
            $last = 'No order yet';
          }else{
            $last = $tr['time_order'];
          }
          if($tr['result'] >0){
            $pending = $tr['result'];
          }else{
            $pending = 0;
          }
          if($tr['jml'] >0){
            $value = number_format($tr['jml']).' for '.$tr['qty'].' Items';
          }else{
            $value='';
          }
          
          echo "<tr>";
          echo "<td class='hidden-xs'>$bukti</td>";
          echo "<td><strong>$loc</strong></td>";
          echo "<td class='hidden-xs'>$tr[time_in]</td>";
          echo "<td>$last</td>";
          echo "<td>$pending Menus</td>";
          echo "<td class='hidden-xs'>$value</td>";
          ?>
          <td><div class='btn btn-success' onClick="BILL('<?php echo $tr['kode_meja'];?>','<?php echo $tr['trx'];?>','<?php echo $tr['svc'];?>','<?php echo $tr['tax'];?>')"><i class='glyphicon glyphicon-shopping-cart'></i></div> </td>
          <?php
          echo "</tr>";

        }
        ?>

      </tbody></table>
    </div><!-- /.box-body -->
  </div>
  </div>

<div class="col-lg-4 col-md-4">
             <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Pettycash Summary</h3>
                     <input type="hidden" class="form-control" id="sementara" value="<?php echo $cek['modal']+$cek['transaksi'];?>">

                </div><!-- /.box-header -->
                <!-- form start -->
                <!--form class="form-horizontal"-->
                  <div class="box-body">
                    <div class="form-group">
                      <label for="nominal" class="col-sm-6 control-label">Modal</label>
                      <div class="col-sm-6">
                        <label>: <?php echo number_format($cek['modal']);?></label 
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nominal" class="col-sm-6 control-label">Cash</label>
                      <div class="col-sm-6">
                        <label>: <?php echo number_format($cek['modal']+$cek['transaksi']);?></label 
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                    <div id="nom_close">
                    <div class="form-group">
                      <label for="nominal" class="col-sm-6 control-label">Nominal Closing</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="closing" placeholder="Nominal Closing" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);">
                      </div>
                    </div>
                  </div>                  
                  <div class="box-footer">
                    <button onclick="ClosePetty('<?php echo $_SESSION['logged_id'];?>','<?php echo $cek['id'];?>')" class="btn btn-lg bg-navy">Close Pettycash</button>
                  </div><!-- /.box-footer -->

</div>
<?php  
}

?>              
              </div><!-- /.box -->

<script>

            // Set NumPad defaults for jQuery mobile. 
            // These defaults will be applied to all NumPads within this document!
            $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
            $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
            $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
            $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
            $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
            $.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};
            


function ContPetty(user,petty){
    $.ajax({
      type: "POST",
      url: "inc/login.php",
      data: "action=ContPettycash&usr="+user+"&petty="+petty,
      cache: false,
      success: function(msg){
      alert(msg);
      location.reload();
 
    }});   
}
function ClosePetty(user,petty){
    var sementara = $("#sementara").val();
    var nom = $("#closing").val();
    var konfirmasi=confirm("Apakah anda yakin menutup pettycash sebesar "+nom+"? ");
    if (konfirmasi==true)
    { 
    $.ajax({
      type: "POST",
      url: "inc/login.php",
      data: "action=ClosePettycash&usr="+user+"&petty="+petty+"&nom="+nom+"&sementara="+sementara,
      cache: false,
      success: function(msg){
      alert(msg);
      location.reload();
 
    }});

    }
}
function doPetty(user){
  var nom = $("#nominal").val();
    var konfirmasi=confirm("Apakah anda yakin menginput pettycash sebesar "+nom+"? ");
    if (konfirmasi==true)
    { 
    $.ajax({
      type: "POST",
      url: "inc/login.php",
      data: "action=doPettycash&usr="+user+"&nom="+nom,
      cache: false,
      success: function(msg){
        alert(msg);
       location.reload();
 
    }});

    }
}

function isNumberKey(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
//counts(val);
if (charCode > 31 && (charCode < 46 || charCode > 57))

return false;
return true;

}

  $(document).ready(function() {
               $('#nominal').numpad({
                hidePlusMinusButton: true,
                hideDecimalButton: true 
               });
               $('#closing').numpad({
                hidePlusMinusButton: true,
                hideDecimalButton: true 
               });

    
  }); 

</script>              
