<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
          	<button class="btn btn-success btn-lg" onClick="ee()">New Order</button>			
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="trx"><input type="text" class="form-control" id="meja">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<div id="pilihan">
<?php
	date_default_timezone_set('Asia/Jakarta');
	$todayDate = date("Y-m-j H:i:s");
	include "../database.php";
	$rs = mysql_query("SELECT IFNULL(C.no_bukti, '') no_bukti, A.status as status_meja,A.kode_meja, A.nama_meja, IFNULL(C.pax, '') pax, IFNULL(C.time_in, '') time_order, IFNULL((SELECT SUM(qty*harga) sales FROM tbltransorder_detail WHERE no_bukti = C.no_bukti),0) sales,A.status, IFNULL(C.disc,0) disc, IFNULL(C.svc,0) svc, IFNULL(C.tax,0) tax FROM tblmastermeja A LEFT OUTER JOIN tblmasterlokasi B ON A.kode_lokasi = B.kode_lokasi LEFT OUTER JOIN tbltransorder_master C ON A.kode_meja = C.kode_meja AND C.keterangan = 'OPEN' AND C.status <> 0 WHERE A.status <> 0 AND A.kode_lokasi = '".$_GET['id']."' ORDER BY A.nama_meja,no_bukti");
	//$rs = mysql_query("SELECT * FROM (SELECT * FROM tblmastermeja where status != 0 AND kode_lokasi = '".$_GET['id']."') A LEFT JOIN (SELECT no_bukti,kode_meja as kd_meja FROM tbltransorder_master where zstatus = '' AND keterangan = 'OPEN') B ON A.kode_meja = B.kd_meja ORDER BY nama_meja") ;
	while ($rd = mysql_fetch_assoc($rs)){
	if($_GET['chg'] == 'y'){
		if($rd['no_bukti'] != ''){ 
				$class = "btn btn-danger btn-lg disabled";
			}else{
				$class = "btn btn-success btn-lg";
			} 
	?>
	<button class="<?php echo $class;?>"  onClick="change_meja('<?php echo $rd['kode_meja'];?>','<?php echo $rd['nama_meja'];?>','<?php echo $_GET['trx'];?>')"><?php echo $rd['nama_meja']; ?></button>	
	<?php
	}else{	
?>	
	<div class="col-md-1 col-md-2 col-xs-4 col-sm-3">
	
		<?php 
		$time_order = strtotime($rd['time_order']);
		$d = mysql_query("SELECT upsell from tblutilitysetting");
		$dd = mysql_fetch_array($d);

		$date = date('Y-m-j H:i:s', strtotime('+'.$dd['upsell'].' minute', $time_order));
		if($rd['no_bukti'] != ''){
			if($date <= $todayDate){
				$bg = 'red';
				$font = 'white';
			}else{
				$bg = 'yellow';
				$font = 'black';
			} ?>
		<a data-toggle="modal" data-target="#exampleModal" data-meja="<?php echo $rd['kode_meja']; ?>" data-trx="<?php echo $rd['no_bukti']; ?>">
		<div class="circle" style="color:<?php echo $font; ?>;background:<?php echo $bg; ?>;">
			
			<div>
			<?php echo $rd['nama_meja']; ?>
			</div>
		</div>
		
		</a>
			
		<?php }else{ 
			if($rd['status_meja'] == 2){
				$bg = 'blue';
			}else{
				$bg = '#000';
				
			}
			?>
		<a data-toggle="modal" data-target="#exampleModal" data-meja="<?php echo $rd['kode_meja']; ?>" data-trx="<?php echo $rd['no_bukti']; ?>">
		<div class="circle" style="background:<?php echo $bg; ?>">
			
			<div>
			<?php echo $rd['nama_meja']; ?>
			</div>
		</div>

		</a>

		<?php } ?>
	</div>
	


	<?php } 
	}
	?>	
</div>
<a href="#"  value=\"View Detail\" class=\"link\"  onclick=\"DataDetail('123')\">alalal</a>
<div id="info"></div>
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var meja = button.data('meja') // Extract info from data-* attributes
  var trx = button.data('trx') // Extract info from data-* attributes
	var modal = $(this)
  modal.find('.modal-title').text('New message to ' + meja)
  modal.find('#trx').val(trx)
  modal.find('#meja').val(meja)
})

function DataDetail(id){
    $.ajax({
     type:"POST",
     url:"proses.php",    
     data: "id="+id,
     success: function(data){                 
       $("#info").html(data);
	   $("#info").dialog(
		{
			height: 500,width: 500,modal:true,
				buttons: {
				Close: function() {
				$( this ).dialog('close');
				}
			}
		});
     }  
    });
}
function change_meja(id,meja,trx){
		var konfirmasi=confirm("Apakah yakin pindah ke meja "+meja+" ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=change_meja&id="+id+"&trx="+trx,
			cache: false,
			success: function(msg){
				alert(msg);
				window.location.reload(true);
				
		}});
		}
}
function ee(){
	var trx = $("#trx").val();
	var meja = $("#meja").val();
	alert("?page=menu&meja="+meja+"&trx="+trx+"&no_meja="+meja);
	window.location.href = "?page=menu&meja="+meja+"&trx="+trx+"&no_meja="+meja;
}
</script>
	