<?php
session_start();
include"../inc/func.php";
include"../database.php";

$n = date("Y-m");
$nn = date("Y-m-d");
$now = $n.'-01';
$end = $nn;
?>
<head>
</head>
<div class="box-header">
    <h3 class="box-title">Report Menu</h3>
</div>
    <div class="box-body table-responsive">
		<div class="container-fluid">
			<div class="col-md-3">

            	<form action="themes/excel_report.php" method="POST">
                    <div class="form-group">
                            <label>From :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input  type="text" class="form-control pull-right" value="<?php echo $end;?>" name="start_date" id="start_date" readonly/>
                                                    </div><!-- /.input group -->
                     </div><!-- /.form group -->
                    <div class="form-group">
                            <label>To :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input  type="text" class="form-control pull-right" value="<?php echo $end;?>" name="end_date" id="end_date" readonly/>
                                                    </div><!-- /.input group -->
                     </div><!-- /.form group -->
                                                   <div class="form-group">
                                                        <label>Select Report</label>
                                                        <select  class="form-control" id="pilih" name="pilih">
                                                            <option value="4">Summary Consolidate Report</option>
                                                            
                                                            <option value="1">Detail Sales Analysis Report</option>
                                                            <option value="2">Hourly Sales Report</option>
                                                            <option value="3">Sales Audit Listing Report</option>
                                                            <option value="5">Fast Moving Items Report</option>
                                                            <option value="6">Detail Collection Report</option>
                                                            <!--option value="7">Report Transaksi Barang</option-->
                                                            <option value="8">Report Profit & Lost</option>
                                                            <option value="9">Report Booking Order</option>                                                
                                                       </select>
            										   
                    <div class="radio">
                    	<label class="">
                    	
                    	<input type="radio" name="optionsRadios" id="g_prd" value="g_prd" checked="checked" />
                    	Group by Product
                    	</label>
                    	

                    	<label class="">
                    	
                    	<input type="radio" name="optionsRadios" id="g_date" value="g_date" />
                    	Group by Date
                    	</label>
                    	
                    </div>
                    </div>
            		<div class="box-footer">
                        <?php if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_owner') == '1'){ ?>   
            			  <button type="submit" class="btn btn-primary btn-flat">EXCEL !</button>
                        <?php } ?>
                        <div class="btn btn-success btn-flat" onClick="PDFCreate();">PDF !</button></div>
						<div class="btn btn-success btn-flat" onClick="showReport();">Preview !</button></div>
                    </div>
            	</form>	
 						
	
        
        </div>
        <div class="col-md-9">
            <div id="report_preview"></div>
        </div>
    </div>	
</div>      

<script>
function showReport(){
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                var pilih = $('#pilih').val();

                $("#report_preview").load("themes/report_preview.php?start="+start+"&end="+end+"&pilih="+pilih);    
}
	$(document).ready(function() {
               $( "#start_date" ).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
				$( "#end_date" ).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
				$('.radio').hide();

                var start = $('#start_date').val();
                var end = $('#end_date').val();
                var pilih = $('#pilih').val();

                //$("#report_preview").load("themes/report_preview.php?start="+start+"&end="+end+"&pilih="+pilih);
		
	});
$('#pilih').change(function() {
	 if ($(this).val() == 7){
		 $('.radio').show(); 
	 }else{
		 $('.radio').hide();
	 }
 
});	

function PDFCreate(){
    //alert('alala');
    var pilih = $('#pilih').val();
    var start = $('#start_date').val();
    var end = $('#end_date').val();
    if(pilih == '' || start == '' || end == '' ){
        alert("Ada data yang kosong.");
    }else{
        window.location.href = "themes/pdf_report.php?pilih="+pilih+"&start="+start+"&end="+end;
    }
}
</script>
