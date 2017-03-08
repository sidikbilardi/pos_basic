<?php
$meja = $_GET['meja'];
$trx = $_GET['trx'];
include"../database.php";
	//$b = mysql_query("SELECT * FROM tbltransorder_master where no_bukti = '".$trx."'");
	$b = mysql_query("SELECT A.*,B.nama_meja,C.nama_lokasi,C.takeaway FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where B.kode_lokasi = C.kode_lokasi AND A.kode_meja = B.kode_meja AND A.no_bukti = '".$trx."'");
	
	$bb = mysql_fetch_array($b);
?>
        <!-- Calc style -->
        <link rel="stylesheet" href="css/jquery.numpad.css">
 


<section class="content">
		<div class="row">
			<div class="box box-danger">
				<div class="col-lg-7 col-md-8">
				<!--div class="box-header">
					<h3 class="box-title"><?php echo $trx.' - Table '.$bb['nama_lokasi'].' '.$bb['nama_meja'];
					//echo $trx.' - Table '.$meja; ?><input id="trx" name="trx" type="hidden" value ="<?php echo $trx;?>" class="form-control" /><input id="meja" name="meja" type="hidden" value =" <?php echo $meja;?>" class="form-control" /></h3>
                </div-->
				<div class="box-header">
					<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<h3 class="box-title"><i class="fa fa-inbox"><?php echo $trx.' - Table '.$bb['nama_lokasi'].' '.$bb['nama_meja']; ?></i>
					</div>	
					<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">										
						<button class="btn btn-flat btn-success btn-lg" onClick="previewBill('<?php echo $trx;?>','<?php echo $bb['disc'];?>','<?php echo  $bb['svc'];?>','<?php echo  $bb['tax'];?>')">Preview Bill</button>
						<a href="themes/disc_bill.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
							<button class="btn btn-flat btn-success btn-lg">Discount</button>
						</a>
						<a href="themes/change_table.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
							<button class="btn btn-flat btn-danger btn-lg">Change Table</button>
						</a>
						<a href="themes/split_bill.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
							<button class="btn btn-flat btn-danger btn-lg">Split Bill</button>
						</a>
					</div>
						<input id="trx" name="trx" type="hidden" value ="<?php echo $trx;?>" class="form-control" /><input id="meja" name="meja" type="hidden" value =" <?php echo $meja;?>" class="form-control" /></h3>
                </div>
				<div class="box-body">
				<div class="callout callout-success">
					<div class="col-sm-12">
					<div id="" style="overflow-y: scroll; height:250px;">
					<table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Satuan</th>
                                                <th>Nominal</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
						<?php
						$disc = 0;
						$qty_item = 0;
							$a = mysql_query("
							SELECT * FROM (SELECT A.id,A.no_bukti,B.nama_menu,A.kode_menu,A.qty as jml,A.harga FROM tbltransorder_detail A,tblmastermenu B where A.no_bukti = '".$trx."' AND A.status = 1 AND A.kode_menu = B.kode_menu AND LEFT(A.kode_menu,3) != 'CMT' AND LEFT(A.kode_menu,3) != 'DSC' ORDER by B.nama_menu) Z
							LEFT JOIN
							(SELECT A.comment_to,A.no_bukti,A.kode_menu,A.qty as diskon_qty,A.harga as diskon,A.comment,B.nama_disc FROM tbltransorder_detail A ,tblmasterdisc B WHERE LEFT(A.kode_menu,3) = 'DSC' AND A.comment = B.kode_disc AND A.no_bukti = '".$trx."') Y
							ON Z.id = Y.comment_to AND Z.no_bukti = Y.no_bukti
							LEFT JOIN(select comment as ket,comment_to,kode_menu from tbltransorder_detail where LEFT(kode_menu,3) = 'CMT' AND no_bukti = '".$trx."') X ON Z.id = X.comment_to") ;
							while($aa = mysql_fetch_assoc($a)){
								$qty_item += $aa['jml'];
								$disc = $aa['diskon']*$aa['diskon_qty'];
								if($aa['ket'] == ''){
									$info = '';
								}else{
									$info = ' - '.$aa['ket'];
								}
								$st = ($aa['harga']*$aa['jml']) - ($aa['diskon']*$aa['diskon_qty']*-1);
						?>		
							<tr>
								<td><?php echo $aa['nama_menu'].$info; ?> <br><?php
								if($disc != 0){
									echo 'DISC '.$aa['nama_menu'].' - '.$aa['nama_disc'];
								}?></td>
								<td><?php echo $aa['jml']; ?></td>
								<td><?php echo number_format($aa['harga']); ?> <br><?php
								if($disc != 0){
									echo '(@'.$aa['diskon'].')';
								}?></td>
								<td><?php echo number_format($st); ?></td>
							</tr>
						<?php	
								
								
								$subtotal = $subtotal + $st;
							}
						?>				
                                        
                                           
                                        </tbody>
                                        
				</table>
				</div>
				<div>
				<?php
				

				$disc_bill = $subtotal * $bb['disc']/100;
//				$svc = ($subtotal-$disc_bill)*$bb['svc']/100;
//				$tax = (($subtotal-$disc_bill) + $svc)*$bb['tax']/100;
				$disc_bill = round($disc_bill);	
				if($bb['takeaway'] == 'on'){
					$svc = 0;
				}else{
					if($_GET['svc'] != ''){
						$svc = ($subtotal-$disc_bill)*$_GET['svc']/100;
					}else{
						$svc = ($subtotal-$disc_bill)*$bb['svc']/100;
					}
				}
				$svc = round($svc);				
				if($_GET['tax'] != ''){
					$tax = (($subtotal-$disc_bill) + $svc)*$_GET['tax']/100;
				}else{
					$tax = (($subtotal-$disc_bill) + $svc)*$bb['tax']/100;
				}
				$tax = round($tax);
				$gt = ($subtotal-$disc_bill) + $svc + $tax;
				?>
				<table id="example2" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subtotal</th>
                                                <th>:</th>
                                                <th><?php echo number_format($subtotal);?>
                                                	<input id="subtotal" name="subtotal" type="hidden" value="<?php echo $subtotal; ?>" class="form-control" /></th>
                                          
                                            </tr>
                                           <tr>
                                                <th>Discount</th>
                                                <th>:</th>
                                                <th><?php echo number_format($disc_bill);?>
                                                <input id="disc_bill" name="disc_bill" type="hidden" value="<?php echo $disc_bill; ?>" class="form-control" /></th>
                                          
                                            </tr>
                                          <tr>
                                                <th>Service Charge</th>
                                                <th>:</th>
                                                <th><?php echo number_format($svc);?>
                                                <input id="svc" name="svc" type="hidden" value="<?php echo $svc; ?>" class="form-control" /></th>
                                          
                                            </tr>
                                          <tr>
                                                <th>Tax</th>
                                                <th>:</th>
                                                <th><?php echo number_format($tax);?>
                                                <input id="tax" name="tax" type="hidden" value="<?php echo $tax; ?>" class="form-control" /></th>
                                          
                                            </tr>
                                          <tr>
                                                <th>Grand Total</th>
                                                <th>:</th>
                                                <th><?php echo number_format($gt);?>
                                                	<input id="grand" name="grand" type="hidden" value="<?php echo $gt; ?>" class="form-control" /></th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>

		
                                        
                                           
                                        </tbody>
                                        
				</table>
				<!--div class="col-lg-12 col-md-6">
				<button class="btn btn-success btn-lg" onClick="previewBill('<?php echo $trx;?>','<?php echo $subtotal;?>','<?php echo $disc_bill;?>','<?php echo $svc;?>','<?php echo $tax;?>','<?php echo $gt;?>')">Preview Bill</button>

				<a href="themes/disc_bill.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
				
				<button class="btn btn-success btn-lg">Discount</button>
</a>
				<a href="themes/change_table.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
				
				<button class="btn btn-danger btn-lg">Change Table</button>
</a>
				<a href="themes/split_bill.php?trx=<?php echo $trx;?>&meja=<?php echo $meja;?>" class="fancybox fancybox.ajax">
				
				<button class="btn btn-danger btn-lg">Split Bill</button>
</a>			</div-->
				</div>		
					</div>	
				</div>	
				</div>	
				</div>
				
				<div class="col-lg-5 col-md-4">
					<div class="box-header">
						<h3 class="box-title">Grand Total : <?php echo number_format($gt);?><input id="gt" name="gt" type="hidden" value =" <?php echo round($gt);?>" class="form-control" /></h3>
					</div>
					<div class="box-body">
            
					
					<div class="callout callout-danger">
						<div id="pay_done">
						</div>		
						<div id="pay_notdone">						
					<div id="CASHDRAWER"></div>
		<div id="calculator">
		
			<div class="row">

	
	


 
    <!--script type="text/javascript">
    // if Google is down, it looks to local file...
    if (typeof jQuery == 'undefined') {
      document.write(unescape("%3Cscript src='jss/jquery-1.11.2.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
    </script>
    <script type="text/javascript" src="jss/clone-form-td-multiple.js"></script-->
	
       <div id="entry1" class="clonedInput_1">	
<div class="form-group">
                <label class="label_type control-label">Payment Type</label>
                <select class="input_type form-control" id="type_1" name="type_1">                                               
                            <option value="CSH">Cash</option>
							<option value="DBT">Debit</option>
                            <option value="CC">Credit</option>
                            <option value="VCH">Voucher</option>
                </select>										   
    </div>
	<div class="form-group" id="div_issuer">
                <label class="label_issuer control-label">Issuer</label>
                <select class="input_issuer form-control" id="bank_1" name="bank_1">
				<option value="">-------Pilih issuer-------</option>
	<?php $a = mysql_query("SELECT * FROM tblmasterissuer A,tblmasterbank B where A.status = 1 AND B.kode_issuer = A.kode_issuer ORDER BY A.nama_issuer,B.nama_bank");
	while($aa = mysql_fetch_assoc($a)){
		echo "<option value='".$aa['kode_bank'].".".$aa['nama_issuer'].".".$aa['nama_bank']."'>".$aa['nama_issuer']." - ".$aa['nama_bank']."</option>";
	}
	?>
                </select>										   
    </div>
	<div class="form-group" id="div_card"> <label class="label_email control-label" for="email_address">Card Number:</label>
            
            <input id="card_no" name="card_no" type="text" placeholder="Card Number" class="form-control" onkeypress="return isNumberKey(event);" onkeyup="return isNumberKey(event);"/>
            
    </div>
	<div class="form-group" id="div_vcr"> <label class="label_email control-label" for="email_address">Voucher Number:</label>
            
            <input id="vcr_no" name="vcr_no" type="text" onchange="cekVCH(this.value);" placeholder="Voucher Number" class="form-control" />
    </div>
        <!-- Text input-->
        
        <!-- Begin cloned email section -->
 
          <!-- Text input-->
          <label class="label_email control-label" for="email_address">Nominal:</label><div class="form-group">
            
            <input id="nominal_1" name="nominal_1" type="text" placeholder="Nominal" class="input_email form-control" onkeypress="return isNumberKey(event,this.value);" onkeyup="return isNumberKey(event,this.value);"/>
			<input id="sum" name="sum" type="hidden"  value="0" class="form-control"/>
			<input id="data" name="data" type="hidden" class="form-control"/>
			<input id="cnt" name="cnt" type="hidden" value ="0" class="form-control"/>
          </div>
        </div>
       <!-- end #entry1 -->
        <!-- Button (Double) -->
        <!--p>
        <button type="button" id="btnAdd_1" name="btnAdd" class="btn btn-primary">Other Payment Type</button>
          <button type="button" id="btnDel_1" name="btnDel" class="btn btn-danger"><span class="ui-button-text">Remove Payment</span></button>
        </p-->

        <!-- Begin cloned phone section -->

  
         <!-- Button -->
        <p>
          <button id="cancel_button" name="cancel_button" onclick="EmptyField();" class="btn btn-danger btn-lg">Cancel</button>
         
          <button id="submit_button" name="submit_button" onclick="myFunction();" class="btn btn-primary btn-lg">Add</button>
          <button id="pay_button" name="pay_button" class="btn btn-success btn-lg" onClick="doPayment();">Pay</button>
		  <h3 class="box-title">Bayar : <label id="lbl_sum" for="lbl_sum"></label> | Kembali : <label id="lbl_kembali" for="lbl_kembali"></label><input id="kembali" name="kembali" type="hidden" value ="0" class="form-control" /></h3>
        </p>
		<table class="table table-condensed">
		<th>Payment Type</th>
		<th>Nominal</th>
		<table id="myTable"  class="table table-condensed">
		</table>

    </div> 
				</div>
			</div> 
		</div>
		</div>



					
						
					<!--div class="box-footer">
						<button onClick="AddMenu('<?php echo $rd['kode_menu']; ?>','<?php echo $_SESSION['meja']; ?>','<?php echo $_SESSION['trx']; ?>')" class="btn btn-primary">Order</button>
						<button onClick="CancelMenu()" class="btn btn-primarys">Cancel</button>
					</div-->	
</div>					
							</div><!-- /.input group -->
						</div><!-- /.form group -->	
					</div>
				</div>
			
		
	</section>

 
		<script type="text/javascript" src="js/jquery.numpad.js"></script>


<script>
            $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
            $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
            $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
            $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
            $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
            $.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};

function cekVCH(e){
		$.ajax({
			type: "POST",
			url: "inc/check_vch.php",
			data: "action=checkVCH&cd="+e,
			cache: false,
			success: function(msg){
			//console.log(msg);
				alert(msg);
				if(msg > 0){
					$('#nominal_1').val(msg);
					$("#nominal_1").prop("readonly", true);
				}else{
					// Do Nothing
					$('#nominal_1').val('');
				}
		}});
			

	
}

function clearpay(){
		$('#sum').val('');
		$('#data').val('');
		$('#cnt').val('');
		var table = document.getElementById("myTable");
		var row = table.deleteRow(0);
}
function EmptyField(){
		$('#nominal_1').val('');
		$('#card_no').val('');
		$('#vcr_no').val('');
		$('#bank_1').val('');
		document.getElementById("type_1").disabled = false;
}
function doPayment(){
	var sub = $('#subtotal').val();
	var disc = $('#disc_bill').val();
	var svc = $('#svc').val();
	var tax = $('#tax').val();
	var grand = $('#grand').val();
	var qty = '<?php echo $qty_item; ?>';

	var kembali = $('#kembali').val();
	var trx = $('#trx').val();
	var meja = $('#meja').val();
	var data = $('#data').val();
	var cnt = $('#cnt').val();
		var konfirmasi=confirm("Apakah Anda yakin Melakukan Pembayaran Meja "+meja+" ? ");
		if (konfirmasi==true)
		{
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=doPayment&trx="+trx+"&meja="+meja+"&kembali="+kembali+"&cnt="+cnt+"&data="+data,
			cache: false,
			success: function(msg){
			console.log(msg);
				//alert("Pembayaran telah berhasil");
				//window.location.reload(true);
				$('#pay_done').css({'display':''});
				$('#pay_notdone').css({'display':'none'});
				$('#pay_done').load("inc/bill_success.php?trx="+trx+"&sub="+sub+"&disc="+disc+"&svc="+svc+"&tax="+tax+"&grand="+grand+"&pax="+qty);
				

		}});
/*    var printContent = document.getElementById('CASHDRAWER').innerHTML;
    var original = document.body.innerHTML;

    document.body.innerHTML = printContent;
    //alert("elelel");
    window.print();
    document.body.innerHTML = original;    			
*/		}

}
<!--
function isNumberKey(evt,val)
{
var charCode = (evt.which) ? evt.which : event.keyCode
//counts(val);
if (charCode > 31 && (charCode < 48 || charCode > 57))

return false;
return true;

}

function myFunction() {
	var cnt = $('#cnt').val();
	var one = 1;
	var sum = $('#sum').val();
	var kembali = $('#kembali').val();
	var type = $('#type_1').val();
	var nom = $('#nominal_1').val();
	var bank_data = $('#bank_1').val();
	if($('#card_no').val() == ''){
		var card_data = $('#vcr_no').val();
	}else{
		var card_data = $('#card_no').val();
	}
	var detail = '';
	var bank = '';
	if(nom == '' ){
		alert("Nominal tidak boleh kosong");
	}else{
		if($('#bank_1').val() != ''){
			var bank = ' ( '+$('#bank_1').val()+' )';
		}
		if(type == 'CC' || type == 'DBT' ){
			var detail = ' - '+$('#card_no').val();
		}else if(type == 'VCH'){
			var detail = ' - '+$('#vcr_no').val();
		}
		myData(type,bank_data,card_data,nom);
		sum = parseInt(sum) + parseInt($('#nominal_1').val());
		lblsum = sum.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		cnt = parseInt(cnt) + parseInt(one);
		kembali = parseInt($('#gt').val()) - parseInt(sum);
		lblkembali = (kembali*-1).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		var table = document.getElementById("myTable");
		var row = table.insertRow(0);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.innerHTML = type+bank+detail;
		cell2.innerHTML = nom;
		//alert(sum);
		$('#cnt').val(cnt);
		$('#sum').val(sum);
		$('#kembali').val(kembali);
		$('#lbl_kembali').text(lblkembali);
		$('#lbl_sum').text(lblsum);
		$('#nominal_1').val('');
		$('#card_no').val('');
		$('#vcr_no').val('');
		$('#bank_1').val('');
		disable_button(sum);
		document.getElementById("type_1").disabled = false;
		
	}
}
function disable_button(sum){
	if(sum >= $('#gt').val()){
		document.getElementById("pay_button").disabled = false;
		document.getElementById("submit_button").disabled = true; 
		//$('#pay_button').css({'display':''});
	}else{ 
		document.getElementById("pay_button").disabled = true; 
		
		//$('#pay_button').css({'display':'none'});
		
	}	
}
function myData(type,bank,detail,nom){
	var data = type+':'+bank+':'+detail+':'+nom+';';
 /* $('#data').val(data); */ document.getElementById("data").value += data;
	
}
function counts(nom){
	var gt = $('#gt').val();
	var nominal = $('#nominal_1').val();
	kembali = gt - nominal;
	var sum = $('#sum').val(kembali);
	}
//-->
	$(document).ready(function() {

			 $('#div_issuer').css({'display':'none'});
			 $('#pay_done').css({'display':'none'});
		 $('#div_vcr').css({'display':'none'});			 
		 $('#div_card').css({'display':'none'});
		// $('#pay_button').css({'display':'none'});
		document.getElementById("pay_button").disabled = true; 

        $('#nominal_1').numpad({
	        hidePlusMinusButton: true,
	        hideDecimalButton: true 
        });
        $('#card_no').numpad({
	        hidePlusMinusButton: true,
	        hideDecimalButton: true 
        });
   
		

	});	

$('#type_1').change(function() {
	 if ($(this).val() == 'CC' || $(this).val() == 'DBT'){
		 if($(this).val() == 'CC'){
			 $('#div_issuer').css({'display':''}); 
		 }else{
			 $('#div_issuer').css({'display':'none'});
		 }
		 
		 $('#div_card').css({'display':''});
		 $('#div_vcr').css({'display':'none'});			 
		
	 }else{
		 if($(this).val() == 'VCH'){
		 $('#div_vcr').css({'display':''});	 
		 }else{
		 $('#div_vcr').css({'display':'none'});			 
		 }
		 $('#div_issuer').css({'display':'none'});
		 $('#div_card').css({'display':'none'});
	 }
	document.getElementById("type_1").disabled = true;
});	
	function test(){
		alert("ckukuk");
	}

</script>	