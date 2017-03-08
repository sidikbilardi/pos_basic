<?php
include "../database.php";
$trx = $_GET['trx'];
?>
<head>
    <!-- DataTables >
    <link rel="stylesheet" href="../css/datatables/dataTables.bootstrap.css"-->
    

</head>
<section class="content">
	<label class="">
		<form name="myForm">
            <input type="radio" name="myRadios" id="myRadios" checked="checked" value="new" >New Transaction</input>
            <input type="radio" name="myRadios" id="myRadioss"  value="old" >Transaction</input>
        </form>	
	</label>

	
	<div class="old_trx">
	<label class="">
	
	  <input type="hidden" id="old_trx" name="old_trx" value="<?php echo $trx;?>"/>
	  <div class="form-group">
                      
                      <select class="form-control" id="split_trx" name="split_trx">
                        <option value="">--- Pilih Transaction ---</option>
 	  <?php
	  $m = mysql_query("SELECT IFNULL(C.no_bukti, '') no_bukti,C.id,C.no_bukti,A.kode_meja, A.nama_meja,B.nama_lokasi, IFNULL(C.pax, '') pax, IFNULL(C.time_in, '') time_order, IFNULL((SELECT SUM(qty*harga) sales FROM tbltransorder_detail WHERE no_bukti = C.no_bukti),0) sales,A.status, IFNULL(C.disc,0) disc, IFNULL(C.svc,0) svc, IFNULL(C.tax,0) tax FROM tblmastermeja A LEFT OUTER JOIN tblmasterlokasi B ON A.kode_lokasi = B.kode_lokasi LEFT OUTER JOIN tbltransorder_master C ON A.kode_meja = C.kode_meja AND C.keterangan = 'OPEN' AND C.no_bukti != '$trx' AND C.status <> 0 WHERE A.status <> 0 ORDER BY A.nama_meja");
	  while($meja = mysql_fetch_assoc($m)){
	  	if($meja['id'] == ''){

	  	}else{
	        ?>                <option value='<?php echo $meja['no_bukti']; ?>'><?php echo  $meja['nama_lokasi'].' - '.$meja['nama_meja'].' - '. $meja['no_bukti']; ?></option> <?php
   	
	  }
	  }
	  ?>
                    </select>
                    </div>
	 
	  <input type="hidden" id="pesan_id1" name="pesan_id1" />
	  <input type="hidden" id="qty" name="qty" />
	  <input type="hidden" id="dsc" name="dsc" />
	  <input type="hidden" id="kd_mn" name="kd_mn" />
	  <input type="hidden" id="cmt" name="cmt" />
	
	</label></div>

<div class="col-lg-12">	
		<div class="row">
			<div class="box box-danger">
				
				
				<div class="col-lg-12">		
			<div class="row">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Split Bill <?php echo $trx;?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
 
<table  id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Menu</th>
                        <th>Qty</th>
                         <th>Transfer Qty</th>
                     </tr>
                    </thead>
                    <tbody>
 <?php
$no = 1;
$d = mysql_query("SELECT * FROM(SELECT A.*,B.nama_menu,B.kode_menu as kd_mn FROM tbltransorder_detail A,tblmastermenu B where A.no_bukti = '$trx' AND LEFT(A.kode_menu,3) != 'DSC' AND LEFT(A.kode_menu,3) != 'CMT' and A.zstatus = '' AND A.status = 1 AND A.kode_menu = B.kode_menu) Z 
LEFT JOIN (SELECT comment_to as cmt_dsc,qty as qty_disc,harga as disc,kode_menu,comment as id_disc FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'DSC') Y ON Y.cmt_dsc = Z.id AND RIGHT(Y.kode_menu,5) = Z.kd_mn
LEFT JOIN (SELECT comment_to as cmt_cmt,kode_menu,comment as id_disc FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'cmt') X ON X.cmt_cmt = Z.id AND RIGHT(X.kode_menu,5) = Z.kd_mn
");
while($data = mysql_fetch_assoc($d)){
?>
			<tr>
            <td><input type="checkbox" name="cek[]" id="cek[]" class="chk_<?php echo $data['id']?>" onclick="return pilih1('<?php echo $data['id']?>');" value="<?php echo $data['id']?>" style="width:10px" /></td>
            <td><?php echo $data['nama_menu']; ?></td>
            <td><?php echo $data['qty']; ?></td>
            <td>
			<input value="0" type='number' onChange="checkthis(<?php echo $data['id']?>,this.value);" max='<?php echo $data['qty']; ?>' min='1' id="qty_<?php echo $data['id'];?>" name="qty_<?php echo $data['id'];?>" />
			
			<!-- Hidden field batas qty -->
			<input value="<?php echo $data['qty']; ?>" type="hidden" id="bts_<?php echo $data['id'];?>" name="bts_<?php echo $data['id'];?>" />
			<!-- Hidden field field dsc -->			
			<input value="<?php echo $data['cmt_dsc']; ?>" type="hidden" id="dsc_<?php echo $data['id'];?>" name="dsc_<?php echo $data['id'];?>" />
			<!-- Hidden field kode_menu -->			
			<input value="<?php echo $data['kd_mn']; ?>" type="hidden" id="kd_<?php echo $data['id'];?>" name="kd_<?php echo $data['id'];?>" />
			<!-- Hidden field comment -->			
			<input value="<?php echo $data['cmt_cmt']; ?>" type="hidden" id="cmt_<?php echo $data['id'];?>" name="cmt_<?php echo $data['id'];?>" />
			</td>
 
			</tr>
<?php } ?>	
	
	
                  </table>	
</div>
	<div class="box-footer">
        <div id="submit_button" name="submit_button" onclick="transferItem();" class="btn btn-primary btn-lg">Transfer</div>
	    <div id="cancel_button" name="cancel_button" onclick="CancelMenu('<?php echo $trx;?>')" class="btn btn-danger btn-lg">Cancel</div>

	</div>
</div>
	
    </div> 
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				

	</section>
<script>
function checkthis(e,value){
	if(value != 0){
		$(".chk_"+e).prop("checked", true);
	}else{
		$(".chk_"+e).prop("checked", false);
	}
	//console.log("."+e);
		var val = [];
		var qty = [];
		var dsc = [];
		var kd = [];
		var cmt = [];
		$("input[name='cek[]']:checked").each(function(i){
			val[i] = $(this).val();
			qty[i] = $("#qty_" +$(this).val()).val();
			dsc[i] = $("#dsc_" +$(this).val()).val();
			kd[i] = $("#kd_" +$(this).val()).val();
			cmt[i] = $("#cmt_" +$(this).val()).val();
			
		});
		//alert(qty);
		$("#pesan_id1").val(val);
		$("#qty").val(qty);
		$("#dsc").val(dsc);
		$("#kd_mn").val(kd);
		$("#cmt").val(cmt);
		//$("#locker_code1").focus();	
}
function CancelMenu(trx){
	alert(trx);
	$.fancybox.close();
}
function transferItem(){
	var radio1 = $("#myRadios").val();
	var radio2 = $("#myRadioss").val();
	var id_pesan = $("#pesan_id1").val();
	var qty_pesan = $("#qty").val();
	var dsc = $("#dsc").val();
	var kd = $("#kd_mn").val();	
	var cmt = $("#cmt").val();
	var trx = $("#old_trx").val();
	var split_trx = $("#split_trx").val();

	var meja = $("#meja").val();
	var trx = $("#trx").val();
	var mj = '<?php echo $_GET[meja];?>';



if(document.getElementById("myRadios").checked == true){
	$("#split_trx").val('');

}else{

}
if(id_pesan != ''){
	var konfirmasi=confirm("Apakah Anda Yakin Ingin Split Item ?");
	if (konfirmasi==true)
	{
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=splitBill&id_pesan="+id_pesan+"&qty_pesan="+qty_pesan+"&dsc="+dsc+"&kd="+kd+"&cmt="+cmt+"&trx="+trx+"&split_trx="+split_trx,
			cache: false,
			success: function(msg){
				//alert(msg);
				$.fancybox.close();  
				//console.log(msg);
				//$("#billing").load('');
				$("#billing").load("inc/billing.php?meja="+mj+"&trx="+trx);
				//$("#previewOrder").load("themes/order_preview.php");
			//	window.location.reload(true);
		}});
	
	}
}else{
	if(split_trx ==''){
	alert("Anda belum memilih Transaksi"+split_trx);
	}else{
	alert("Anda belum memilih item"+split_trx);		
	}

}
}
function isNumberKeys(evt,qty)
{
	var batas = qty.keyCode
alert(batas);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))

return false;
return true;

}
	$(document).ready(function() {
		 $('#split_trx').css({'display':'none'});
	});	

var rad = document.myForm.myRadios;
var prev = null;
for(var i = 0; i < rad.length; i++) {
    rad[i].onclick = function() {
        (prev)? console.log(prev.value):null;
        if(this !== prev) {
            prev = this;
        }
        $("#split_trx").val('');
		if(this.value == 'old'){
			$('#split_trx').css({'display':''});
		}else{
			$('#split_trx').css({'display':'none'});
		}
       
    };
}

function pilih1(id){
		var val = [];
		var qty = [];
		var dsc = [];
		var kd = [];
		var cmt = [];
		$("input[name='cek[]']:checked").each(function(i){
			val[i] = $(this).val();
			qty[i] = $("#qty_" +$(this).val()).val();
			dsc[i] = $("#dsc_" +$(this).val()).val();
			kd[i] = $("#kd_" +$(this).val()).val();
			cmt[i] = $("#cmt_" +$(this).val()).val();
			
		});
		//alert(qty);
		$("#pesan_id1").val(val);
		$("#qty").val(qty);
		$("#dsc").val(dsc);
		$("#kd_mn").val(kd);
		$("#cmt").val(cmt);
		//$("#locker_code1").focus();
	}				

</script>
	